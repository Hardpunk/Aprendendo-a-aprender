<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PlanDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Repositories\PlanRepository;
use Auth;
use Flash;
use Response;

class PlanController extends AppBaseController
{
    /** @var  PlanRepository */
    private $planRepository;

    /** @var months */
    private $months;

    public function __construct(PlanRepository $planRepo)
    {
        $arrayMonths = ['1' => 1, '2' => 2, '3' => 3, '6' => 6, '12' => 12];
        $this->planRepository = $planRepo;
        $this->months = $arrayMonths;
    }

    /**
     * Display a listing of the Plan.
     *
     * @param PlanDataTable $planDataTable
     * @return Response
     */
    public function index(PlanDataTable $planDataTable)
    {
        $user = Auth::user();
        return $planDataTable->render('plans.index', compact('user'));
    }

    /**
     * Show the form for creating a new Plan.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        $months = $this->months;
        return view('plans.create', compact('user', 'months'));
    }

    /**
     * Store a newly created Plan in storage.
     *
     * @param CreatePlanRequest $request
     *
     * @return Response
     */
    public function store(CreatePlanRequest $request)
    {
        $input = $request->all();
        $input['amount'] = str_replace(',', '.', str_replace('.', '', $input['amount']));
        $input['installment_amount'] = str_replace(',', '.', str_replace('.', '', $input['installment_amount']));

        $plan = $this->planRepository->create($input);

        Flash::success('Plano cadastrado com sucesso.');

        return redirect(route('admin.plans.index'));
    }

    /**
     * Display the specified Plan.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            Flash::error('Plano não encontrado');

            return redirect(route('admin.plans.index'));
        }

        return view('plans.show', compact('plan','user'));
    }

    /**
     * Show the form for editing the specified Plan.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $months = $this->months;
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            Flash::error('Plano não encontrado');

            return redirect(route('admin.plans.index'));
        }

        return view('plans.edit', compact('months','plan','user'));
    }

    /**
     * Update the specified Plan in storage.
     *
     * @param  int              $id
     * @param UpdatePlanRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePlanRequest $request)
    {
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            Flash::error('Plano não encontrado');

            return redirect(route('admin.plans.index'));
        }

        $input = $request->all();
        $input['amount'] = str_replace(',', '.', str_replace('.', '', $input['amount']));
        $input['installment_amount'] = str_replace(',', '.', str_replace('.', '', $input['installment_amount']));

        $plan = $this->planRepository->update($input, $id);

        Flash::success('Plano atualizado com sucesso.');

        return redirect(route('admin.plans.index'));
    }

    /**
     * Remove the specified Plan from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $plan = $this->planRepository->find($id);

        if (empty($plan)) {
            Flash::error('Plano não encontrado');

            return redirect(route('admin.plans.index'));
        }

        $this->planRepository->delete($id);

        Flash::success('Plano excluído com sucesso.');

        return redirect(route('admin.plans.index'));
    }
}
