<?php 
namespace App\Presentation\Http\Controllers\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Presentation\Presenters\XmlPresenter;
use App\Presentation\Presenters\JsonPresenter;
use App\Presentation\Http\Controllers\Controller;
use App\Infra\Repositories\LaravelTransaction;
use App\Application\UseCases\AtribuirLimiteGlobal;
use App\Infra\Repositories\EloquentLimiteRepository;
use App\Domain\Entities\LimiteGlobal as LimiteGlobalEntity;

class LimiteGlobalController extends Controller
{

    public function __construct()
    {
        
    }

    public function atribuirLimite(Request $request)
    {
        try {
            $dados = $request->validate([
                'cnpj_empresa' => 'required|string',
                'limite' => 'required|numeric',
            ]);
            $LaravelTransaction = new LaravelTransaction();
            $limiteRepository = new EloquentLimiteRepository();
            $limiteGlobalEntity = new LimiteGlobalEntity($dados);
            $atribuirLimiteGlobal = new AtribuirLimiteGlobal($limiteRepository, $limiteGlobalEntity, $LaravelTransaction);
            $novoLimite = $atribuirLimiteGlobal->atribuirLimitePorEmpresa();
            $data_presenter = [
                "msg" => "Novo Limite criado com sucesso.", 
                "content" => $novoLimite,
                "status" => Response::HTTP_OK
            ];
            return JsonPresenter::output($data_presenter);
        } catch (\Throwable $th) {
            $msgError = [
                "msg" => "Erro ao atribuir limite. Detalhes: ". $th->getMessage(),
                "content" => [],
                "status" => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
            return JsonPresenter::output($msgError);
        }
    }

    public function atribuirLimiteXml(Request $request)
    {
        try {
            $dados = $request->validate([
                'cnpj_empresa' => 'required|string',
                'limite' => 'required|numeric',
            ]);
            $LaravelTransaction = new LaravelTransaction();
            $limiteRepository = new EloquentLimiteRepository();
            $limiteGlobalEntity = new LimiteGlobalEntity($dados);
            $atribuirLimiteGlobal = new AtribuirLimiteGlobal($limiteRepository, $limiteGlobalEntity, $LaravelTransaction);
            $novoLimite = $atribuirLimiteGlobal->atribuirLimitePorEmpresa();
            $data_presenter = [
                "msg" => "Novo Limite criado com sucesso.", 
                "content" => $novoLimite,
                "status" => Response::HTTP_OK
            ];
            return XmlPresenter::output($data_presenter);

        } catch (\Throwable $th) {
            $msgError = [
                "msg" => 'Erro ao atribuir limite. Detalhes: ' . $th->getMessage(),
                "content" => [],
                "status" => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
            return XmlPresenter::output($msgError);
        }
    }
}
