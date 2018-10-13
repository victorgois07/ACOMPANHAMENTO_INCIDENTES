<?php

namespace App\Presenters;

use App\Transformers\BipEmpEmpresaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BipEmpEmpresaPresenter.
 *
 * @package namespace App\Presenters;
 */
class BipEmpEmpresaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BipEmpEmpresaTransformer();
    }
}
