<?php 
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Presenters\XmlPresenter;
use App\Http\Controllers\Controller;
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
            return response()->json(['content' => $novoLimite], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro ao atribuir limite. Detalhes: ' . $th->getMessage()], 500);
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
            
            $xmlData = XmlPresenter::toXml(['content' => $novoLimite]);

            return response($xmlData, 200)
                ->header('Content-Type', 'application/xml');
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro ao atribuir limite. Detalhes: ' . $th->getMessage()], 500);
        }
    }
}
