<section id="empresas__wrapper">
    <div class="bg-overlay"></div>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-lg-2">
            <div class="col bg-image__wrapper text-white p-5">
                <div class="card h-100 flex-align flex-row align-items-center justify-content-center">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h2 class="font-weight-bold mb-5">TREINE A SUA EQUIPE<br/> COM A ESCOLA DE NEGÓCIOS</h2>

                            <div class="features__wrapper">
                                <h3 class="m-0">PARA SUA EMPRESA SAIR NA FRENTE</h3>
                                <div class="feature--item text-white text-left">
                                    <h4 class="m-0">COM PROFISSIONAIS <strong>QUALIFICADOS</strong></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col form__content text-white p-5">
                <div class="card h-100">
                    <h4 class="font-weight-bold">
                        FAZER A ESCOLHA CERTA NEM SEMPRE É DIFÍCIL.
                    </h4>
                    <h5 class="mb-4">
                        Comece hoje a experimentar as vantagens que somente a ACIM traz para você!
                    </h5>
                    <form id="form-empresas">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="company-username">Nome</label>
                                    <input type="text" id="company-username" class="form-control" name="company[username]"
                                        placeholder="Nome" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="company-user-email">E-mail</label>
                                    <input type="text" id="company-user-email" class="form-control" name="company[user_email]"
                                        placeholder="E-mail" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="company-user-phone">Telefone</label>
                                    <input type="text" id="company-user-phone" class="form-control phone-mask"
                                        name="company[user_phone]" placeholder="Telefone" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="company-user-post">Cargo</label>
                                    <input type="text" id="company-user-post" class="form-control" name="company[user_post]"
                                        placeholder="Cargo" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="company-name">Empresa</label>
                                    <input type="text" id="company-name" class="form-control" name="company[name]"
                                        placeholder="Empresa" />
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="company-employees">Quantidade colaboradores</label>
                                    <select id="company-employees" class="form-control browser-default" name="company[employees]">
                                        <option value="">Selecione</option>
                                        <option value="1-20">1-20</option>
                                        <option value="21-50">21-50</option>
                                        <option value="51-100">51-100</option>
                                        <option value="101-500">101-500</option>
                                        <option value="500 ou mais">500 ou mais</option>
                                        <option value="Não sei responder">Não sei responder</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="form-group">
                                <button type="submit" class="btn bg-white acim-text-color">
                                    <i class="fas fa-paper-plane"></i>
                                    <span class="font-weight-bold">ENVIAR</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
