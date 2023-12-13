<?php
namespace App\Adapters;

use App\Infra\Adapters\Eloquent\LimiteGlobalModel;

class LimiteGlobalAdapter
{
    public static function create(LimiteGlobalModel $limiteModel): object
    {
        $data = $limiteModel->toArray();
        // return [
        //     'limiteId' => $data['id'],
        //     'cnpjEmpresa' => $data['cnpj_empresa'],
        //     'valorLimite' => $data['limite'],
        // ];
        $adapter = new \stdClass();
        $adapter->limiteId = $data['id'];
        $adapter->cnpjEmpresa = $data['cnpj_empresa'];
        $adapter->valorLimite = $data['limite'];
        return $adapter;
    }
}
