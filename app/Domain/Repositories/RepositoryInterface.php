<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\EntityInterface;

interface RepositoryInterface
{
    public function get($id);

    public function set(EntityInterface $entity);
}
