{!! Form::open(['route' => ['admin.affiliates.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
     <a href="{{ route('admin.affiliates.show', $id) }}" class='btn btn-default btn-sm' title="Visualizar">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{ route('admin.affiliates.edit', $id) }}" class='btn btn-default btn-sm' title="Editar">
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-sm',
        'title' => 'Excluir',
        'onclick' => "return confirm('Deseja mesmo excluir?')"
    ]) !!}
</div>
{!! Form::close() !!}
