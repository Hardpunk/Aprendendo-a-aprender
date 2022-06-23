<div class="row">
    <!-- Name Field -->
    <div class="form-group col-sm-8 col-lg-7">
        {!! Form::label('name', 'Nome') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Slug Field -->
    <div class="form-group col-sm-4 col-lg-3">
        {!! Form::label('slug', 'Código') !!}
        {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Commission Field -->
    <div class="form-group col-sm-4 col-lg-2">
        {!! Form::label('commission', 'Comissão') !!}
        <div class="input-group">
            {!! Form::text('commission', null, ['class' => 'form-control number-percent']) !!}
            <div class="input-group-append">
                <span class="input-group-text"><strong>%</strong></span>
            </div>
        </div>
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12 ">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('admin.affiliates.index') }}" class="btn btn-default">Cancelar</a>
    </div>
</div>
