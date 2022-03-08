<div class="header__wrapper">
    <div class="header__wrapper-nav-bar">
        @include('includes._header-menu')
    </div>
    @if(Request::is('cursos*') || Request::is('search*'))
    <div id="breadcrumb" class="breadcrumb mb-0 text-black py-4">
        @yield('breadcrumb')
    </div>
    @endif
</div>
