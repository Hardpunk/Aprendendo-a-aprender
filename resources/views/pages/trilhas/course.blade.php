@extends('layouts.master')

@section('breadcrumb')
    <div class="container">
        <div class="row">
            <div class="col-12 breadcrumb__wrapper">
                <h6 class="title title--secondary m-0">
                    <a href="{{ route('home') }}">TRILHA DO CONHECIMENTO</a> &gt;
                    <a href="{{ route('trails.show', [$trilha->slug]) }}">{{ mb_strtoupper($trilha->title) }}</a> &gt;
                    <span class="title-curso active">{{ mb_strtoupper($trilha->courses[0]->title) }}</span>
                </h6>
            </div>
            <div class="col-12">
                <h2 class="title-curso text-center mb-3">{{ mb_strtoupper($trilha->courses[0]->title) }}</h2>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section class="trail-course-details__wrapper py-5">
        <div class="container">
            <div class="trail-course-details__wrapper--content">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="course-details-box__wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row flex-align align-items-center mb-3">
                                        <div class="col-12 col-md-6 mb-4 mb-md-3">
                                            <div class="course-details-box__wrapper--image text-center">
                                                <img class="img-fluid shadow" src="{{ $trilha->courses[0]->image }}" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 text-center mb-4 mb-md-3">
                                            <div class="row flex-align align-items-center">
                                                <div class="col-4">
                                                    <div class="icon mb-2">
                                                        <i class="far fa-3x fa-clock"></i>
                                                    </div>
                                                    <div class="description mb-1">
                                                        <span>Carga Horária</span>
                                                    </div>
                                                    <div class="text-highlight">
                                                        <h6 class="font-weight-bold m-0">{{ $trilha->courses[0]->hours }} Horas</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="icon mb-2">
                                                        <i class="fas fa-3x fa-award"></i>
                                                    </div>
                                                    <div class="text-highlight">
                                                        <h6 class="font-weight-bold m-0">Com certificado</h6>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="icon mb-2">
                                                        <i class="fas fa-3x fa-tv"></i>
                                                    </div>
                                                    <div class="description mb-1">
                                                        <span>100%</span>
                                                    </div>
                                                    <div class="text-highlight">
                                                        <h6 class="font-weight-bold m-0">Vídeo aula</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="course-details-box__wrapper--text">
                                        <div class="course-title mb-3">
                                            <h6 class="font-weight-bold mb-3">{{ mb_strtoupper($trilha->courses[0]->category_title) }}</h6>
                                            <p class="m-0 font-weight-bold">Curso online de</p>
                                            <h5 class="font-weight-bolder">{{ mb_strtoupper($trilha->courses[0]->title) }}</h5>
                                        </div>
                                        <div class="course-text-description">
                                            <p class="m-0 text-justify course-description">{{ $trilha->courses[0]->description }}</p>
                                            <p class="btn-show-more text-center mt-2 closed">
                                                <small class="font-weight-bold">VISUALIZAR MAIS <i class="fas fa-angle-down"></i><i class="fas fa-angle-up"></i></small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="trail-course-topics__wrapper py-5 text-white">
        <div class="container">
            <div class="trail-course-topics__wrapper--content">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <div class="topics-title mb-4">
                            <h5 class="font-weight-bold m-0">O QUE VOU APRENDER?</h5>
                        </div>
                        <div class="topics-description__wrapper">
                        @if(count($topics = json_decode($trilha->courses[0]->topics)) > 0)
                            <div class="topics-description {{ count($topics) > 4 ? 'topics-truncate' : 'd-none' }}">
                            @foreach($topics as $topic)
                                <h6>
                                    <span class="font-weight-bold">{{ $loop->iteration }} - </span>{{ $topic }}
                                </h6>
                            @endforeach
                            </div>
                            <p class="btn-show-more text-center mt-2 closed">
                                <small class="font-weight-bold">VISUALIZAR MAIS <i class="fas fa-angle-down"></i><i class="fas fa-angle-up"></i></small>
                            </p>
                        @endif
                        </div>
                    </div>
                    <div class="col-md-4 d-none d-md-block">

                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('pages.partials._faq')
@endsection
