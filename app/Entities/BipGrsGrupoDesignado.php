<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BipGrsGrupoDesignado.
 *
 * @package namespace App\Entities;
 */
class BipGrsGrupoDesignado extends Model implements Transformable
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
    public $table = 'bip_grs_grupo_designado';
    protected $fillable = ['grs_descricao','grs_emp_empresa_id'];

}
