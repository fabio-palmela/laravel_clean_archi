<?php
namespace App\Domain\Repositories;

interface DbTransaction
{
    public function beginTransaction();

    public function commit();

    public function rollBack();
}
