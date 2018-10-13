<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class BipHisHistorico.
 *
 * @package namespace App\Entities;
 */
class BipHisHistorico extends Model implements Transformable
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
    public $table = 'bip_his_historico';
    protected $fillable = ['his_decricao_problema','his_decricao_resolucao'];

}
