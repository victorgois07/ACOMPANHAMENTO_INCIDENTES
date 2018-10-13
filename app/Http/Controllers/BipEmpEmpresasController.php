<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BipEmpEmpresaCreateRequest;
use App\Http\Requests\BipEmpEmpresaUpdateRequest;
use App\Repositories\BipEmpEmpresaRepository;
use App\Validators\BipEmpEmpresaValidator;

/**
 * Class BipEmpEmpresasController.
 *
 * @package namespace App\Http\Controllers;
 */
class BipEmpEmpresasController extends Controller
{
    /**
     * @var BipEmpEmpresaRepository
     */
    protected $repository;

    /**
     * @var BipEmpEmpresaValidator
     */
    protected $validator;

    /**
     * BipEmpEmpresasController constructor.
     *
     * @param BipEmpEmpresaRepository $repository
     * @param BipEmpEmpresaValidator $validator
     */
    public function __construct(BipEmpEmpresaRepository $repository, BipEmpEmpresaValidator $validator)
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
        $bipEmpEmpresas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipEmpEmpresas,
            ]);
        }

        return view('bipEmpEmpresas.index', compact('bipEmpEmpresas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BipEmpEmpresaCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BipEmpEmpresaCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bipEmpEmpresa = $this->repository->create($request->all());

            $response = [
                'message' => 'BipEmpEmpresa created.',
                'data'    => $bipEmpEmpresa->toArray(),
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
        $bipEmpEmpresa = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipEmpEmpresa,
            ]);
        }

        return view('bipEmpEmpresas.show', compact('bipEmpEmpresa'));
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
        $bipEmpEmpresa = $this->repository->find($id);

        return view('bipEmpEmpresas.edit', compact('bipEmpEmpresa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BipEmpEmpresaUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BipEmpEmpresaUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bipEmpEmpresa = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BipEmpEmpresa updated.',
                'data'    => $bipEmpEmpresa->toArray(),
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
                'message' => 'BipEmpEmpresa deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BipEmpEmpresa deleted.');
    }
}
