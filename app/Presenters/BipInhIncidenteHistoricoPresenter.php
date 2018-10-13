<?php

namespace App\Presenters;

use App\Transformers\BipInhIncidenteHistoricoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BipInhIncidenteHistoricoPresenter.
 *
 * @package namespace App\Presenters;
 */
class BipInhIncidenteHistoricoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BipInhIncidenteHistoricoTransformer();
    }
}
