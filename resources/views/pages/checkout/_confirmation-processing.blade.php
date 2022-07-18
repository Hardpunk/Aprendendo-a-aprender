<div class="checkout-confirmation-content p-4 rounded">
    <h4 class="font-weight-bold mt-0 mb-4">
        <i class="fas fa-check-circle left green-text"></i>
        @if($payment->payment_method == 'Boleto')
            <span>Boleto gerado com sucesso!</span>
            <a href="{{ $payment->boleto_url }}" target="_blank" class="btn btn-success">Visualizar boleto</a>
            <button type="button" data-barcode="{{ $payment->boleto_barcode }}"
                    class="btn btn-primary copy">Copiar código de barras</button>
        @else
            <span>Seu pagamento está sendo processado.</span>
        @endif
    </h4>
    <p class="mb-0">Assim que o pagamento for faturado, você receberá um novo e-mail com os dados de acesso à nossa
        plataforma de ensino.</p>
</div>
