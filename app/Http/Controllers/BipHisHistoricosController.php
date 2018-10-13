<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BipHisHistoricoCreateRequest;
use App\Http\Requests\BipHisHistoricoUpdateRequest;
use App\Repositories\BipHisHistoricoRepository;
use App\Validators\BipHisHistoricoValidator;

/**
 * Class BipHisHistoricosController.
 *
 * @package namespace App\Http\Controllers;
 */
class BipHisHistoricosController extends Controller
{
    /**
     * @var BipHisHistoricoRepository
     */
    protected $repository;

    /**
     * @var BipHisHistoricoValidator
     */
    protected $validator;

    /**
     * BipHisHistoricosController constructor.
     *
     * @param BipHisHistoricoRepository $repository
     * @param BipHisHistoricoValidator $validator
     */
    public function __construct(BipHisHistoricoRepository $repository, BipHisHistoricoValidator $validator)
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
        $bipHisHistoricos = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipHisHistoricos,
            ]);
        }

        return view('bipHisHistoricos.index', compact('bipHisHistoricos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BipHisHistoricoCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BipHisHistoricoCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bipHisHistorico = $this->repository->create($request->all());

            $response = [
                'message' => 'BipHisHistorico created.',
                'data'    => $bipHisHistorico->toArray(),
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
        $bipHisHistorico = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipHisHistorico,
            ]);
        }

        return view('bipHisHistoricos.show', compact('bipHisHistorico'));
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
        $bipHisHistorico = $this->repository->find($id);

        return view('bipHisHistoricos.edit', compact('bipHisHistorico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BipHisHistoricoUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BipHisHistoricoUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bipHisHistorico = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BipHisHistorico updated.',
                'data'    => $bipHisHistorico->toArray(),
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
                'message' => 'BipHisHistorico deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BipHisHistorico deleted.');
    }
}
