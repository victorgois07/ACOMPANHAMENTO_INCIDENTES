<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BipCoiCodigoIc;

/**
 * Class BipCoiCodigoIcTransformer.
 *
 * @package namespace App\Transformers;
 */
class BipCoiCodigoIcTransformer extends TransformerAbstract
{
    /**
     * Transform the BipCoiCodigoIc entity.
     *
     * @param \App\Entities\BipCoiCodigoIc $model
     *
     * @return array
     */
    public function transform(BipCoiCodigoIc $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
