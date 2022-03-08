<section id="contato__wrapper" class="py-5 paroller"
         data-paroller-factor="0.4"
         data-paroller-factor-xs="0.2"
         data-paroller-factor-sm="0.3">
    <div class="container">
        <h3 class="title d-block text-uppercase text-white text-center mb-4">CONTATO</h3>
        <div class="row">
            <div class="col-sm-12 col-md-8 offset-md-2">
                <form id="form-contato">
                    @csrf
                    <div class="form-group">
                        <input type="text" id="name" name="name" placeholder="NOME" class="form-control" required/>
                    </div>

                    <div class="form-group">
                        <input type="text" id="phone" name="phone" placeholder="TELEFONE"
                               class="form-control phone-mask" required/>
                    </div>

                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="E-MAIL" class="form-control" required/>
                    </div>

                    <div class="form-group">
                        <textarea id="message" name="message" placeholder="MENSAGEM"
                                  class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        {!! htmlFormSnippet() !!}
                    </div>

                    <div class="form-group">
                        <button id="btn-contact-send" type="button" class="btn bg-white ml-0"
                                data-loading-text="<i class='fas fa-spinner fa-spin mr-2'></i>Aguarde...">
                            <i class="fas fa-paper-plane"></i>
                            <span class="font-weight-bold">ENVIAR</span>
                        </button>
                    </div>
                </form>
                <div class="formResponse"></div>
            </div>
        </div>
    </div>
</section>
