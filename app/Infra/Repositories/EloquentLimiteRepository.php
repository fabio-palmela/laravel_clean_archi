<?php
namespace App\Infra\Repositories;

use App\Domain\Entities\LimiteGlobal;
use App\Domain\Repositories\LimiteGlobalRepository;
use App\Infra\Adapters\Eloquent\LimiteGlobalModel;
use App\Adapters\LimiteGlobalAdapter;

class EloquentLimiteRepository implements LimiteGlobalRepository
{
    public function salvar(LimiteGlobal $limite)
    {
        $novoLimite = LimiteGlobalModel::updateOrCreate(['id' => $limite->getId()], [
            'cnpj_empresa' => $limite->getEmpresa(),
            'limite' => $limite->getLimite(),
        ]);
        $dataLimiteGlobal = LimiteGlobalAdapter::create($novoLimite->first());
        // return $novoLimite;
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
        $dataLimiteGlobal = LimiteGlobalAdapter::create($limiteModel->first());
        return $dataLimiteGlobal;
    }
}
