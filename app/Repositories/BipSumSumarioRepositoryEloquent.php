<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\bip_sum_sumarioRepository;
use App\Entities\BipSumSumario;
use App\Validators\BipSumSumarioValidator;

/**
 * Class BipSumSumarioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BipSumSumarioRepositoryEloquent extends BaseRepository implements BipSumSumarioRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BipSumSumario::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BipSumSumarioValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
