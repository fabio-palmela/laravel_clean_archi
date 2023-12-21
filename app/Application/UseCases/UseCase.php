<?php
namespace App\Application\UseCases;

use App\Domain\Entities\EntityInterface;
use App\Domain\Repositories\RepositoryInterface;
class UseCase
{
    private EntityInterface $entity;
    private RepositoryInterface $repository;
    public function __construct($entity, $repository){
        $this->entity = $entity;
        $this->repository = $repository;
    }

}
