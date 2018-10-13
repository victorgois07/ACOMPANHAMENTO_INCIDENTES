<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BipPriPrioridade;

/**
 * Class BipPriPrioridadeTransformer.
 *
 * @package namespace App\Transformers;
 */
class BipPriPrioridadeTransformer extends TransformerAbstract
{
    /**
     * Transform the BipPriPrioridade entity.
     *
     * @param \App\Entities\BipPriPrioridade $model
     *
     * @return array
     */
    public function transform(BipPriPrioridade $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
