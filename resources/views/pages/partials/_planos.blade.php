<section class="mt-0 choose-category text-center py-5 mb-5 d-flex justify-content-center" id="planos">
    <div class="container">
        <h2 class="title d-block text-center text-cinza">PLANOS DE APRENDIZAGEM</h2>
        <h5 class="text-cinza py-4 mb-5">Além de adquirir os cursos avulsos, você também pode ter <b>acesso
                ilimitado</b> a mais de 1000 cursos online em 41 áreas diferentes! Faça sua matrícula agora mesmo em um
            dos nossos planos de <b>aprendizagem contínua</b></h5>
        <div class="grid">
            @forelse($planos as $plano)
            <div class="mycard basic {{ $loop->iteration == 2 ? 'mid' : '' }}">
                <div class="title">
                    <h1>{{ $plano->title }}</h1>
                    <h5><span class="badge badge-theme-color">{{ plan_time_name($plano->months) }}</span></h5>
                </div>
                <div class="title preco">
                    <p>{{ $plano->months }}x de <b> R${{ number_format($plano->installment_amount, 2, ',', '.') }}</b></p>
                    <p>à vista <b class="preco-plano">R${{ number_format($plano->amount, 2, ',', '.') }}</b></p>
                </div>
                <div class="option">
                    <ul style="text-align: left;">
                        <li>
                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                            Acesso ilimitado durante <b>{{ $plano->months }} meses</b> a mais de 1000 cursos
                        </li>
                        <li>
                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                            Certificado de Participação
                        </li>
                        <li>
                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                            Plataforma gamificada
                        </li>
                        <li>
                            <i class="fa fa-check text-success" aria-hidden="true"></i>
                            Relatório de desenvolvimento
                        </li>
                    </ul>
                </div>
                <a class="btn btn-matri font-weight-bold waves-effect waves-light m-0 text-white"
                    href="{{ route('checkout.plan', $plano->slug) }}">Matricule-se</a>
            </div>
            @empty
            @endforelse
        </div>
    </div>
</section>
