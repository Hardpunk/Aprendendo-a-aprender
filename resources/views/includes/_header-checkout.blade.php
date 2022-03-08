<header class="d-md-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3">
                <a class="brand-logo text-center" href="/">
                    <img class="img-fluid" src="{{ asset('/images/logo.png') }}"
                        alt="logo" />
                </a>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-9">
            @isset($steps)
                @if(count($steps) > 0)
                <div class="multisteps-form__container">
                    <div class="multisteps-form">
                        <div class="multisteps-form__progress">
                            <button type="button" title="Identificação"
                                class="multisteps-form__progress-btn {{ $steps[0] ? 'js-active' : '' }}">
                                IDENTIFICAÇÃO
                            </button>
                            <button type="button" title="Pagamento"
                                class="multisteps-form__progress-btn {{ $steps[1] ? 'js-active' : '' }}">
                                PAGAMENTO
                            </button>
                            <button type="button" title="Confirmação"
                                class="multisteps-form__progress-btn {{ $steps[2] ? 'js-active' : '' }}">
                                CONFIRMAÇÃO
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            @endisset
            </div>
        </div>
    </div>
</header>
