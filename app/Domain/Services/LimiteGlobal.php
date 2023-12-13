<?php
namespace App\Domain\Services;

use App\Domain\Entities\LimiteGlobal as LimiteGlobalEntity;
use App\Domain\Repositories\LimiteGlobalRepository;

class LimiteGlobal
{
    private float $limiteGlobal;
    private LimiteGlobalRepository $limiteGlobalRepository;

    public function __construct(LimiteGlobalRepository $limiteGlobalRepository)
    {
        $this->limiteGlobalRepository = $limiteGlobalRepository;
    }
    public function incluirLimiteGlobal(LimiteGlobalEntity $limite)
    {
        try {
            $limiteExistente = $this->existeLimiteGlobalGrupoEmpresas($limite);
            if ($limiteExistente){
                $novoLimiteGlobal = $this->substituirLimite($limite, $limiteExistente->id);
            } else {
                $novoLimiteGlobal = $this->gerarNovoLimite($limite);                
            }
            return $novoLimiteGlobal;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function existeLimiteGlobalGrupoEmpresas($limite)
    {
        return $this->limiteGlobalRepository->getLimite($limite->getEmpresa());
    }

    public function substituirLimite($limite, $limiteId)
    {
        try {
            $this->desativaLimiteGlobalAnterior($limiteId);
            $novoLimite = $this->criaLimiteGlobal($limite);
            // $this->relacionaModalidadesDoLimite();
            // $this->atribuiLimiteAempresasDoGrupo();
            return $novoLimite; 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function gerarNovoLimite($limite)
    {
        try {
            $novoLimite = $this->criaLimiteGlobal($limite);
            // $this->relacionaModalidadesDoLimite();
            // $this->atribuiLimiteAempresasDoGrupo();
            return $novoLimite;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function criaLimiteGlobal($limite)
    {
        return $this->limiteGlobalRepository->salvar($limite);
    }

    public function desativaLimiteGlobalAnterior(int $id)
    {
        $this->limiteGlobalRepository->remover($id);
    }
}
