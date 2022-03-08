@extends('layouts.master')

@section('breadcrumb')
    <div class="container">
        <div class="row">
            <div class="col-12 breadcrumb__wrapper">
                <h3 class="mb-0 text-center">RESULTADOS PARA "{{ $search }}"</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('pages.partials._lista-categorias')

    <section class="query-result__wrapper pb-5 container-lg">
        <div class="row">
            <div class="col-12">
                <div class="query-result__wrapper--content">
                    @forelse($result as $row)
                        <div class="card{{ (!$loop->last) ? ' mb-4' : '' }}">
                            <h5 class="card-header font-weight-bold">{{ $row->title }}</h5>
                            <div class="card-body">
                                @foreach($row->courses as $curso)
                                    <a href="{{ route('courses.course_details', [$row->slug, $curso->slug]) }}"
                                       class="d-block" title="{{ $curso->title }}">
                                        <div class="search-result-item">
                                            <div class="row">
                                                <div class="col-12 col-lg-4">
                                                    <div class="card-image-wrapper">
                                                        <img class="img-fluid d-block mb-3 mx-auto mb-lg-0"
                                                             src="{{ $curso->image }}"
                                                             alt="{{ $curso->title }}"
                                                             title="{{ $curso->title }}"/>
                                                    </div>
                                                </div>
                                                <div
                                                    class="col-12 col-lg-8 pl-lg-0 d-flex flex-column justify-content-center">
                                                    <h5 class="font-weight-bold">{{ $curso->title }}</h5>
                                                    <p class="card-text">
                                                        {{ substr($curso->description, 0, strpos(wordwrap($curso->description, 150), "\n")) . '...' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    @if(!$loop->last)
                                        <hr class="my-4 px-2"/>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="card">
                            <div class="card-body text-center d-flex align-items-center justify-content-center">
                                <h3 class="mb-0">NENHUM RESULTADO ENCONTRADO</h3>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
