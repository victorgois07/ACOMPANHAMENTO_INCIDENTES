<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BipEmpEmpresa;

/**
 * Class BipEmpEmpresaTransformer.
 *
 * @package namespace App\Transformers;
 */
class BipEmpEmpresaTransformer extends TransformerAbstract
{
    /**
     * Transform the BipEmpEmpresa entity.
     *
     * @param \App\Entities\BipEmpEmpresa $model
     *
     * @return array
     */
    public function transform(BipEmpEmpresa $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
