<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BipGrsGrupoDesignadoCreateRequest;
use App\Http\Requests\BipGrsGrupoDesignadoUpdateRequest;
use App\Repositories\BipGrsGrupoDesignadoRepository;
use App\Validators\BipGrsGrupoDesignadoValidator;

/**
 * Class BipGrsGrupoDesignadosController.
 *
 * @package namespace App\Http\Controllers;
 */
class BipGrsGrupoDesignadosController extends Controller
{
    /**
     * @var BipGrsGrupoDesignadoRepository
     */
    protected $repository;

    /**
     * @var BipGrsGrupoDesignadoValidator
     */
    protected $validator;

    /**
     * BipGrsGrupoDesignadosController constructor.
     *
     * @param BipGrsGrupoDesignadoRepository $repository
     * @param BipGrsGrupoDesignadoValidator $validator
     */
    public function __construct(BipGrsGrupoDesignadoRepository $repository, BipGrsGrupoDesignadoValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $bipGrsGrupoDesignados = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipGrsGrupoDesignados,
            ]);
        }

        return view('bipGrsGrupoDesignados.index', compact('bipGrsGrupoDesignados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BipGrsGrupoDesignadoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BipGrsGrupoDesignadoCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bipGrsGrupoDesignado = $this->repository->create($request->all());

            $response = [
                'message' => 'BipGrsGrupoDesignado created.',
                'data'    => $bipGrsGrupoDesignado->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bipGrsGrupoDesignado = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipGrsGrupoDesignado,
            ]);
        }

        return view('bipGrsGrupoDesignados.show', compact('bipGrsGrupoDesignado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bipGrsGrupoDesignado = $this->repository->find($id);

        return view('bipGrsGrupoDesignados.edit', compact('bipGrsGrupoDesignado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BipGrsGrupoDesignadoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BipGrsGrupoDesignadoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bipGrsGrupoDesignado = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BipGrsGrupoDesignado updated.',
                'data'    => $bipGrsGrupoDesignado->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'BipGrsGrupoDesignado deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BipGrsGrupoDesignado deleted.');
    }
}
