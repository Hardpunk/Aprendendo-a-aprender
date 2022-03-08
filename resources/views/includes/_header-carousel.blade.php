@if(isset($banners) && count($banners) > 0)
    <section id="carouselSite" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($banners as $banner)
                <div class="carousel-item{{ $loop->iteration === 1 ? ' active' : '' }}">
                    <img src="{{ asset("images/banners/{$banner->image}") }}" class="img-fluid d-block w-100"
                         alt="{{ $banner->title }}"/>
                </div>
            @endforeach
        </div>
        <ol class="carousel-indicators">
            @for($i = 0; $i < count($banners); $i++)
                <li data-target="#carouselSite" data-slide-to="{{ $i }}"
                    class="{{ $i === 0 ? ' active' : '' }}"></li>
            @endfor
        </ol>

        <a class="carousel-control-prev" href="#carouselSite" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="sr-only"></span>
        </a>

        <a class="carousel-control-next" href="#carouselSite" role="button" data-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="sr-only"></span>
        </a>
    </section>
@endif

