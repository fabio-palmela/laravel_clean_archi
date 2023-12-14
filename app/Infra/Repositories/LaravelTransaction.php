<?php
namespace App\Infra\Repositories;

use Illuminate\Support\Facades\DB;
use App\Domain\Repositories\DbTransaction;

class LaravelTransaction implements DbTransaction
{
    public function beginTransaction(){
        DB::beginTransaction();
    }

    public function commit(){
        DB::commit();
    }

    public function rollBack(){
        DB::rollBack();
    }
}
