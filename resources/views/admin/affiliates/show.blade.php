@extends('layouts.app')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Afiliado - {{ $affiliate->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.affiliates.index') }}">Afiliados</a></li>
                    <li class="breadcrumb-item active">{{ $affiliate->name }}</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('flash::message')
            </div>

            <div class="col-12">
                {!! Form::open(['id' => 'affiliate-search-form', 'route' => ['admin.affiliates.show', [$affiliate->id, ($page ?? 1)]], 'method' => 'get']) !!}
                <div class="d-flex align-items-end">
                    <div class="form-group d-inline-block mr-3">
                        {!! Form::label('year', 'Ano') !!}
                        {!! Form::select('year', $years, $year, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group d-inline-block mr-3">
                        {!! Form::label('month', 'Mês') !!}
                        {!! Form::select('month', select_months(), $month, ['placeholder' => 'Todos', 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group d-inline-block">
                        {!! Form::button('<i class="fas fa-search"></i>', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $affiliate->payments->count() }}</h3>

                                        <p>Total vendas ({{ $month ? select_months()[$month] . '/' : ''  }}{{ $year }})</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>
                                            <span
                                                style="font-size: 20px">R$</span> {{ number_format($affiliate->sumTotalSales(), 2, ',', '.') }}
                                        </h3>
                                        <p>Total receitas ({{ $month ? select_months()[$month] . '/' : ''  }}{{ $year }})</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>
                                            <span
                                                style="font-size: 20px">R$</span> {{ number_format(($affiliate->sumTotalSales() * ($affiliate->commission/100)), 2, ',', '.') }}
                                        </h3>
                                        <p>Total comissão ({{ $month ? select_months()[$month] . '/' : ''  }}{{ $year }})</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-cash"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>
                                            <span style="font-size: 20px">%</span> {{ number_format($affiliate->commission, 2, ',', '') }}
                                        </h3>
                                        <p>Comissão</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-star text-warning"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.affiliates.details_table')
                        <a href="{{ route('admin.affiliates.index') }}" class="btn btn-default">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
