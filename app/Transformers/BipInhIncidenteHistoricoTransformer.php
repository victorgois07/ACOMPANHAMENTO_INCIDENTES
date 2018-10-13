<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BipInhIncidenteHistorico;

/**
 * Class BipInhIncidenteHistoricoTransformer.
 *
 * @package namespace App\Transformers;
 */
class BipInhIncidenteHistoricoTransformer extends TransformerAbstract
{
    /**
     * Transform the BipInhIncidenteHistorico entity.
     *
     * @param \App\Entities\BipInhIncidenteHistorico $model
     *
     * @return array
     */
    public function transform(BipInhIncidenteHistorico $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
