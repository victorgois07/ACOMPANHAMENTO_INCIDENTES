<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\bip_grs_grupo_designadoRepository;
use App\Entities\BipGrsGrupoDesignado;
use App\Validators\BipGrsGrupoDesignadoValidator;

/**
 * Class BipGrsGrupoDesignadoRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BipGrsGrupoDesignadoRepositoryEloquent extends BaseRepository implements BipGrsGrupoDesignadoRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BipGrsGrupoDesignado::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return BipGrsGrupoDesignadoValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
