<div class="course-faq__wrapper py-5 text-white">
    <div class="container">
        <div class="course-faq__wrapper--content">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="faq-title mb-4">
                        <h4 class="font-weight-bold m-0">Dúvidas Frequentes</h4>
                    </div>
                    <div class="faq-description__wrapper">
                        <h4>Como funciona o curso? Ele é autorizado pelo MEC?</h4>
                        <p>Os cursos do Instituto Acesso - Desenvolvimento de Carreiras te ensinam por intermédio da EaD (Educação a Distância), com animações e games (do tipo quiz) que estimulam a interatividade e a interação. <br>O Instituto Acesso - Desenvolvimento de Carreiras oferece cursos livres, de atualização e qualificação profissional. São destinados a proporcionar ao profissional conhecimentos que permitam o desenvolvimento de novas competências e não exigem escolaridade anterior. <br>O MEC (Ministério da Educação) regulamenta na Lei nº. 9394/96, o Decreto nº. 5.154/04 e a Deliberação CEE 14/97 e seguimos todos os critérios.</p>
                        <h4><br>Vou aprender mesmo?</h4>
                        <p>Os cursos do Instituto Acesso - Desenvolvimento de Carreiras são dinâmicos e com várias vantagens comparadas a um curso presencial. Você terá recursos como: <br>Flexibilidade TOTAL de estudo, 24h por dia, sem limite de acesso!</p>
                        <br>
                        <h4>Tem certificado?</h4>
                        <p>Os alunos aprovados receberão o Certificado Digital em seu espaço virtual, após a nota média e prazo mínimo de estudo exigido.<br>Os cursos do Instituto Acesso - Desenvolvimento de Carreiras lhe dão a certificação de capacitação profissional, aperfeiçoamento, extensão e concursos públicos.</p>
                    </div>
                </div>
                <div class="col-md-4 d-none d-md-block">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="course-topics__wrapper py-5 text-white" >
    <div class="container">
        <div class="course-topics__wrapper--content">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="topics-title mb-4">
                        <h5 class="font-weight-bold m-0">O QUE VOU APRENDER?</h5>
                    </div>
                    <div class="topics-description__wrapper">
                        @if (count($topics = json_decode($curso->topics)) > 0)
                            <div class="topics-description {{ count($topics) > 4 ? 'topics-truncate' : 'd-none' }}">
                                @foreach ($topics as $topic)
                                    <h6>
                                        <span class="font-weight-bold">{{ $loop->iteration }} - </span>{{ $topic }}
                                    </h6>
                                @endforeach
                            </div>
                            <p class="btn-show-more text-center mt-2 closed">
                                <small class="font-weight-bold">VISUALIZAR MAIS <i class="fas fa-angle-down"></i><i
                                        class="fas fa-angle-up"></i></small>
                            </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 d-none d-md-block">

                </div>
            </div>
        </div>
    </div>
</div>
