<?php

namespace Tests\Feature\Application;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Application\Enums\StatusLimiteGlobalEnum;
use App\Application\UseCases\AtribuirLimiteGlobal;
use App\Infra\Repositories\EloquentLimiteRepository;
use App\Domain\Entities\LimiteGlobal as LimiteGlobalEntity;

class AtribuirLimiteGlobalTest extends TestCase
{
    Use RefreshDatabase;
    /**
     * @dataProvider providerNovoLimite
     */
    public function testLimiteGlobal($cnpj_empresa, $limite) {
        $dados = [
            'cnpj_empresa' => $cnpj_empresa,
            'limite' =>  $limite
        ];
        $limiteRepository = new EloquentLimiteRepository();
        $limiteAtual = $limiteRepository->getLimite($cnpj_empresa);
        $limiteGlobalEntity = new LimiteGlobalEntity($dados);
        $atribuirLimiteGlobal = new AtribuirLimiteGlobal($limiteRepository, $limiteGlobalEntity);
        $novoLimite = $atribuirLimiteGlobal->atribuirLimitePorEmpresa();
        $valorLimiteAtual = $limiteAtual ? $limiteAtual->valorLimite : 0;
        $valorNovoLimite = $novoLimite ? $novoLimite->valorLimite : 0;
        $msg = "O limite global anterior (R$ {$valorLimiteAtual}) é igual ao novo limite implantado (R$ $valorNovoLimite).";
        $this->assertNotEquals($valorLimiteAtual, $valorNovoLimite, $msg);
        $msgLimiteCorreto = "O limite global informado foi de $limite e o limite retornado foi de $valorNovoLimite.";
        $this->assertEquals($limite, $valorNovoLimite, $msgLimiteCorreto);
    }

    /**
     * @dataProvider providerLimiteReprovado
     */
    public function testLimiteGlobalExcedido($cnpj_empresa, $limite) {
        $dados = [
            'cnpj_empresa' => $cnpj_empresa,
            'limite' =>  $limite
        ];
        $exceptionLimiteReprovado = StatusLimiteGlobalEnum::LIMITE_NAO_PERMITIDO->value;
        $this->expectExceptionMessage($exceptionLimiteReprovado);
        $limiteRepository = new EloquentLimiteRepository();
        $limiteGlobalEntity = new LimiteGlobalEntity($dados);
        $atribuirLimiteGlobal = new AtribuirLimiteGlobal($limiteRepository, $limiteGlobalEntity);
        $atribuirLimiteGlobal->atribuirLimitePorEmpresa();
    }

    public static function providerNovoLimite(){               
        return [
            'given_ExisteLimiteGlobal_When_AtribuirNovoLimite_Then_substituirLimite' => [
                'cnpj_empresa' => '37.740.396/0001-13',
                'limite' => 461
            ]
        ];
    }

    public static function providerLimiteReprovado(){               
        return [
            'given_LimiteNaoPermitido_When_AtribuirLimite_Then_LancaExcecao' => [
                'cnpj_empresa' => '37.740.396/0001-13',
                'limite' => 1000000
            ]
        ];
    }
}
