<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Repositories\CouponRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Auth;
use Response;

class CouponController extends AppBaseController
{
    /** @var  CouponRepository */
    private $couponRepository;

    public function __construct(CouponRepository $couponRepo)
    {
        $this->couponRepository = $couponRepo;
    }

    /**
     * Display a listing of the Coupon.
     *
     * @param CouponDataTable $couponDataTable
     * @return Response
     */
    public function index(CouponDataTable $couponDataTable)
    {
        $user = Auth::user();
        return $couponDataTable->render('admin.coupons.index', compact('user'));
    }

    /**
     * Show the form for creating a new Coupon.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();
        return view('admin.coupons.create', compact('user'));
    }

    /**
     * Store a newly created Coupon in storage.
     *
     * @param CreateCouponRequest $request
     *
     * @return Response
     */
    public function store(CreateCouponRequest $request)
    {
        $input = $request->all();

        $coupon = $this->couponRepository->create($input);

        Flash::success('Cupom cadastrado com sucesso.');

        return redirect(route('admin.coupons.index'));
    }

    /**
     * Show the form for editing the specified Coupon.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $coupon = $this->couponRepository->find($id);

        if (empty($coupon)) {
            Flash::error('Cupom não encontrado');

            return redirect(route('admin.coupons.index'));
        }

        return view('admin.coupons.edit', compact('coupon', 'user'));
    }

    /**
     * Update the specified Coupon in storage.
     *
     * @param  int              $id
     * @param UpdateCouponRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCouponRequest $request)
    {
        $coupon = $this->couponRepository->find($id);

        if (empty($coupon)) {
            Flash::error('Cupom não encontrado');

            return redirect(route('admin.coupons.index'));
        }

        $coupon = $this->couponRepository->update($request->all(), $id);

        Flash::success('Cupom atualizado com sucesso.');

        return redirect(route('admin.coupons.index'));
    }

    /**
     * Remove the specified Coupon from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $coupon = $this->couponRepository->find($id);

        if (empty($coupon)) {
            Flash::error('Cupom não encontrado');

            return redirect(route('admin.coupons.index'));
        }

        $this->couponRepository->delete($id);

        Flash::success('Cupom excluído com sucesso.');

        return redirect(route('admin.coupons.index'));
    }
}
