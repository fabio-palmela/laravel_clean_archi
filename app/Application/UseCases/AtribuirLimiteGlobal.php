<?php
namespace App\Application\UseCases;

use App\Domain\Entities\LimiteGlobalInterface;
use App\Application\Enums\StatusLimiteGlobalEnum;
use App\Domain\Repositories\LimiteGlobalRepository;

class AtribuirLimiteGlobal
{
    private LimiteGlobalRepository $limiteGlobalRepository;
    private LimiteGlobalInterface $limiteGlobalEntity;

    public function __construct(
        LimiteGlobalRepository $limiteGlobalRepository,
        LimiteGlobalInterface $limiteGlobalEntity,
    ){
        $this->limiteGlobalRepository = $limiteGlobalRepository;
        $this->limiteGlobalEntity = $limiteGlobalEntity;
    }

    public function atribuirLimitePorEmpresa()
    {
        try {
            if ($this->limiteGlobalEntity->existeLimiteDisponivel()){
                $exceptionLimiteReprovado = StatusLimiteGlobalEnum::LIMITE_NAO_PERMITIDO->value;
                throw new \Exception($exceptionLimiteReprovado);
            }
            $limiteExistente = $this->existeLimiteGlobalGrupoEmpresas($this->limiteGlobalEntity);
            if ($limiteExistente){
                $novoLimite = $this->substituirLimite($this->limiteGlobalEntity, $limiteExistente->limiteId);
            } else {
                $novoLimite = $this->gerarNovoLimite($this->limiteGlobalEntity);                
            }
            
            return $novoLimite;
            
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
            return $novoLimite; 
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function gerarNovoLimite($limite)
    {
        try {
            $novoLimite = $this->criaLimiteGlobal($limite);
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
