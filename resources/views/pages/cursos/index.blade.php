@extends('layouts.master')

@section('breadcrumb')
    <div class="container">
        <div class="row">
            <div class="col-12 breadcrumb__wrapper">
                <h2 class="mb-0 p-0 text-center">CATEGORIAS DE CURSOS</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('pages.partials._lista-categorias')

    <section class="cursos pb-5 container-lg">
        <div id="customize-categorias" class="row py-3">
                @if(count($categorias) > 0)
                    @foreach($categorias as $categoria)
                        <div class="col-12 col-sm-6 col-md-4 category-item">
                            <div class="card">
                                <a class="url-curso" href="{{ route('courses.category', $categoria->slug) }}"
                                    title="{{ $categoria->title }}">
                                    <div class="card-img-top"
                                        style="background-image: url('{{ $categoria->image }}')">
                                    </div>
                                    <div class="card-body p-2">
                                        <h5 class="card-title">{{ $categoria->title }}</h5>
                                        <p class="card-text">
                                            {{ substr($categoria->description, 0, strpos(wordwrap($categoria->description, 70), "\n")) . '...' }}
                                        </p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                <div class="no-results">
                    <h4 class="text-center">NENHUMA CATEGORIA ENCONTRADA</h4>
                </div>
                @endif
            </div>
    </section>
@endsection
