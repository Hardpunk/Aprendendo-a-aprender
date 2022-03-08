@if (count($trilhas) > 0)
    <section id="treinamentos__wrapper" class="container-lg pb-5 pt-5">
        <h3 class="title d-block text-uppercase text-center mb-5 mb-md-4">TRILHAS DO CONHECIMENTO</h3>
        @foreach ($trilhas as $trilha)
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="trail trail-details">
                        <div class="card">
                            <div class="row flex-align align-items-center h-100">
                                <div class="col-12 col-md-4 trail--cover__wrapper">
                                    <div class="trail--cover__wrapper--image">
                                        <div style="background-image: url({{ asset("{$trilha->cover}") }})"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 trail--description__wrapper">
                                    <div class="row flex-align align-items-center h-100">
                                        <div class="col-12">
                                            <div class="trail--description__wrapper--content">
                                                <div class="trail--description__wrapper--title mb-3">
                                                    <div class="trail-title">
                                                        <h5 class="font-weight-bold m-0">{{ mb_strtoupper($trilha->title) }}</h5>
                                                    </div>
                                                </div>
                                                <div class="trail--description__wrapper--list mb-3">
                                                    <ul class="trail-list mb-0">
                                                        @foreach ($trilha->courses as $curso)
                                                            <li>{{ $curso->title }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <div class="trail--description__wrapper--button">
                                                    <a href="{{ route('trails.show', $trilha->slug) }}"
                                                       class="btn btn-sm btn-read-more font-weight-bold waves-effect waves-light m-0">
                                                        Saiba mais
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endif
