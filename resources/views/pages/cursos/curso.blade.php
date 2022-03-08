@extends('layouts.master')

@section('breadcrumb')
    <div class="container">
        <div class="row">
            <div class="col-12 breadcrumb__wrapper">
                <h6 class="title title--secondary m-0">
                    <a href="{{ route('courses.index') }}">CATEGORIAS DE CURSOS</a> &gt;
                    <a href="{{ route('courses.category', $categoria->slug) }}">{{ \Str::upper($categoria->title) }}</a>
                    >
                    <span
                        class="title-curso active">{{ strpos(mb_strtolower($curso->title), 'curso de') === 0 ? str_replace('CURSO DE', '', mb_strtoupper($curso->title)) : mb_strtoupper($curso->title) }}</span>
                </h6>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-alternative mt-3 pb-4">
        <div class="row">
            <div class="col-12">
                <h2 class="title-curso text-center mb-0">
                    {{ strpos(mb_strtolower($curso->title), 'curso de') === 0 ? str_replace('CURSO DE', '', mb_strtoupper($curso->title)) : mb_strtoupper($curso->title) }}
                </h2>
                <h4 class="text-center mt-3 mb-0">{{ $curso->students }} alunos inscritos</h4>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <section id="course__wrapper">
        <div class="card-floating__fix">
            <div id="course-card-floating" class="d-none d-md-block">
                <div class="card-floating__inner">
                    <div class="card card-floating__content">
                        {{--<div class="discount">
                            <span
                                class="percentage">{{ number_format(($curso->price / $curso->old_price) * 100, 0) }}%</span>
                        </div>--}}
                        <div class="course-details__wrapper pt-3 text-center">
                            <p class="category-title m-0">{{ $categoria->title }}</p>
                            <p class="course-title m-0">
                                {{ strpos(mb_strtolower($curso->title), 'curso de') === 0 ? str_replace('curso de', '', mb_strtoupper($curso->title)) : $curso->title }}
                            </p>
                        </div>
                        <div class="price__wrapper pt-3 mb-4">
                            <div class="price__wrapper--content">
                                <p class="price mb-0">
                                    <em class="price-discount">R$ {{ number_format($curso->price, 2, ',', '.') }}</em>
                                    <em class="price-installments">
                                        <span>
                                            <span> 10x de </span>
                                            <label class="price-discounted">R$
                                                {{ number_format($curso->price / 10, 2, ',', '.') }}</label>
                                            <span> ou</span>
                                        </span>
                                    </em>
                                </p>
                                {{-- <p class="price-cash text-center">Preço a
                                    vista:<strong>R$ 269,99</strong></p> --}}
                            </div>
                        </div>
                        <div class="checkout-button__wrapper">
                            <form id="add-to-cart" action="{{ action('CartController@add') }}" method="POST" role="form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $curso->id }}" />
                                <input type="hidden" name="type" value="course" />
                                <button type="button" data-loading-text="<i class='fas fa-spinner fa-spin mr-2'></i>Aguarde..."
                                    style="display: {{ $in_cart ? 'none' : 'block' }};"
                                    class="btn btn-large checkout-button waves-effect waves-light mx-auto font-weight-bold">COMPRAR</button>
                                <a href="{{ route('checkout.index') }}" data-loading-text="<i class='fas fa-spinner fa-spin mr-2'></i>Aguarde..."
                                    style="display: {{ $in_cart ? 'block' : 'none' }};"
                                    class="btn btn-large go-checkout-button waves-effect waves-light mx-auto font-weight-bold">FINALIZAR COMPRA</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="course-details__wrapper py-5">
            <div class="container">
                <div class="course-details__wrapper--content">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            @include('pages.cursos._lista-categorias')

                            <div class="course-details-box__wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row flex-align align-items-center mb-3">
                                            <div class="col-12 col-md-6 mb-4 mb-md-3">
                                                <div class="course-details-box__wrapper--image text-center">
                                                    <img class="img-fluid shadow" src="{{ $curso->image }}" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 text-center mb-4 mb-md-3">
                                                <div class="row flex-align">
                                                    <div class="col-4">
                                                        <div class="icon mb-2">
                                                            <i class="far fa-3x fa-clock"></i>
                                                        </div>
                                                        <div class="description mb-1">
                                                            <span>Carga Horária</span>
                                                        </div>
                                                        <div class="text-highlight">
                                                            <h6 class="font-weight-bold m-0">{{ $curso->hours }} Horas</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="icon mb-2">
                                                            <i class="fas fa-3x fa-award"></i>
                                                        </div>
                                                        <div class="description mb-1">
                                                            <span>Certificado</span>
                                                        </div>
                                                        <div class="text-highlight">
                                                            <h6 class="font-weight-bold m-0">Autorizado MEC</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="icon mb-2">
                                                            <i class="fas fa-3x fa-tv"></i>
                                                        </div>
                                                        <div class="description mb-1">
                                                            <span>Vídeo aula</span>
                                                        </div>
                                                        <div class="text-highlight">
                                                            <h6 class="font-weight-bold m-0">100% HD</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="course-details-box__wrapper--text">
                                            <div class="course-title mb-3">
                                                <h6 class="font-weight-bold mb-3">
                                                    {{ mb_strtoupper($curso->category_title) }}</h6>
                                                <p class="m-0 font-weight-bold">Curso online de</p>
                                                <h5 class="font-weight-bolder">
                                                    {{ strpos(mb_strtolower($curso->title), 'curso de') === 0 ? str_replace('CURSO DE', '', mb_strtoupper($curso->title)) : mb_strtoupper($curso->title) }}
                                                </h5>
                                            </div>
                                            <div class="course-text-description">
                                                <p class="m-0 text-justify course-description">{{ $curso->description }}</p>
                                                <p class="btn-show-more text-center mt-2 closed">
                                                    <small class="font-weight-bold">VISUALIZAR MAIS <i
                                                            class="fas fa-angle-down"></i><i
                                                            class="fas fa-angle-up"></i></small>
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
        </div>

        @include('pages.cursos._course-topics')

        @if($curso->teacher_image)
            @include('pages.cursos._course-teacher')
        @endif

        @include('pages.cursos._course-price')
    </section>

    @include('pages.partials._faq')
@endsection

@section('js')
    <script src="{{ asset('js/ResizeSensor.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky-sidebar.min.js') }}"></script>
@endsection
