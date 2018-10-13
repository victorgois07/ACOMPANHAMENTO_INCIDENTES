<?php

namespace App\Presenters;

use App\Transformers\BipHisHistoricoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BipHisHistoricoPresenter.
 *
 * @package namespace App\Presenters;
 */
class BipHisHistoricoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BipHisHistoricoTransformer();
    }
}
