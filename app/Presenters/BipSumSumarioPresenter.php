<?php

namespace App\Presenters;

use App\Transformers\BipSumSumarioTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BipSumSumarioPresenter.
 *
 * @package namespace App\Presenters;
 */
class BipSumSumarioPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BipSumSumarioTransformer();
    }
}
