@php
$colors = ['yellow darken-3', 'green darken-2', 'light-blue lighten-1', 'red darken-1'];
@endphp
<div class="trail-courses__wrapper pt-2 pb-4">
    <div class="container">
        <div class="trail-courses__wrapper--content">
            <div class="row">
                <div class="col-12 col-md-8">
                @if(count($trilha->courses) > 0)
                    @foreach($trilha->courses as $course)
                    <div class="row trail-courses__box mb-4">
                        <div class="col-12 col-sm-5 col-md-12 col-lg-4">
                            <div class="card text-white">
                                <div class="card-body d-flex align-items-center {{ $colors[$loop->index] }}">
                                    <p class="m-0 font-weight-bold text-center">{{ mb_strtoupper($course->title) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-7 col-md-12 col-lg-8">
                            <div class="card shadow-none">
                                <div class="card-body d-flex align-items-center h-100 shadow left-border border-{{ explode(' ', $colors[$loop->index])[0] }}">
                                    <p class="m-0 black-text text-justify">
                                        {{ truncate_text_at_word($course->description, 170, '.', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
                </div>
                <div class="col-md-4 d-none d-md-block"></div>
            </div>
        </div>
    </div>
</div>
