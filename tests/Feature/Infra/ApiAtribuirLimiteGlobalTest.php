<?php

namespace Tests\Feature\Infra;

use Tests\TestCase;
use App\Infra\Models\User;
use App\Application\Enums\StatusLimiteGlobalEnum;
use App\Infra\Models\LimiteGlobalModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiAtribuirLimiteGlobalTest extends TestCase
{
    Use RefreshDatabase;
    /**
     * @dataProvider providerCriarLimite
     */
    public function testLimiteGlobal($body, $expected) {
        
        $response = $this->post('api/atribuir-limite', $body);
        
        $response->assertOk();
        
        $response->assertJson($expected);
        
        $this->assertDatabaseHas('limite_global', [
            'cnpj_empresa' => $body['cnpj_empresa'],
            'limite' => $body['limite'],
        ]);
    }

    /**
     * @dataProvider providerLimiteSubstituido
     */
    public function testLimiteGlobalSubstituido($limite_um, $limite_dois) {
        $user = User::factory()->create();

        $this->actingAs($user)->withSession(['banned' => false])->post('api/atribuir-limite', $limite_um);
        
        $resLimiteDois = $this->actingAs($user)->post('api/atribuir-limite', $limite_dois);
        $dataSegundoLimite = $resLimiteDois->json('content');
        
        $this->assertDatabaseHas('limite_global', [
            'cnpj_empresa' => $limite_dois['cnpj_empresa'],
            'limite' => $limite_dois['limite'],
        ]);
    }

    /**
     * @dataProvider providerLimiteReprovado
     */
    public function testLimiteGlobalExcedido($body, $expected) {
        $response = $this->post('api/atribuir-limite', $body);
        
        $response->assertInternalServerError();
        
        $response->assertJsonStructure($expected);
        
        $exceptionLimiteReprovado = StatusLimiteGlobalEnum::LIMITE_NAO_PERMITIDO->value;
        $messageError = $response->json('message');
        $this->assertStringContainsString($exceptionLimiteReprovado, $messageError);

    }

    public static function providerLimiteReprovado(){               
        return [
            'given_LimiteNaoPermitido_When_AtribuirLimite_Then_LancaExcecao' => [
                'body' => [
                    'cnpj_empresa' => '37.740.396/0001-13',
                    'limite' => 10000
                ],
                'expected' => [
                    'message'
                ]
            ]
        ];
    }

    public static function providerCriarLimite(){               
        return [
            'given_SolicitacaoLimite_When_AtribuirLimite_Then_CriarLimite' => [
                'body' => [
                    'cnpj_empresa' => '37.740.396/0001-13',
                    'limite' => 461
                ],
                'expected' => [
                    'content' => [
                        'cnpjEmpresa' => "37.740.396/0001-13",
                        'valorLimite' => 461
                    ]
                ]
            ]
        ];
    }

    public static function providerLimiteSubstituido(){               
        return [
            'given_ExisteLimite_When_AtribuirNovoLimite_Then_SubistituiLimite' => [
                'limite_um' => [
                    'cnpj_empresa' => '37.740.396/0001-13',
                    'limite' => 461
                ],
                'limite_dois' => [
                    'cnpj_empresa' => '37.740.396/0001-13',
                    'limite' => 462
                ]
            ]
        ];
    }
}
