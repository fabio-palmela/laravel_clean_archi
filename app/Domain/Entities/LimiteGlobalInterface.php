<?php
namespace App\Domain\Entities;

interface LimiteGlobalInterface
{
    public function getId();

    public function getEmpresa();

    public function getLimite();

    public function existeLimiteDisponivel();
    
    public function setEmpresa($cnpj);

    public function setLimite($limite);
}
