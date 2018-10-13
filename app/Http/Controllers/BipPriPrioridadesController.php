<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\BipPriPrioridadeCreateRequest;
use App\Http\Requests\BipPriPrioridadeUpdateRequest;
use App\Repositories\BipPriPrioridadeRepository;
use App\Validators\BipPriPrioridadeValidator;

/**
 * Class BipPriPrioridadesController.
 *
 * @package namespace App\Http\Controllers;
 */
class BipPriPrioridadesController extends Controller
{
    /**
     * @var BipPriPrioridadeRepository
     */
    protected $repository;

    /**
     * @var BipPriPrioridadeValidator
     */
    protected $validator;

    /**
     * BipPriPrioridadesController constructor.
     *
     * @param BipPriPrioridadeRepository $repository
     * @param BipPriPrioridadeValidator $validator
     */
    public function __construct(BipPriPrioridadeRepository $repository, BipPriPrioridadeValidator $validator)
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
        $bipPriPrioridades = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipPriPrioridades,
            ]);
        }

        return view('bipPriPrioridades.index', compact('bipPriPrioridades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BipPriPrioridadeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(BipPriPrioridadeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $bipPriPrioridade = $this->repository->create($request->all());

            $response = [
                'message' => 'BipPriPrioridade created.',
                'data'    => $bipPriPrioridade->toArray(),
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
        $bipPriPrioridade = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $bipPriPrioridade,
            ]);
        }

        return view('bipPriPrioridades.show', compact('bipPriPrioridade'));
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
        $bipPriPrioridade = $this->repository->find($id);

        return view('bipPriPrioridades.edit', compact('bipPriPrioridade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BipPriPrioridadeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(BipPriPrioridadeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $bipPriPrioridade = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'BipPriPrioridade updated.',
                'data'    => $bipPriPrioridade->toArray(),
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
                'message' => 'BipPriPrioridade deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'BipPriPrioridade deleted.');
    }
}
