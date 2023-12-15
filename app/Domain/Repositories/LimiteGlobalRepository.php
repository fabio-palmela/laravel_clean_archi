<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\LimiteGlobalInterface;

interface LimiteGlobalRepository
{
    public function salvar(LimiteGlobalInterface $limite);
    public function remover($id);
    public function getLimite($id);
}
