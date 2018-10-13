<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\bip_his_historicoRepository;
use App\Entities\BipHisHistorico;
use App\Validators\BipHisHistoricoValidator;

/**
 * Class BipHisHistoricoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BipHisHistoricoRepositoryEloquent extends BaseRepository implements BipHisHistoricoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BipHisHistorico::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BipHisHistoricoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
