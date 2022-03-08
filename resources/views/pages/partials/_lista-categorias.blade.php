<section class="categories-list pt-3 container-lg">
    <div class="row">
        <div class="col-12 col-sm-8 col-md-6">
            <div class="form-group">
                <label for="categories">Selecione uma categoria:</label>
                <select id="categories" class="form-control select2">
                    @if(count($categorias) > 0)
                        <option value="">-- CATEGORIAS --</option>
                        @foreach($categorias as $_categoria)
                            <option
                                value="{{ $_categoria->slug }}" {{ isset($categoria) ? ($categoria->slug == $_categoria->slug ? 'selected' : '' ) : '' }}>{{ $_categoria->title }}</option>
                        @endforeach
                    @else
                        <option value="" disabled>NENHUMA CATEGORIA ENCONTRADA</option>
                    @endif
                </select>
            </div>
        </div>
    </div>
</section>
