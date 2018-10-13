<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\bip_pri_prioridadeRepository;
use App\Entities\BipPriPrioridade;
use App\Validators\BipPriPrioridadeValidator;

/**
 * Class BipPriPrioridadeRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BipPriPrioridadeRepositoryEloquent extends BaseRepository implements BipPriPrioridadeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BipPriPrioridade::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BipPriPrioridadeValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
