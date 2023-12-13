<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\LimiteGlobal;

interface LimiteGlobalRepository
{
    public function salvar(LimiteGlobal $limite);
    public function remover($id);
    public function getLimite($id);
}
