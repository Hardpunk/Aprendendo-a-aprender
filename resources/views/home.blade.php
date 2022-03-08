@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            @if (session('status'))
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <div class="col-lg-3 col-sm-6 col-12">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $paymentsCount }}</h3>

                        <p>Total vendas ({{ ucfirst(strftime('%B')) }})</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('admin.payments.index') }}" class="small-box-footer">Mais informações <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-sm-6 col-12">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><span
                                style="font-size: 20px">R$</span> {{ number_format($paymentsTotalAmount, 2, ',', '.') }}
                        </h3>
                        <p>Total receitas ({{ ucfirst(strftime('%B')) }})</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{ route('admin.payments.index') }}" class="small-box-footer">Mais informações <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-sm-6 col-12">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $registeredUsersCount }}</h3>
                        <p>Usuários registrados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">Mais informações <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-sm-6 col-12">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $enroledUsersCount }}</h3>
                        <p>Alunos matriculados</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-university"></i>
                    </div>
                    <a href="{{ route('admin.users.registered') }}" class="small-box-footer">Mais informações <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

            <div class="clearfix"></div>

            @if(count($totalAnualRevenue) > 0)
                <div class="col-12 col-lg-6">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title text-bold">RECEITA ANUAL ({{ date('Y') }})</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="anualRevenue"
                                    style="width: 100%;max-width: 100%;min-height: 300px;max-height: 300px;"
                                    height="300"></canvas>
                        </div>
                    </div>
                </div>
            @endif

            @if(count($totalAnualSales) > 0)
                <div class="col-12 col-lg-6">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title text-bold">TOTAL VENDAS ANUAL ({{ date('Y') }})</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="anualSales"
                                    style="width: 100%;max-width: 100%;min-height: 300px;max-height: 300px;"
                                    height="300"></canvas>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        let anualRevenueChart, anualSalesChart;
        let arrayMonths = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro',
            'Novembro', 'Dezembro',
        ];
        let options = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                xAxes: [
                    {
                        gridLines: {
                            display: true,
                        },
                    },
                ],
                yAxes: [
                    {
                        gridLines: {
                            display: true,
                        },
                    },
                ],
            },
        };

        function createAnualRevenuesChart() {
            let areaChartAnualRevenueCanvas = $('#anualRevenue').get(0).getContext('2d');
            let areaChartAnualRevenueData = {
                labels: arrayMonths,
                datasets: [
                    {
                        label: 'Total receita mensal',
                        borderColor: 'rgba(40,167,69,0.8)',
                        backgroundColor: 'rgba(40,167,69,0.2)',
                        borderWidth: 2,
                        pointColor: '#28a745',
                        pointBackgroundColor: '#28a745',
                        pointStrokeColor: 'rgba(40,167,69,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(40,167,69,1)',
                        data: [{{ implode(',', array_map(function($item) { return $item['monthlyAmount']; }, $totalAnualRevenue)) }}],
                    },
                ],
            };
            let areaChartAnualRevenueOptions = _.merge({}, options, {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return 'Total: R$ ' + tooltipItem.yLabel.toFixed(2).toString().replace('.', ',');
                        },
                    },
                },
                scales: {
                    yAxes: {
                        [0]: {
                            ticks: {
                                beginAtZero: true,
                                stepSize: 10,
                                maxTicksLimit: 10,
                                callback: function(value, index, values) {
                                    return 'R$ ' + value;
                                },
                            },
                        },
                    },
                },
            });

            anualRevenueChart = new Chart(areaChartAnualRevenueCanvas, {
                type: 'line',
                data: areaChartAnualRevenueData,
                options: areaChartAnualRevenueOptions,
            });
        }

        function createAnualSalesChart() {
            let areaChartAnualSalesCanvas = $('#anualSales').get(0).getContext('2d');
            let areaChartAnualSalesData = {
                labels: arrayMonths,
                datasets: [
                    {
                        label: 'Total vendas mensais',
                        borderColor: 'rgba(60,141,188,0.8)',
                        backgroundColor: 'rgba(60,141,188,0.2)',
                        borderWidth: 2,
                        lineTension: 0,
                        pointColor: '#3b8bba',
                        pointBackgroundColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [{{ implode(',', array_map(function($item) { return $item['sales']; }, $totalAnualSales)) }}],
                    },
                ],
            };
            let areaChartAnualSalesOptions = _.merge({}, options, {
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return 'Total: ' + tooltipItem.yLabel;
                        },
                    },
                },
                scales: {
                    yAxes: {
                        [0]: {
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1,
                                maxTicksLimit: 10,
                            },
                        },
                    },
                },
            });

            anualSalesChart = new Chart(areaChartAnualSalesCanvas, {
                type: 'line',
                data: areaChartAnualSalesData,
                options: areaChartAnualSalesOptions,
            });
        }

        function initCharts() {
            createAnualRevenuesChart();
            createAnualSalesChart();
        }

        $(function() {
            initCharts();
        });
    </script>
@endpush
