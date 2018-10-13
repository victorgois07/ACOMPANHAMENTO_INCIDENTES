<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BipCoiCodigoIcCreateRequest;
use App\Http\Requests\BipCoiCodigoIcUpdateRequest;
use App\Repositories\BipCoiCodigoIcRepository;
use App\Validators\BipCoiCodigoIcValidator;

/**
 * Class BipCoiCodigoIcsController.
 *
 * @package namespace App\Http\Controllers;
 */
class BipCoiCodigoIcsController extends Controller
{
    /**
     * @var BipCoiCodigoIcRepository
     */
    protected $repository;

    /**
     * @var BipCoiCodigoIcValidator
     */
    protected $validator;

    /**
     * BipCoiCodigoIcsController constructor.
     *
     * @param BipCoiCodigoIcRepository $repository
     * @param BipCoiCodigoIcValidator $validator
     */
    public function __construct(BipCoiCodigoIcRepository $repository, BipCoiCodigoIcValidator $validator)
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
        $bipCoiCodigoIcs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipCoiCodigoIcs,
            ]);
        }

        return view('bipCoiCodigoIcs.index', compact('bipCoiCodigoIcs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BipCoiCodigoIcCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BipCoiCodigoIcCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bipCoiCodigoIc = $this->repository->create($request->all());

            $response = [
                'message' => 'BipCoiCodigoIc created.',
                'data'    => $bipCoiCodigoIc->toArray(),
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
        $bipCoiCodigoIc = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipCoiCodigoIc,
            ]);
        }

        return view('bipCoiCodigoIcs.show', compact('bipCoiCodigoIc'));
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
        $bipCoiCodigoIc = $this->repository->find($id);

        return view('bipCoiCodigoIcs.edit', compact('bipCoiCodigoIc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BipCoiCodigoIcUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BipCoiCodigoIcUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bipCoiCodigoIc = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BipCoiCodigoIc updated.',
                'data'    => $bipCoiCodigoIc->toArray(),
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
                'message' => 'BipCoiCodigoIc deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BipCoiCodigoIc deleted.');
    }
}
