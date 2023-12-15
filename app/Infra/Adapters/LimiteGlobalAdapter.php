<?php
namespace App\Infra\Adapters;

use App\Infra\Eloquent\LimiteGlobalModel;

class LimiteGlobalAdapter
{
    public static function create(LimiteGlobalModel $limiteModel): object
    {
        $data = $limiteModel->toArray();
        $adapter = new \stdClass();
        $adapter->limiteId = $data['id'];
        $adapter->cnpjEmpresa = $data['cnpj_empresa'];
        $adapter->valorLimite = $data['limite'];
        return $adapter;
    }

    public static function fromArray(LimiteGlobalModel $limiteModel): array
    {
        $data = $limiteModel->toArray();
        return [
            'limiteId' => $data['id'],
            'cnpjEmpresa' => $data['cnpj_empresa'],
            'valorLimite' => $data['limite'],
        ];
    }
}
