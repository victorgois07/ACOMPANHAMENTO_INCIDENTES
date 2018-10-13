<?php

namespace App\Presenters;

use App\Transformers\BipPriPrioridadeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BipPriPrioridadePresenter.
 *
 * @package namespace App\Presenters;
 */
class BipPriPrioridadePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BipPriPrioridadeTransformer();
    }
}
