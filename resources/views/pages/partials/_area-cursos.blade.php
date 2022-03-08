<section class="mt-0 choose-category text-center py-5 mb-6 bg-area-curso">
    <div class="container-lg align-items-center">
        <h3 class="title d-block">Mais de <b>1000 cursos</b> online em diversas áreas com <b>certificado</b>.
            <br/>
            O que você quer <b>aprender</b> hoje?
        </h3>
        @if(count($destaques) > 0)
            <div class="row">
                @foreach($destaques as $categoria)
                    <div class="col-md-6 col-lg-4 p-md-4 col-sm-12 my-3 my-md-0">
                        <div class="card category-item item">
                            <a class="url-curso" href="{{ route('courses.category', $categoria->slug) }}"
                               title="{{ $categoria->title }}">
                                <div class="card-img-top" style="background-image: url('{{ $categoria->image }}');">
                                    <div class="categories__course-count py-1 px-3">
                                        <span class="icon-agenda">{{ $categoria->courses_total }} CURSOS</span>
                                    </div>
                                </div>
                                <div class="card-body pt-2 pb-0 px-0 d-flex justify-content-center flex-column">
                                    <div>
                                        <h5 class="card-title my-2 text-semi-bold">{{ $categoria->title }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 d-flex justify-content-center">
                    <a href="{{ route('courses.index') }}"
                       class="btn btn-lg btn-read-more font-weight-bold waves-effect waves-light m-0 bg-theme-color">
                        Ver todos cursos!
                    </a>
                </div>
            </div>
        @else
            <div class="no-results">
                <h4 class="text-center">NENHUMA CATEGORIA ENCONTRADA</h4>
            </div>
        @endif
    </div>
</section>
