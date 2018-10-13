<?php

namespace App\Presenters;

use App\Transformers\BipGrsGrupoDesignadoTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BipGrsGrupoDesignadoPresenter.
 *
 * @package namespace App\Presenters;
 */
class BipGrsGrupoDesignadoPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BipGrsGrupoDesignadoTransformer();
    }
}
