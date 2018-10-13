<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BipGrsGrupoDesignado;

/**
 * Class BipGrsGrupoDesignadoTransformer.
 *
 * @package namespace App\Transformers;
 */
class BipGrsGrupoDesignadoTransformer extends TransformerAbstract
{
    /**
     * Transform the BipGrsGrupoDesignado entity.
     *
     * @param \App\Entities\BipGrsGrupoDesignado $model
     *
     * @return array
     */
    public function transform(BipGrsGrupoDesignado $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
