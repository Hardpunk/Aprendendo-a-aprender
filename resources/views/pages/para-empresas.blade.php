@extends('layouts.master')

@section('js_tags')
    {!! htmlScriptTagJsApi() !!}
@endsection

@section('content')
<style>
#paraempresas p {
    font-size: 1.3em;
}
</style>
<section id="paraempresas" class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-center py-5">
                <h2><strong>Universidade Corporativa</strong></h2>
            </div>
            <div class="col-md-6 text-right py-5">
                <img class="svg-img" src="/images/sua-empresa/sua-empresa-1.png">
            </div>
            <div class="col-md-6 py-5">
                <h2>Para a sua empresa</h2>
                <p>Gostaria que sua equipe tivesse melhores resultados? Você tem dificuldade em capacitar seus colaboradores, por falta de tempo,  recursos e de não saber ao certo o retorno da capacitação e os indicadores de engajamento dos profissionais nos treinamentos?</p>
            </div>
            <div class="col-md-12 py-5">
                <div class="feature__wrapper">
                    <div class="feature__image img-02"></div>
                    <p class="feature__text">Capacite sua equipe com </span><strong>cursos rápidos, em português e 100% online.</strong><span style="font-weight: 400;"> O seu colaborador pode acessar pelo computador ou pelo celular.</p>
                </div>
                <div class="feature__wrapper">
                    <div class="feature__image img-03"></div>
                    <p class="feature__text">Monte<strong> trilhas de aprendizagem,</strong> de cursos técnicos ou comportamentais, nas áreas que os seus colaboradores mais precisam se desenvolver.</p>
                </div>
                <div class="feature__wrapper">
                    <div class="feature__image img-04"></div>
                    <p class="feature__text"><span style="font-weight: 400;">Acompanhe o desempenho dos profissionais com </span><strong>relatórios mensais</strong><span style="font-weight: 400;"> de engajamento e identificação de gaps de competências. Todos os cursos possuem testes e recursos para </span><strong>avaliação da aprendizagem.</strong></p>
                </div>
                <div class="feature__wrapper">
                    <div class="feature__image img-05"></div>
                    <p class="feature__text"><span style="font-weight: 400;">Compare o </span><strong>desempenho</strong><span style="font-weight: 400;"> do seu colaborador no trabalho antes e depois de fazer os cursos.</span></p>
                </div>
                <div class="feature__wrapper">
                    <div class="feature__image img-06"></div>
                    <p class="feature__text"><span style="font-weight: 400;">Bonifique pelo </span><strong>mérito</strong><span style="font-weight: 400;"> - aumente a </span><strong>motivação</strong><span style="font-weight: 400;"> dos profissionais que demonstraram engajamento satisfatório e melhoria do desempenho no trabalho após as capacitações.</span></p>
                </div>
            </div>
            <div class="w-100 py-5"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-md-right pt-5">
                        <h2><strong>SESSÃO DE DESTAQUE</strong></h2>
                        <p>Tenha uma equipe pronta para superar os desafios e fazer sua empresa se destacar</p>
                    </div>
                    <div class="col-md-6 order-first order-md-last text-center">
                        <img class="svg-img" src="/images/sua-empresa/sua-empresa-2.svg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="py-5 my-5 icones">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center py-5">
                <h2><strong>VANTAGENS PARA AS EMPRESAS QUE INVESTEM EM TREINAMENTOS</strong></h2>
            </div>
            <div
                <div class="col-md-4 text-center">
                    <div class="icone p-2">
                        <span class="lnr lnr-chart-bars"></span>
                    </div><h5>ECONOMIA</h5>
                    pelo uso racional de materiais e recursos.
                </div>
                <div class="col-md-4 text-center">
                    <div class="icone p-2">
                        <span class="lnr lnr-diamond"></span>
                    </div>
                    <h5>DIMINUIÇÃO DA ROTATIVIDADE</h5>
                    retenção de talentos.
                </div>

                <div class="col-md-4 text-center">
                    <div class="icone p-2">
                        <span class="lnr lnr-users"></span>
                    </div>
                    <h5>EQUIPE MOTIVADA</h5>
                    profissionais sentem-se valorizados.
                </div>
            </div>
            <div class="row py-4">
                <div class="col-md-4 text-center">
                    <div class="icone p-2">
                        <span class="lnr lnr-cog"></span>
                    </div>
                    <h5>AUMENTO DA PRODUTIVIDADE</h5>
                    profissionais trabalhando como nunca.
                </div>
                <div class="col-md-4 text-center">
                    <div class="icone p-2">
                        <span class="lnr lnr-bubble"></span>
                    </div>
                    <h5>INOVAÇÃO DA EMPRESA</h5>
                    equipe com novas ideias, visões e conhecimentos.
                </div>
                <div class="col-md-4 text-center">
                    <div class="icone p-2">
                        <span class="lnr lnr-rocket"></span>
                    </div>
                    <h5>VANTAGEM COMPETITIVA</h5>
                    por uma equipe altamente capacitada.
                </div>
            </div>
        </div>
        <div class="py-4"></div>
    </section>
    <section id="contato-empresas">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <h2>Saiba mais sobre os planos corporativos</h2>
                    <p>Preencha os campos abaixo para nossa equipe entrar em contato com você.</p>
                </div>
                <div class="col-md-8 text-center">
                    <img class="svg-img" src="/images/sua-empresa/sua-empresa-3.png">
                    <div class="w-100 py-3"></div>
                </div>
                <div class="col-md-4 form-wrapper">
                    <form id="contactBusinessForm" class="form-contact" method="post">
                        @csrf
                        <input type="text" class="form-contact-input" name="name" placeholder="Nome" required />
                        <input type="text" class="form-contact-input" name="role" placeholder="Cargo" required />
                        <input type="text" class="form-contact-input phone-mask" name="phone" placeholder="Telefone" required />
                        <input type="email" class="form-contact-input" name="email" placeholder="E-mail" required />
                        <textarea class="form-contact-textarea" name="message" placeholder="Mensagem" required></textarea>
                        <div class="mb-4">
                            {!! htmlFormSnippet() !!}
                        </div>
                        <button id="contactBusinessButton" type="button"
                                data-loading-text="<i class='fas fa-spinner fa-spin mr-2'></i>Enviando..."
                                class="form-contact-button">Enviar</button>
                    </form>
                    <div id="businessContactMessage"></div>
                </div>
            </div>
        </div>
        <div class="w-100 py-3"></div>
    </section>
    @endsection
