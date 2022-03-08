<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Payment;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /** @var User $user */
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = $this->user;
        $payments = Payment::where('status', '=', 'paid')
            ->whereYear('created_at', '=', date('Y'))
            ->whereMonth('created_at', '=', date('m'));
        $paymentsTotalAmount = $payments->sum('amount');
        $paymentsCount = $payments->count();
        $registeredUsersCount = User::count();
        $enroledUsersCount = User::whereHas('payments.courses', function ($q) {
            $q->whereDate('payments.created_at', '>=', Carbon::now()->subMonth(2)->format('Y-m-d'));
        })->orWhereHas('payments.trails', function ($q) {
            $q->whereDate('payments.created_at', '>=', Carbon::now()->subMonth(3)->format('Y-m-d'));
        })
            ->groupBy('users.id')
            ->count();
        $totalAnualRevenue = $this->getAnualRevenue();
        $totalAnualSales = $this->getAnualSales();

        return view('home',
            compact('user', 'paymentsCount', 'paymentsTotalAmount', 'registeredUsersCount', 'enroledUsersCount',
                'totalAnualRevenue', 'totalAnualSales'));
    }

    /**
     * Get anual revenue by months
     *
     * @return array
     */
    private function getAnualRevenue(): array
    {
        $arrayMonths = [];
        foreach (range(1, 12) as $month) {
            $arrayMonths[$month] = ['month' => $month, 'monthlyAmount' => 0];
        }

        $today = Carbon::now();
        $firstDayOfYear = $today->copy()->startOfYear()->format('Y-m-d');
        $lastDayOfYear = $today->copy()->endOfYear()->format('Y-m-d');
        $arrayMonthlyRevenue = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as monthlyAmount')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$firstDayOfYear, $lastDayOfYear])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        return array_replace($arrayMonths, $arrayMonthlyRevenue);
    }

    /**
     * Get anual sales by months
     *
     * @return array
     */
    private function getAnualSales(): array
    {
        $arrayMonths = [];
        foreach (range(1, 12) as $month) {
            $arrayMonths[$month] = ['month' => $month, 'sales' => 0];
        }

        $today = Carbon::now();
        $firstDayOfYear = $today->copy()->startOfYear()->format('Y-m-d');
        $lastDayOfYear = $today->copy()->endOfYear()->format('Y-m-d');
        $arrayMonthlySales = Payment::selectRaw('MONTH(created_at) as month, count(*) as sales')
            ->where('status', 'paid')
            ->whereBetween('created_at', [$firstDayOfYear, $lastDayOfYear])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        return array_replace($arrayMonths, $arrayMonthlySales);
    }
}
