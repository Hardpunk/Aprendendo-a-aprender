<header class="header-class mobile">
    @include('includes._header-menu')
</header>

@if(Route::current()->getName() === 'home')
    @include('includes._header-carousel')
@endif
