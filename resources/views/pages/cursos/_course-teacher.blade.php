<div class="course-teacher__wrapper pt-5">
    <div class="container">
        <div class="course-teacher__wrapper--content">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card card-cascade narrower course-teacher-description__wrapper">
                        <div class="view view-cascade overlay img-circle">
                            <img src="{{ $curso->teacher_image }}" alt="{{ $curso->teacher_name }}"
                                title="{{ $curso->teacher_name }}" />
                        </div>
                        <div class="card-body card-body-cascade">
                            <h5 class="font-weight-bold card-title text-center">
                                TUTOR(A) {{ \Str::upper($curso->teacher_name) }}
                            </h5>
                            <p class="card-text text-justify">
                                {!! $curso->teacher_description !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-none d-md-block"></div>
            </div>
        </div>
    </div>
</div>
