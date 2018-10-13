<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BipIncIncidenteCreateRequest;
use App\Http\Requests\BipIncIncidenteUpdateRequest;
use App\Repositories\BipIncIncidenteRepository;
use App\Validators\BipIncIncidenteValidator;

/**
 * Class BipIncIncidentesController.
 *
 * @package namespace App\Http\Controllers;
 */
class BipIncIncidentesController extends Controller
{
    /**
     * @var BipIncIncidenteRepository
     */
    protected $repository;

    /**
     * @var BipIncIncidenteValidator
     */
    protected $validator;

    /**
     * BipIncIncidentesController constructor.
     *
     * @param BipIncIncidenteRepository $repository
     * @param BipIncIncidenteValidator $validator
     */
    public function __construct(BipIncIncidenteRepository $repository, BipIncIncidenteValidator $validator)
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
        $bipIncIncidentes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipIncIncidentes,
            ]);
        }

        return view('bipIncIncidentes.index', compact('bipIncIncidentes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BipIncIncidenteCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BipIncIncidenteCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bipIncIncidente = $this->repository->create($request->all());

            $response = [
                'message' => 'BipIncIncidente created.',
                'data'    => $bipIncIncidente->toArray(),
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
        $bipIncIncidente = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipIncIncidente,
            ]);
        }

        return view('bipIncIncidentes.show', compact('bipIncIncidente'));
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
        $bipIncIncidente = $this->repository->find($id);

        return view('bipIncIncidentes.edit', compact('bipIncIncidente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BipIncIncidenteUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BipIncIncidenteUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bipIncIncidente = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BipIncIncidente updated.',
                'data'    => $bipIncIncidente->toArray(),
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
                'message' => 'BipIncIncidente deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BipIncIncidente deleted.');
    }
}
