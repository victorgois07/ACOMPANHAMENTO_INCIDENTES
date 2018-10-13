<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BipInhIncidenteHistorico.
 *
 * @package namespace App\Entities;
 */
class BipInhIncidenteHistorico extends Model implements Transformable
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
    public $table = 'bip_inh_incidentes_historico';
    protected $fillable = ['inh_criado','inh_resolvido','inh_inc_incidente_id','inh_his_historico_id'];

}
