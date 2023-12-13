<?php
namespace App\Domain\Entities;

class LimiteGlobal implements LimiteGlobalInterface
{
    private $id;
    private $limite;
    private $cnpjEmpresa;
    private $limitePermitido = 5000;

    public function __construct($data)
    {
        $this->cnpjEmpresa = $data['cnpj_empresa'];
        $this->limite = $data['limite'];
    }

    public function getId(){
        return $this->id;
    }

    public function getEmpresa(){
        return $this->cnpjEmpresa;
    }

    public function getLimite(){
        return $this->limite;
    }

    public function existeLimiteDisponivel(){
        return ($this->limitePermitido - $this->limite) <= 0;
    }
    
    public function setEmpresa($cnpj){
        $this->cnpjEmpresa = $cnpj;
    }

    public function setLimite($limite){
        $this->limite = $limite;
    }
}
