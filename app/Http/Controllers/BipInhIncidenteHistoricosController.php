<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BipInhIncidenteHistoricoCreateRequest;
use App\Http\Requests\BipInhIncidenteHistoricoUpdateRequest;
use App\Repositories\BipInhIncidenteHistoricoRepository;
use App\Validators\BipInhIncidenteHistoricoValidator;

/**
 * Class BipInhIncidenteHistoricosController.
 *
 * @package namespace App\Http\Controllers;
 */
class BipInhIncidenteHistoricosController extends Controller
{
    /**
     * @var BipInhIncidenteHistoricoRepository
     */
    protected $repository;

    /**
     * @var BipInhIncidenteHistoricoValidator
     */
    protected $validator;

    /**
     * BipInhIncidenteHistoricosController constructor.
     *
     * @param BipInhIncidenteHistoricoRepository $repository
     * @param BipInhIncidenteHistoricoValidator $validator
     */
    public function __construct(BipInhIncidenteHistoricoRepository $repository, BipInhIncidenteHistoricoValidator $validator)
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
        $bipInhIncidenteHistoricos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipInhIncidenteHistoricos,
            ]);
        }

        return view('bipInhIncidenteHistoricos.index', compact('bipInhIncidenteHistoricos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BipInhIncidenteHistoricoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BipInhIncidenteHistoricoCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bipInhIncidenteHistorico = $this->repository->create($request->all());

            $response = [
                'message' => 'BipInhIncidenteHistorico created.',
                'data'    => $bipInhIncidenteHistorico->toArray(),
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
        $bipInhIncidenteHistorico = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipInhIncidenteHistorico,
            ]);
        }

        return view('bipInhIncidenteHistoricos.show', compact('bipInhIncidenteHistorico'));
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
        $bipInhIncidenteHistorico = $this->repository->find($id);

        return view('bipInhIncidenteHistoricos.edit', compact('bipInhIncidenteHistorico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BipInhIncidenteHistoricoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BipInhIncidenteHistoricoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bipInhIncidenteHistorico = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BipInhIncidenteHistorico updated.',
                'data'    => $bipInhIncidenteHistorico->toArray(),
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
                'message' => 'BipInhIncidenteHistorico deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BipInhIncidenteHistorico deleted.');
    }
}
