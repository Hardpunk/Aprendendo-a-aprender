<div class="invoice m-0">
    <div class="row">
        <div class="col-sm-6 mb-2 mb-sm-0">
            <h4 class="page-header mb-0">
                <strong>{{ $payment->user->name }}</strong>
            </h4>
        </div>
        <div class="col-sm-6">
            <h5 class="float-sm-right mb-0">Data
                compra: {{ $payment->created_at->formatLocalized('%d de %B de %Y às %T') }}</h5>
        </div>
    </div>

    <hr class="my-2">

    <div class="row invoice-info">
        <div class="col-sm-6 invoice-col form-group">
            <div>
                <h4 class="mt-0"><strong>Dados pessoais</strong></h4>
                <strong>CPF:</strong> {{ format_cpf_cnpj($payment->user->profile->document_number) }}<br>
                <strong>Telefone:</strong> <span class="phone-mask">{{ $payment->user->profile->phone }}</span><br>
                <strong>E-mail:</strong> {{ $payment->user->email }}
            </div>
        </div>

        <div class="col-sm-6 invoice-col form-group">
            <h4 class="mt-0"><strong>Endereço</strong></h4>
            <address class="mt-0">
                {{ $payment->user->profile->street }}, Nº {{ $payment->user->profile->number }}<br>
                {{ $payment->user->profile->neighborhood }}, {{ $payment->user->profile->city }}
                - {{ $payment->user->profile->state }}<br>
                {{ format_zipcode($payment->user->profile->zipcode) }}<br>
                @if($payment->user->profile->complement)
                    Complemento: {{ $payment->user->profile->complement }}
                @endif
            </address>
        </div>

        <div class="col-sm-12 col-md-8 invoice-col form-group">
            <h4 class="mt-0"><strong>Dados da Compra</strong></h4>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <b>Fatura</b> #{{ $payment->order_id }}<br>
                    <b>Data pagamento:</b> {{ $payment->created_at->format('d/m/Y H:i:s') }}<br>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            @if($payment->payment_method == 'Cartão de crédito')
                                <b>Método Pagamento:</b><br>
                                <span class="badge badge-credit-card"><i class="fas fa-credit-card"></i>  Cartão de Crédito</span>
                            @else
                                <b>Método Pagamento:</b><br>
                                <span class="badge badge-bank-slip"><i class="fas fa-barcode"></i>  Boleto</span>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <b>Status:</b><br>
                            {!! get_payment_status_label($payment->status) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(count($payment->items()) > 0)
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th>Produto</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payment->items() as $item)
                        <tr>
                            <td>{{ $item['checkout_title'] ?? $item['title'] }}</td>
                            <td class="text-right">
                                R$ {{ number_format(($item['price'] ?? $item['amount']), 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    @if($payment->coupon)
                        <tr class="text-success">
                            <td><strong>Desconto</strong></td>
                            <td class="text-right"><strong>({{ number_format($payment->coupon->discount, 2, ',', '.') }}
                                    %)
                                    R$ {{ number_format($payment->amount*($payment->coupon->discount/100), 2, ',', '.') }}</strong>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4" class="text-right" style="border-top: 1px dashed #9C9C9C">
                            <strong>TOTAL:</strong> R$ {{ number_format($payment->amount, 2, ',', '.') }}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    @endif

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            {{--<a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>--}}
            <a href="{!! route('admin.payments.index') !!}" class="btn btn-default">Voltar</a>
        </div>
    </div>
</div>
