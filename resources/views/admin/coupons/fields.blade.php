<div class="row">
    <!-- Code Field -->
    <div class="form-group col-sm-4 col-md-4 col-lg-3">
        {!! Form::label('code', 'Código Cupom') !!}
        {!! Form::text('code', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Title Field -->
    <div class="form-group col-sm-8 col-md-8 col-lg-5">
        {!! Form::label('title', 'Título') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>

    <div class="clearfix hidden-md hidden-lg"></div>

    <!-- Discount Field -->
    <div class="form-group col-xs-6 col-sm-3 col-md-3 col-lg-2">
        {!! Form::label('discount', 'Desconto') !!}
        <div class="input-group">
            {!! Form::text('discount', null, ['class' => 'form-control number-percent']) !!}
            <div class="input-group-append">
                <span class="input-group-text"><strong>%</strong></span>
            </div>
        </div>
    </div>

    <!-- Limit Field -->
    <div class="form-group col-xs-6 col-sm-3 col-md-3 col-lg-2">
        {!! Form::label('limit', 'Limite de uso') !!}
        {!! Form::text('limit', null, ['class' => 'form-control number-infinite']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Salvar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('admin.coupons.index') !!}" class="btn btn-default">Cancelar</a>
    </div>
</div>
