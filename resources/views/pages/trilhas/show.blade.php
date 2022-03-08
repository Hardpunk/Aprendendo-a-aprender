@extends('layouts.master')

@section('breadcrumb')
    <div class="container">
        <div class="row">
            <div class="col-12 breadcrumb__wrapper">
                <h6 class="title title--secondary m-0">
                    <a href="{{ route('home') }}">TRILHA DO CONHECIMENTO</a> &gt;
                    <span class="title-curso active">{{ mb_strtoupper($trilha->title) }}</span>
                </h6>
            </div>
            <div class="col-12">
                <h2 class="title-curso text-center mb-3">{{ mb_strtoupper($trilha->title) }}</h2>
            </div>
            <div class="col-12">
                <h6 class="text-center">
                    Preparamos uma <strong>TRILHA DO CONHECIMENTO</strong> para você aumentar suas habilidades ou conquistá-las.
                </h6>
                <h5 class="text-center mt-3 mb-0">
                    VEJA OS TREINAMENTOS E FAÇA SUA INSCRIÇÃO
                </h5>
            </div>
        </div>
    </div>
@endsection


@section('content')
    <section id="trail__wrapper">
        <div class="card-floating__fix">
            <div id="card-floating" class="d-none d-md-block">
                <div class="card-floating__inner">
                    <div class="card card-floating__content">
                        {{--<div class="discount">
                            <span class="percentage">{{ number_format($trilha->discount, 0) }}%</span>
                        </div>--}}
                        <div class="price__wrapper pt-3 mb-4">
                            <div class="price__wrapper--content">
                                <p class="price mb-0">
                                    <em class="price-discount">R$ {{ number_format(((100 - $trilha->discount) / 100) * $trilha->price, 2, ',', '.') }}</em>
                                    <em class="price-installments">
                                        <span>
                                            <span> 10x de </span>
                                            <label class="price-discounted">R$ {{ number_format((((100 - $trilha->discount) / 100) * $trilha->price)/10, 2, ',', '.') }}</label>
                                            <span> ou</span>
                                        </span>
                                    </em>
                                </p>
                                {{-- <p class="price-cash text-center">Preço a vista:<strong>R$ 269,99</strong></p> --}}
                            </div>
                        </div>
                        <div class="checkout-button__wrapper">
                            <form id="add-to-cart" action="{{ action('CartController@add') }}" method="POST" role="form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $trilha->id }}" />
                                <input type="hidden" name="type" value="trail" />
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
        <div class="trail-course-details__wrapper py-4">
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
                                                    <img class="img-fluid rounded" src="{{ asset($trilha->cover_details) }}" />
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
                                                            <h6 class="font-weight-bold m-0">{{ $trilha->courses()->sum('hours') }} Horas</h6>
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
                                                <p class="m-0 font-weight-bold">CURSO ONLINE DE</p>
                                                <h3 class="font-weight-bolder">{{ mb_strtoupper($trilha->title) }}</h3>
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
        </div>

        @include('pages.trilhas._trail-courses')

        @include('pages.trilhas._trail-price')

        @include('pages.trilhas._trail-skills')
    </section>

    @include('pages.partials._faq')
@endsection

@section('js')
    <script src="{{ asset('js/ResizeSensor.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky-sidebar.min.js') }}"></script>
@endsection
