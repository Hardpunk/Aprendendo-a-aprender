<div class="row">
    <div class="form-group col-12 col-sm-12">
        {!! Form::label('created_at', 'Mensagem enviada em:') !!}
        <span>{{ ucfirst($contact->created_at->formatLocalized('%A, %d de %B de %Y às %Hh%M')) }}</span>

    </div>

    <div class="form-group col-12 col-sm-4">
        {!! Form::label('name', 'Nome:') !!}
        <p>{{ $contact->name }}</p>
    </div>

    <div class="form-group col-12 col-sm-4">
        {!! Form::label('email', 'E-mail:') !!}
        <p>{{ $contact->email }}</p>
    </div>

    <div class="form-group col-12 col-sm-4">
        {!! Form::label('phone', 'Telefone:') !!}
        <p>{{ $contact->phone }}</p>
    </div>

    <div class="form-group col-12 col-sm-12">
        {!! Form::label('message', 'Mensagem:') !!}
        <p class="text-justify">{{ $contact->message }}</p>
    </div>
</div>
