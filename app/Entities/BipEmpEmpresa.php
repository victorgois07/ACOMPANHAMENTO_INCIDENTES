<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BipEmpEmpresa.
 *
 * @package namespace App\Entities;
 */
class BipEmpEmpresa extends Model implements Transformable
{
    use SoftDeletes;
    use Notifiable;
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;
    public $table = 'bip_emp_empresa';
    protected $fillable = ['emp_descricao'];

}
