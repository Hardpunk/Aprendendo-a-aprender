@extends('layouts.master')

@section('breadcrumb')
    <div class="container">
        <div class="row">
            <div class="col-12 breadcrumb__wrapper">
                <h6 class="title title--secondary m-0">
                    <a href="{{ route('courses.index') }}">CATEGORIAS DE CURSOS</a> >
                    <span>{{ \Str::upper($categoria->title) }}</span>
                </h6>
            </div>
            <div class="col-12">
                <h2 class="title-categoria-curso text-center mb-0">
                    {{ \Str::upper($categoria->title) }}
                </h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('pages.partials._lista-categorias')

    <section class="categorias pb-5 container-lg">
        <div id="customize-categorias" class="row py-3">
                @if (count($cursos) > 0)
                    @foreach ($cursos as $curso)
                        <div class="col-12 col-sm-6 col-md-4 category-item">
                            <div class="card">
                                <a class="url-curso"
                                    href="{{ route('courses.course_details', [$categoria->slug, $curso->slug]) }}"
                                    title="{{ $curso->title }}">
                                    <div class="card-img-top" style="background-image: url('{{ $curso->image }}')">
                                    </div>
                                    <div class="card-body p-2">
                                        <h5 class="card-title">{{ $curso->title }}</h5>
                                        <p class="card-text">
                                            {{ substr($curso->description, 0, strpos(wordwrap($curso->description, 70), "\n")) . '...' }}
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
