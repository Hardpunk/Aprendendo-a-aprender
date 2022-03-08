<div class="row">
    <!-- Title Field -->
    <div class="form-group col-12 col-sm-9 col-md-10">
        {!! Form::label('title', 'Título') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Order Field -->
    <div class="form-group col-12 col-sm-3 col-md-2">
        {!! Form::label('order', 'Ordem') !!}
        {!! Form::text('order', $latestOrder ?? ($banner->order ?? 1) , ['class' => 'form-control number-infinite']) !!}
    </div>

    <!-- Description Field -->
    <div class="form-group col-12">
        {!! Form::label('description', 'Descrição') !!}
        {!! Form::text('description', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Image Field -->
    <div class="form-group col-sm-12 col-md-6">
        {!! Form::label('image', 'Banner') !!}
        {!! Form::file('image', ['class' => 'form-control', 'accept' => 'image/*']) !!}
    </div>

    <div class="form-group col-12">
        <div class="img-preview jumbotron p-sm-3 {{ !isset($banner) ? 'd-none' : '' }} m-0">
            <img class="img-fluid shadow d-block mx-auto" src="{{ $bannerImage ?? '#' }}" alt="{{ $banner->title ?? '' }}"/>
        </div>
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('admin.banners.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
