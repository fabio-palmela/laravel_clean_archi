<?php 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            $limiteRepository = new EloquentLimiteRepository();
            $limiteGlobalEntity = new LimiteGlobalEntity($dados);
            $atribuirLimiteGlobal = new AtribuirLimiteGlobal($limiteRepository, $limiteGlobalEntity);
            $novoLimite = $atribuirLimiteGlobal->atribuirLimitePorEmpresa();
            return response()->json(['content' => $novoLimite], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Erro ao atribuir limite. Detalhes: ' . $th->getMessage()], 500);
        }
    }
}
