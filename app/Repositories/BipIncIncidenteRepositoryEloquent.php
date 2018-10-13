<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\bip_inc_incidenteRepository;
use App\Entities\BipIncIncidente;
use App\Validators\BipIncIncidenteValidator;

/**
 * Class BipIncIncidenteRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BipIncIncidenteRepositoryEloquent extends BaseRepository implements BipIncIncidenteRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BipIncIncidente::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BipIncIncidenteValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
