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
