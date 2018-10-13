<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\BipHisHistorico;

/**
 * Class BipHisHistoricoTransformer.
 *
 * @package namespace App\Transformers;
 */
class BipHisHistoricoTransformer extends TransformerAbstract
{
    /**
     * Transform the BipHisHistorico entity.
     *
     * @param \App\Entities\BipHisHistorico $model
     *
     * @return array
     */
    public function transform(BipHisHistorico $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
