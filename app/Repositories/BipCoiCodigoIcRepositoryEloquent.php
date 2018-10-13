<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\bip_coi_codigo_icRepository;
use App\Entities\BipCoiCodigoIc;
use App\Validators\BipCoiCodigoIcValidator;

/**
 * Class BipCoiCodigoIcRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BipCoiCodigoIcRepositoryEloquent extends BaseRepository implements BipCoiCodigoIcRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BipCoiCodigoIc::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BipCoiCodigoIcValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
