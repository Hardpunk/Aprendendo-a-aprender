<div class="row">
    <!-- Name Field -->
    <div class="form-group col-12">
        {!! Form::label('name', 'Name:') !!}
        <p>{{ $affiliate->name }}</p>
    </div>

    <!-- Slug Field -->
    <div class="form-group col-12">
        {!! Form::label('slug', 'Slug:') !!}
        <p>{{ $affiliate->slug }}</p>
    </div>

    <!-- Times Used Field -->
    <div class="form-group col-12">
        {!! Form::label('times_used', 'Times Used:') !!}
        <p>{{ $affiliate->times_used }}</p>
    </div>
</div>
