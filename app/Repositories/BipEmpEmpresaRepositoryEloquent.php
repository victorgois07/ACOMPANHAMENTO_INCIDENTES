<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\bip_emp_empresaRepository;
use App\Entities\BipEmpEmpresa;
use App\Validators\BipEmpEmpresaValidator;

/**
 * Class BipEmpEmpresaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BipEmpEmpresaRepositoryEloquent extends BaseRepository implements BipEmpEmpresaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BipEmpEmpresa::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BipEmpEmpresaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
