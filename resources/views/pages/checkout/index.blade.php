@extends('layouts.checkout', ['steps' => [true, true, false]])

@section('pre_scripts')
<script>
function recaptchaCallback() {
    $('.btn-payment:visible').removeAttr('disabled');
}
</script>
{!! htmlScriptTagJsApi() !!}
@endsection

@section('content')
    <section id="checkout-payment" class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                @include('pages.checkout._errors')

                <div class="col-md-12">
                    <h4 class="pb-2 mb-4 font-weight-bold">CURSOS ESCOLHIDOS</h4>

            @if(count($items) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="tableCartItems">
                            <thead>
                                <tr>
                                    <th colspan="2">CURSO</th>
                                    <th class="text-center">VALOR UNITÁRIO(R$)</th>
                                    <th class="text-right">TOTAL</th>
                                    <th class="text-center">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td class="item-image">
                                        <a class="d-block" href="{{ $item->type === 'trail' ? route('trails.show', [$item->slug]) : route('courses.course_details', [$item->category_slug, $item->slug]) }}">
                                            <img class="img-fluid" src="{{ $item->type === 'trail' ? $item->cover : $item->image }}" />
                                        </a>
                                    </td>
                                    <td>
                                        <a class="d-block" href="{{ $item->type === 'trail' ? route('trails.show', [$item->slug]) : route('courses.course_details', [$item->category_slug, $item->slug]) }}">
                                        {{ $item->type === 'trail' ? 'TRILHA DO CONHECIMENTO - ' : '' }}{{ $item->title }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <p class="mb-1">De <del class="old-price text-muted">R$ {{ number_format($item->old_price, 2, ',', '.') }}</del></p>
                                        <p class="mb-0">Por R$ {{ $item->price }}</p>
                                    </td>
                                    <td class="text-right">R$ {{ $item->price }}</td>
                                    <td class="text-center action">
                                        <form class="form-item-remove" action="/cart/remove/{{ $item->type }}/{{ $item->id }}" method="POST" role="form">
                                            @csrf
                                            <span class="remove-item red">
                                                <i class="fas fa-times"></i>
                                            </span>
                                        </form>
                                        <i class="fas loading fa-spinner fa-spin d-none"></i>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pt-3 mt-1 border-top border-dark">
                        <div class="row mb-4 mb-sm-3">
                            <div class="col-md-12 text-right">
                                @if(!empty($coupon))
                                <div class="justify-content-center justify-content-md-end rounded px-3 py-2 bg-success d-inline-block">
                                    <h5 class="m-0 text-white font-weight-bold">
                                        CUPOM APLICADO: {{ mb_strtoupper($coupon['code']) }}
                                    </h5>
                                </div>
                                @else
                                <form id="add-coupon" action="{{ route('checkout.addCoupon') }}"
                                    class="form-inline justify-content-center justify-content-md-end"
                                    method="POST" role="form">
                                    @csrf
                                    <div class="form-group mb-0">
                                        <label for="coupon" class="font-weight-bold mb-0">CÓDIGO CUPOM</label>
                                    </div>
                                    <div class="form-group mx-2 mb-0">
                                        <input id="coupon" type="text" name="code" class="form-control" />
                                    </div>
                                    <button type="button" class="btn btn-success rounded add-coupon-button"
                                        data-loading-text="<i class='fas fa-spinner fa-spin mr-2'></i>Aguarde...">OK</button>
                                </form>
                                @endif
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm-6 text-center text-sm-left">
                                <div class="select-courses-link">
                                    <a href="/" class="btn-link btn-theme select-courses-button font-weight-bold">Escolher mais cursos</a>
                                </div>
                            </div>
                            <div class="col-sm-6 text-center text-sm-right mt-3 mt-sm-0">
                                @if(!empty($coupon))
                                <h5 class="font-weight-bold mb-1 text-right text-success">Cupom ({{ number_format($coupon['discount'], 2, ',', '.')."%" }}): -R$ {{ number_format(($valor_total * ($coupon['discount']/100)), 2, ',', '.') }}</h5>
                                @endif
                                <h4 class="font-weight-bold mb-2">Total: R$ <label class="m-0" id="totalCost">{{ number_format(($valor_total * $coupon_discount), 2, ',', '.') }}</label></h4>
                                <h6 class="font-weight-bold theme-text-color mb-0">OU EM 10x DE R$ {{ number_format((($valor_total * $coupon_discount)/10), 2, ',', '.') }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <h4 class="pb-2 mb-4 font-weight-bold border-bottom">INFORMAÇÕES</h4>
                </div>
                <div class="col-lg-5">
                    <div class="user-informations card">
                        <div class="card-header font-weight-bold">
                            DADOS PESSOAIS
                        </div>
                        <div class="card-body">
                            <p><strong>NOME:</strong> {{ $user->name }}</p>
                            <p><strong>E-MAIL:</strong> {{ $user->email }}</p>
                            {{-- <p><strong>TELEFONE:</strong> <span class="phone-mask">{{ $user->profile->phone }}</span></p>
                            <p><strong>CPF/CNPJ:</strong> <span class="cpf_cnpj">{{ $user->profile->document_number }}</span></p>
                            <p><strong>DATA DE NASCIMENTO:</strong> <span class="date">{{ $user->profile->birthday->format('d/m/Y') }}</span></p> --}}
                        </div>
                    </div>
                </div>
            {{-- </div>
            <div class="row mt-4"> --}}
                <div class="col-lg-7 mt-4 mt-lg-0">
                    <div class="user-informations-billing card">
                        <div class="card-header font-weight-bold">ENDEREÇO DE COBRANÇA</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-lg-3">
                                    <label for="cepform">CEP <small class="isMandatory"><span class="text-danger">*</span></small></label>
                                    <input type="text" id="cepform" class="form-control" name="cep" maxlength="9">
                                </div>
                                <div class="form-group col-md-6 col-lg-3">
                                    <label for="estadoform">Estado <small class="isMandatory"><span class="text-danger">*</span></small></label>
                                    <select id="estadoform" class="form-control select2" name="state">
                                        <option value=""></option>
                                        <option value="AC">AC</option>
                                        <option value="AL">AL</option>
                                        <option value="AP">AP</option>
                                        <option value="AM">AM</option>
                                        <option value="BA">BA</option>
                                        <option value="CE">CE</option>
                                        <option value="DF">DF</option>
                                        <option value="ES">ES</option>
                                        <option value="GO">GO</option>
                                        <option value="MA">MA</option>
                                        <option value="MT">MT</option>
                                        <option value="MS">MS</option>
                                        <option value="MG">MG</option>
                                        <option value="PA">PA</option>
                                        <option value="PB">PB</option>
                                        <option value="PR">PR</option>
                                        <option value="PE">PE</option>
                                        <option value="PI">PI</option>
                                        <option value="RJ">RJ</option>
                                        <option value="RN">RN</option>
                                        <option value="RS">RS</option>
                                        <option value="RO">RO</option>
                                        <option value="RR">RR</option>
                                        <option value="SC">SC</option>
                                        <option value="SP">SP</option>
                                        <option value="SE">SE</option>
                                        <option value="TO">TO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12 col-lg-6">
                                    <label for="cidadeform">Cidade <small class="isMandatory"><span class="text-danger">*</span></small></label>
                                    <input type="text" id="cidadeform" class="form-control" name="city">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-9">
                                    <label for="enderecoform">Endereço <small class="isMandatory"><span class="text-danger">*</span></small></label>
                                    <input type="text" id="enderecoform" class="form-control" name="address">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="numform">Número <small class="isMandatory"><span class="text-danger">*</span></small></label>
                                    <input type="text" id="numform" class="form-control number" name="number" maxlength="5">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="bairroform">Bairro <small class="isMandatory"><span class="text-danger">*</span></small></label>
                                    <input type="text" id="bairroform" class="form-control" name="neighborhood">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="complform">Complemento</label>
                                    <input type="text" id="complform" class="form-control" name="complement">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12">
                    <h4 class="pb-2 mb-4 font-weight-bold border-bottom">PAGAR COM</h4>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a id="credit-card-tab" class="nav-link active"
                                data-toggle="tab" role="tab"
                                aria-controls="credit-card" aria-selected="true"
                                href="#credit-card">
                                <h5 class="m-0 p-2 font-weight-bold">CARTÃO DE CRÉDITO</h5>
                            </a>
                        </li>
                         <li class="nav-item" role="presentation">
                            <a id="bank-slip-tab" class="nav-link"
                                data-toggle="tab" role="tab"
                                aria-controls="bank-slip" aria-selected="true"
                                href="#bank-slip">
                                <h5 class="m-0 p-2 font-weight-bold">BOLETO</h5>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="credit-card" class="tab-pane fade show active"
                            role="tabpanel" aria-labelledby="credit-card-tab">
                            <div class="card border-top-0">
                                <div class="card-body boxPay">
                                    <form id="card_form" method="POST" action="{{ route('checkout.payment') }}" accept-charset="UTF-8">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="credit_card">
                                        <input type="hidden" name="street">
                                        <input type="hidden" name="street_number">
                                        <input type="hidden" name="neighborhood">
                                        <input type="hidden" name="complement">
                                        <input type="hidden" name="city">
                                        <input type="hidden" name="state">
                                        <input type="hidden" name="country" value="br">
                                        <input type="hidden" name="zipcode">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card mb-2 shadow-sm h-100">
                                                    <div class="card-header font-weight-bold">DADOS DO CARTÃO</div>
                                                    <div class="card-body" id="dlcard">
                                                        <div class="form-group">
                                                            <label for="cardNumber">Número do cartão</label>
                                                            <div class="input-group input-group-lg">
                                                                <div class="input-group-prepend">
                                                                    <div class="cc-number__wrapper input-group-text">
                                                                        <div id="cc-logo" class="cc-number"></div>
                                                                    </div>
                                                                </div>
                                                                <input type="text" id="cardNumber" name="cc_number" class="form-control" autocomplete="off">
                                                            </div>
                                                            <p id="cardNumberEr" style="display:none;" class="erroForm">Número de cartão inválido.</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name">Titular do cartão</label>
                                                            <input class="form-control" autocomplete="off" id="name" name="cc_holder" type="text" maxlength="40">
                                                            <p id="nomeEr" style="display:none;" class="erroForm">Titular do cartão inválido.</p>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dtValidMonth">Validade</label>
                                                            <div class="form-row">
                                                                <div class="col">
                                                                    <select id="dtValidMonth" name="cc_expiry_month" class="form-control">
                                                                        <option value="">Mês</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="11">11</option>
                                                                        <option value="12">12</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col">
                                                                    <select id="dtValidYear" name="cc_expiry_year" class="form-control">
                                                                        <option value="">Ano</option>
                                                                        @for($i = intval(date('Y')); $i < intval(date('Y') + 12); $i++)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <label for="codVerify">CVV</label>
                                                            <input type="text" id="codVerify" class="form-control number" name="cc_cvv" maxlength="3" autocomplete="off">
                                                            <p id="codVerifyEr" class="erroForm">Código verificador inválido.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-4 mt-md-0">
                                                <div id="installments" class="h-100">
                                                    <div class="card shadow-sm h-100">
                                                        <div class="card-header font-weight-bold">PARCELAMENTO</div>
                                                        <div class="card-body">
                                                            @for($i = 1; $i <= 10; $i++)
                                                            <label class="installment-number d-flex align-items-center">
                                                                <input type="radio" class="mr-2" value="{{ $i }}" name="cc_installments" {{ $i === 1 ? 'checked' : '' }}>{{ $i }} x&nbsp;<strong>R$ {{ number_format((($valor_total * $coupon_discount)/$i), 2, ',', '.') }} </strong>&nbsp;sem juros
                                                            </label>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-md-12">
                                                {!! htmlFormSnippet([
                                                    'callback' => 'recaptchaCallback'
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button id="buttCard" class="btn btn-lg btn-login btn-payment"
                                                    type="button" disabled>EFETUAR PAGAMENTO</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="bank-slip" class="tab-pane fade" role="tabpanel" aria-labelledby="bank-slip-tab">
                            <div class="card border-top-0">
                                <div class="card-body boxPay">
                                    <form id="bank-slip_form" method="POST" action="{{ route('checkout.payment') }}" accept-charset="UTF-8">
                                        @csrf
                                        <div id="box-boleto" class="card shadow-sm">
                                            <div class="card-header font-weight-bold">BOLETO</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="alert alert-warning btn-block">
                                                            <p class="lead"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Confirme se os dados estão corretos. Caso seja informado dados inválidos o boleto não será registrado corretamente.</p>
                                                            <p class="lead"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Em caso de falha, verifique:
                                                                </p><ul>
                                                                    <li>O CEP está correto ?</li>
                                                                    <li>O número foi informado ?</li>
                                                                    <li>O estado está correto ?</li>
                                                                </ul>
                                                            <p></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="boxPay text-center">
                                                    <div id="boleto-info">
                                                        <p>
                                                            Clique em "EFETUAR PAGAMENTO" para abrir o boleto em uma nova janela do seu navegador.
                                                        </p>
                                                        <p>A transação será concluída somente após a confirmação do pagamento.</p>
                                                    </div>
                                                    <div id="boleto-message"></div>
                                                    <input type="hidden" name="street">
                                                    <input type="hidden" name="street_number">
                                                    <input type="hidden" name="neighborhood">
                                                    <input type="hidden" name="complement">
                                                    <input type="hidden" name="city">
                                                    <input type="hidden" name="state">
                                                    <input type="hidden" name="country" value="br">
                                                    <input type="hidden" name="zipcode">
                                                    <input type="hidden" name="payment_method" value="boleto">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-4">
                                            <div class="col-md-12">
                                                {!! htmlFormSnippet([
                                                    'callback' => 'recaptchaCallback'
                                                ]) !!}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button id="buttBoleto" class="btn btn-lg btn-login btn-payment"
                                                    type="button" disabled>EFETUAR PAGAMENTO</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                    <div class="empty-checkout my-5 font-weight-bold">
                        <h5 class="text-muted font-weight-bold">SUA LISTA DE CURSOS ESTÁ VAZIA.</h5>
                        <p class="mb-3">Para continuar comprando, navegue pelas categorias do site ou faça uma busca pelo curso desejado.</p>

                        <div class="empty-checkout-link">
                            <a href="/" class="btn btn-large btn-success empty-checkout-button">Escolher cursos</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection

@section('modals')
<!-- Modal Payment -->
<div id="payment-confirmation-modal" class="modal fade default-modal payment-confirmation-modal modal-payment-template"
    data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-body default-modal-body payment-confirmation-modal-body">
        <div class="default-modal-security payment-confirmation-security">
            <i class="fas fa-lock"></i>
        </div>
        <p class="payment-confirmation-content">
            <i class="payment-confirmation-loading loading-img fa fa-spinner fa-spin fast-spinner"></i>
            <span class="ml-2 payment-confirmation-thanks">Aguarde...</span>
        </p>
        <div id="payment-confirmation-message-container">
            <p class="payment-confirmation-message mb-0">Estamos finalizando sua compra.</p>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection
