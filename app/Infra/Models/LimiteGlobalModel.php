<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class LimiteGlobalModel extends Model
{
    use SoftDeletes;

    protected $table = 'limite_global';
    
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'cnpj_empresa', 
        'limite'
    ];
}
