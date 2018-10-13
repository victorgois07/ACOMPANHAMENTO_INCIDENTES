<?php

namespace App\Presenters;

use App\Transformers\BipIncIncidenteTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BipIncIncidentePresenter.
 *
 * @package namespace App\Presenters;
 */
class BipIncIncidentePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BipIncIncidenteTransformer();
    }
}
