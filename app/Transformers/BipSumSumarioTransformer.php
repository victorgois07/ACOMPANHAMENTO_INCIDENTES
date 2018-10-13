<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BipSumSumario;

/**
 * Class BipSumSumarioTransformer.
 *
 * @package namespace App\Transformers;
 */
class BipSumSumarioTransformer extends TransformerAbstract
{
    /**
     * Transform the BipSumSumario entity.
     *
     * @param \App\Entities\BipSumSumario $model
     *
     * @return array
     */
    public function transform(BipSumSumario $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
