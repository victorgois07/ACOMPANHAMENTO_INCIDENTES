<?php

namespace App\Presenters;

use App\Transformers\BipCoiCodigoIcTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BipCoiCodigoIcPresenter.
 *
 * @package namespace App\Presenters;
 */
class BipCoiCodigoIcPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BipCoiCodigoIcTransformer();
    }
}
