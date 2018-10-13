<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BipSumSumarioCreateRequest;
use App\Http\Requests\BipSumSumarioUpdateRequest;
use App\Repositories\BipSumSumarioRepository;
use App\Validators\BipSumSumarioValidator;

/**
 * Class BipSumSumariosController.
 *
 * @package namespace App\Http\Controllers;
 */
class BipSumSumariosController extends Controller
{
    /**
     * @var BipSumSumarioRepository
     */
    protected $repository;

    /**
     * @var BipSumSumarioValidator
     */
    protected $validator;

    /**
     * BipSumSumariosController constructor.
     *
     * @param BipSumSumarioRepository $repository
     * @param BipSumSumarioValidator $validator
     */
    public function __construct(BipSumSumarioRepository $repository, BipSumSumarioValidator $validator)
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
        $bipSumSumarios = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipSumSumarios,
            ]);
        }

        return view('bipSumSumarios.index', compact('bipSumSumarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BipSumSumarioCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BipSumSumarioCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bipSumSumario = $this->repository->create($request->all());

            $response = [
                'message' => 'BipSumSumario created.',
                'data'    => $bipSumSumario->toArray(),
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
        $bipSumSumario = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipSumSumario,
            ]);
        }

        return view('bipSumSumarios.show', compact('bipSumSumario'));
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
        $bipSumSumario = $this->repository->find($id);

        return view('bipSumSumarios.edit', compact('bipSumSumario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BipSumSumarioUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BipSumSumarioUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bipSumSumario = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BipSumSumario updated.',
                'data'    => $bipSumSumario->toArray(),
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
                'message' => 'BipSumSumario deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BipSumSumario deleted.');
    }
}
