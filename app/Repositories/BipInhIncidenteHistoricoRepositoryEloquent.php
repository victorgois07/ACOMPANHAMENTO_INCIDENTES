<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\bip_inh_incidente_historicoRepository;
use App\Entities\BipInhIncidenteHistorico;
use App\Validators\BipInhIncidenteHistoricoValidator;

/**
 * Class BipInhIncidenteHistoricoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BipInhIncidenteHistoricoRepositoryEloquent extends BaseRepository implements BipInhIncidenteHistoricoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BipInhIncidenteHistorico::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BipInhIncidenteHistoricoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
