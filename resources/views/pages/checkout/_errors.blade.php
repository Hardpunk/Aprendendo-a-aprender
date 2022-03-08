@if (Session::has('flash_message'))
<div class="col-md-12">
    <div class="alert alert-{{ Session::get('flash_type') }} alert-dismissible fade show" role="alert">
        <p class="mb-0"><strong>{{ Session::get('flash_type') == 'danger' ? "ERRO!" : "SUCESSO!" }}</strong> {!! Session::get('flash_message') !!}</p>
        @if (Session::has('flash_message_detail'))
        <p class="mb-0">{{ Session::get('flash_message_detail') }}</p>
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

@if ($errors->any())
<div class="col-md-12">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p class="mb-0"><strong>ERRO!</strong></p>
        <ul class="mt-3 mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif
