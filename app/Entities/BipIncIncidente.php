<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BipIncIncidente.
 *
 * @package namespace App\Entities;
 */
class BipIncIncidente extends Model implements Transformable
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
    public $table = 'bip_inc_incidentes';
    protected $fillable = ['inc_codigo_incidente','inc_sum_sumario_id','inc_grs_grupo_designado_id','inc_pri_prioridade_id','inc_coi_codigo_ic_id'];

}
