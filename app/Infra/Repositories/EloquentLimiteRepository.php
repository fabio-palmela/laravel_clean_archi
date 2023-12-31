<?php
namespace App\Infra\Repositories;

use App\Domain\Entities\LimiteGlobalInterface;
use App\Domain\Repositories\LimiteGlobalRepository;
use App\Infra\Models\LimiteGlobalModel;
use App\Infra\Adapters\LimiteGlobalAdapter;

class EloquentLimiteRepository implements LimiteGlobalRepository
{
    public function salvar(LimiteGlobalInterface $limite)
    {
        $novoLimite = LimiteGlobalModel::updateOrCreate(['id' => $limite->getId()], [
            'cnpj_empresa' => $limite->getEmpresa(),
            'limite' => $limite->getLimite(),
        ]);
        $dataLimiteGlobal = LimiteGlobalAdapter::create($novoLimite->first());
        return $dataLimiteGlobal;
    }

    public function remover($limiteId)
    {
        $limiteModel = LimiteGlobalModel::find($limiteId);
        $limiteModel->delete();  
    }

    public function getLimite($cnpj)
    {
        $limiteModel = LimiteGlobalModel::where('cnpj_empresa', $cnpj);
        if ($limiteModel->first()){
            return LimiteGlobalAdapter::create($limiteModel->first());
        } 
        return false;
    }
}
