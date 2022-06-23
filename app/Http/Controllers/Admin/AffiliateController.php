<?php

namespace App\Http\Controllers\Admin;

use App\Affiliate;
use App\DataTables\AffiliateDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateAffiliateRequest;
use App\Http\Requests\UpdateAffiliateRequest;
use App\Repositories\AffiliateRepository;
use Auth;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class AffiliateController extends AppBaseController
{
    /** @var  AffiliateRepository */
    private $affiliateRepository;

    public function __construct(AffiliateRepository $affiliateRepo)
    {
        $this->affiliateRepository = $affiliateRepo;
    }

    /**
     * Display a listing of the Affiliate.
     *
     * @param AffiliateDataTable $affiliateDataTable
     * @return Response
     */
    public function index(AffiliateDataTable $affiliateDataTable)
    {
        $user = Auth::user();
        return $affiliateDataTable->render('admin.affiliates.index', compact('user'));
    }

    /**
     * Show the form for creating a new Affiliate.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('admin.affiliates.create', compact('user'));
    }

    /**
     * Store a newly created Affiliate in storage.
     *
     * @param CreateAffiliateRequest $request
     *
     * @return Response
     */
    public function store(CreateAffiliateRequest $request)
    {
        $input = $request->all();

        $affiliate = $this->affiliateRepository->create($input);

        Flash::success('Afiliado criado com sucesso.');

        return redirect(route('admin.affiliates.index'));
    }

    /**
     * Display the specified Affiliate.
     *
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(int $id, Request $request)
    {
        $user = Auth::user();
        $affiliate = $this->affiliateRepository->find($id);

        if (empty($affiliate)) {
            Flash::error('Afiliado não encontrado.');

            return redirect(route('admin.affiliates.index'));
        }

        $years = DB::table('payments')
            ->selectRaw("YEAR(created_at) as 'years'")
            ->groupBy('years')
            ->pluck('years', 'years');

        $year = $request->get('year', date('Y'));
        $month = $request->get('month');

        $affiliate = Affiliate::with([
            'payments' => function ($q) use ($year, $month) {
                $q->whereYear('payments.created_at', $year);
                if (!is_null($month)) {
                    $q->whereMonth('payments.created_at', $month);
                }
                return $q;
            },
            'payments.user',
            'payments.trails',
            'payments.courses'
        ])
            ->where('id', $id)
            ->first();

        return view('admin.affiliates.show', compact('affiliate', 'month', 'user', 'year', 'years'));
    }

    /**
     * Show the form for editing the specified Affiliate.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $affiliate = $this->affiliateRepository->find($id);

        if (empty($affiliate)) {
            Flash::error('Afiliado não encontrado.');

            return redirect(route('admin.affiliates.index'));
        }

        return view('admin.affiliates.edit', compact('affiliate', 'user'));
    }

    /**
     * Update the specified Affiliate in storage.
     *
     * @param int $id
     * @param UpdateAffiliateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAffiliateRequest $request)
    {
        $affiliate = $this->affiliateRepository->find($id);
        if (empty($affiliate)) {
            Flash::error('Afiliado não encontrado.');

            return redirect(route('admin.affiliates.index'));
        }

        $affiliate = $this->affiliateRepository->update($request->all(), $id);

        Flash::success('Afiliado atualizado com sucesso.');
        return redirect(route('admin.affiliates.index'));
    }

    /**
     * Remove the specified Affiliate from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $affiliate = $this->affiliateRepository->find($id);

        if (empty($affiliate)) {
            Flash::error('Afiliado não encontrado.');

            return redirect(route('admin.affiliates.index'));
        }

        $this->affiliateRepository->delete($id);

        Flash::success('Afiliado excluído com sucesso.');

        return redirect(route('admin.affiliates.index'));
    }
}
