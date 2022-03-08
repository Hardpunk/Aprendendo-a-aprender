@php
    $cookie = json_decode(\Cookie::get('cart'), true);
    $cart = ['items' => [], 'total' => 0];
    if ($cookie !== null && count($cookie) > 0) {
        foreach ($cookie as $type => $items) {
            foreach ($items as $item) {
                if ($type === 'trail') {
                    $cart_item = \App\Trail::find($item);
                    $cart_item->price = round($cart_item->price * (1 - $cart_item->discount / 100), 2);
                } else {
                    $cart_item = \App\Course::find($item);
                }

                $cart['items'][] = $cart_item;
                $cart['total'] += $cart_item->price;
            }
        }
    }
@endphp
<div class="container-fluid">
    <div class="menu d-none d-md-block">
        <div class="row d-flex align-items-center px-lg-3 py-3">
            <div class="col-md-5 col-xl-2 text-center text-xl-left">
                <a class="navbar-brand" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="logo img-fluid"/>
                </a>
            </div>
            <div class="col-md-7 col-xl-4">
                <div class="search-wrapper mb-0 d-flex justify-content-center">
                    <form action="{{ route('search') }}" method="GET" role="search" class="form-search-box">
                        <input autocomplete="off" type="text" class="form-control search-input" name="q"/>
                        <div class="placeholder">
                            <div>
                                <p>O que você quer apreender?</p>
                            </div>
                        </div>
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-md-12 col-xl-6">
                <ul class="navbar-nav float-right flex-row align-items-center mb-xl-1">
                    <li class="nav-item {{ Request::is('/*') ? 'active' : '' }}">
                        <a href="/" class="nav-link">Início</a>
                    </li>

                    <li class="nav-item {{ Request::is('cursos*') ? 'active' : '' }}">
                        <a href="/cursos" class="nav-link">Cursos</a>
                    </li>

                    <li class="nav-item">
                        <a href="/#contato__wrapper" class="nav-link">Contato</a>
                    </li>

                    <li class="nav-item">
                        @if (Auth::user())
                            <a href="{{ route('user.logout') }}" class="nav-link"
                               onclick="event.preventDefault(); document.getElementById('logout-aluno').submit();">
                                Sair
                            </a>
                            <form id="logout-aluno" action="{{ route('user.logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('user.home') }}" class="nav-link">Entrar</a>
                        @endif
                    </li>

                    <li class="nav-item cart-button {{ count($cart['items']) > 0 ? 'has-items' : '' }}">
                        <span class="nav-link cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-items">{{ count($cart['items']) }}</span>
                            @if (count($cart['items']) > 0)
                                <span class="arrow-down">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            @endif
                        </span>

                        <div class="cart-details__wrapper" style="display: none;">
                            <div class="cart-loading align-items-center justify-content-center h-100 w-100"
                                 style="display: none;">
                                <i class="fa-4x fas fa-spinner fa-pulse"></i>
                            </div>
                            <div class="card cart-details__wrapper--content shadow-none">
                                <div class="card-body">
                                    @foreach ($cart['items'] as $item)
                                        <div class="cart-item__box">
                                            <a href="/{{ $item->category_slug ? "cursos/{$item->category_slug}" : 'trilhas-conhecimento' }}/{{ $item->slug }}"
                                               class="cart-item__link">
                                                <div class="row align-items-center mx-0">
                                                    <div
                                                        class="col-1 d-flex align-items-center justify-content-center px-0 text-center">
                                                        <span class="remove-cart-item text-center" title="Remover item"
                                                              data-item-type="{{ $item->course_id ? 'course' : 'trail' }}"
                                                              data-item-id="{{ $item->id }}">
                                                            <i class="fas fa-times red-text"></i>
                                                        </span>
                                                    </div>
                                                    <div class="col-5 pr-0">
                                                        <div class="item-image">
                                                            <img class="img-fluid"
                                                                 src="{{ $item->image ?: $item->cover_details ?? '' }}"
                                                                 title="{{ $item->title }}"
                                                                 alt="{{ $item->title }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="item-description">
                                                            <p class="area-category-title mb-0">
                                                                {{ $item->category_title ?: 'Trilha' }}</p>
                                                            <p class="item-title mb-0">
                                                                {{ mb_strtoupper($item->title) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-11 offset-1">
                                                        <p class="mb-0 item-price">R$
                                                            {{ number_format($item->price, 2, ',', '.') }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="cart-checkout">
                                    <p class="text-center font-weight-bolder mb-0"><span
                                            class="black-text">Total:</span> 10x de R$<span
                                            class="subtotal">{{ number_format(round($cart['total'] / 10, 2), 2, ',', '.') }}</span>
                                    </p>
                                    <a href="{{ route('checkout.index') }}"
                                       class="btn btn-large checkout-button waves-effect waves-light mx-auto font-weight-bold">Finalizar
                                        compra</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="https://www.sie.com.br/institutoacesso" class="nav-link sie-button">Área do aluno</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <nav class="navbar-class navbar navbar-expand-md navbar-default d-md-none mobile shadow-none p-0 m-0">
        <div class="menu d-block mobile py-3 w-100">
            <div class="d-flex align-items-center">
                <a class="navbar-brand mr-auto flex-grow-1 h-100 p-0" href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}"
                         class="logo img-fluid"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu-mobile"
                        aria-controls="menu-mobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fas fa-bars"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="menu-mobile">
                <ul class="navbar-nav mt-3">
                    <li class="nav-item {{ Request::is('/*') ? 'active' : '' }}">
                        <a href="/" class="nav-link">Início</a>
                    </li>

                    <li class="nav-item {{ Request::is('cursos*') ? 'active' : '' }}">
                        <a href="/cursos" class="nav-link">Cursos</a>
                    </li>

                    <li class="nav-item">
                        <a href="/#contato__wrapper" class="nav-link">Contato</a>
                    </li>

                    <li class="nav-item">
                        @if (Auth::user())
                            <a href="{{ route('user.logout') }}" class="nav-link"
                               onclick="event.preventDefault(); document.getElementById('logout-aluno').submit();">
                                Sair
                            </a>
                            <form id="logout-aluno" action="{{ route('user.logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('user.home') }}" class="nav-link">Entrar</a>
                        @endif
                    </li>

                    <li class="nav-item cart-button {{ count($cart['items']) > 0 ? 'has-items' : '' }}">
                        <a href="{{ route('checkout.index') }}" class="nav-link cart">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-items">{{ count($cart['items']) }}</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="https://www.sie.com.br/institutoacesso" class="nav-link sie-button">Área do aluno</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-10 offset-sm-1 ml-md-auto mt-3 mb-0 search-wrapper">
                <form action="{{ route('search') }}" method="GET" role="search">
                    <input autocomplete="off" type="text" class="form-control search-input" name="q"/>
                    <div class="placeholder">
                        <div>
                            <span>O que você quer apreender?</span>
                        </div>
                    </div>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                @if (Route::current()->getName() === 'home')
                    <p class="text-center black-white mt-1 mb-0">
                @else
                    <p class="text-center black-text text-medium mt-1 mb-0">
                        @endif
                        Mais de 1000 cursos online com certificado
                    </p>
            </div>
        </div>
    </nav>
</div>
