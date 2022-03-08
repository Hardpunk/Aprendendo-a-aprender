@extends('layouts.master')

@section('js_tags')
    {!! htmlScriptTagJsApi() !!}
@endsection

@section('content')
    <section class="header-padrao">
        <div class="container">
            <div class="row">
                <div class="col-md-12 pt-10 h-mobile">
                    <div class="header-content light-color">
                        <div class="texto-header">
                            <header>
                                <h1 class="">Como podemos te ajudar?</h1>
                                <p class="subtitle">
                                    Preencha os campos abaixo para entrar em contato com a nossa equipe </p>
                            </header>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-4 ordem-mobile-2 form-wrapper">
                    <form id="formContact" class="form-contact" method="post">
                        @csrf
                        <input type="text" class="form-contact-input" name="name" placeholder="Nome" required />
                        <input type="text" class="form-contact-input phone-mask" name="phone" placeholder="Telefone" />
                        <input type="email" class="form-contact-input" name="email" placeholder="E-mail" required />
                        <textarea class="form-contact-textarea" name="message" placeholder="Mensagem" required></textarea>
                        <div class="mb-4">
                            {!! htmlFormSnippet() !!}
                        </div>
                        <button id="contactButton" type="button"  data-loading-text="<i class='fas fa-spinner fa-spin mr-2'></i>Enviando..."
                            class="form-contact-button">Enviar</button>
                    </form>
                    <div id="contactMessage"></div>
                </div>
                <div class="col-md-4 contato ordem-mobile-1">
                    <h3>Entre em contato!</h3>
                    <div class="d-flex my-3 py-3">
                        <div class="icon-box-icon">
                            <i aria-hidden="true" class="far fa-envelope-open"></i>
                        </div>
                        <div>
                            <a class="text-cinza"
                                href="mailto:escoladenegocios@aciccaruaru.com">escoladenegocios@aciccaruaru.com</a>
                        </div>
                    </div>
                    <div class="d-flex my-3 py-3">
                        <div class="icon-box-icon">
                            <i aria-hidden="true" class="fas fa-phone-volume"></i>
                        </div>
                        <div>
                            <p>Caruaru (PE): (81) 3721 2725</p>
                        </div>
                    </div>
                    <div class="d-flex my-3 py-3">
                        <div class="icon-box-icon">
                            <i aria-hidden="true" class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <p>Impact Hub Brasília | Sgan 601 Conjunto H <br> Sala 54 Ss1 Edifício Íon - Asa
                                Norte,<br>Brasília/DF <br>CEP: 70830-018</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-100 py-3"></div>
    </section>
@endsection
