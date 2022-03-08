<div class="row">
    <!-- Title Field -->
    <div class="form-group col-12 col-sm-9 col-md-10">
        {!! Form::label('title', 'Título') !!}
        <p>{{ $banner->title }}</p>
    </div>

    <!-- Order Field -->
    <div class="form-group col-12 col-sm-3 col-md-2">
        {!! Form::label('order', 'Ordem') !!}
        <p>{{ $banner->order }}</p>
    </div>

    <!-- Description Field -->
    <div class="form-group col-12">
        {!! Form::label('description', 'Descrição') !!}
        <p>{{ $banner->description }}</p>
    </div>

    <!-- Image Field -->
    <div class="form-group col-12">
        {!! Form::label('image', 'Banner') !!}
        <div class="img-preview jumbotron p-sm-3 m-0">
            <img class="img-fluid shadow d-block mx-auto" src="{{ $banner->image }}" alt="{{ $banner->title }}"/>
        </div>
    </div>
</div>
