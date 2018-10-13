<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BipIncIncidente;

/**
 * Class BipIncIncidenteTransformer.
 *
 * @package namespace App\Transformers;
 */
class BipIncIncidenteTransformer extends TransformerAbstract
{
    /**
     * Transform the BipIncIncidente entity.
     *
     * @param \App\Entities\BipIncIncidente $model
     *
     * @return array
     */
    public function transform(BipIncIncidente $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
