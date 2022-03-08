{!! Form::open(['route' => ['admin.newsletters.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    {!! Form::button('<i class="fas fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-sm',
        'title' => 'Excluir',
        'onclick' => "return confirm('Deseja mesmo excluir?')"
    ]) !!}
</div>
{!! Form::close() !!}
