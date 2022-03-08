@if(!empty($errors))
    @if($errors->any())
        <ul class="alert alert-danger alert-dismissible" style="list-style-type: none">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @foreach($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    @endif
@endif
