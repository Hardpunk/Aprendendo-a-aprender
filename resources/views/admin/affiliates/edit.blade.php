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
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @include('adminlte-templates::common.errors')
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
						{!! Form::model($affiliate, ['route' => ['admin.affiliates.update', $affiliate->id], 'method' => 'patch']) !!}
						@include('admin.affiliates.fields')
						{!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
