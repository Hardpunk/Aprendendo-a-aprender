@extends('layouts.checkout', ['steps' => [true, true, true]])

@section('css')
    <!-- Toastr -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
@endsection

@section('content')
    <section id="checkout-confirmation" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="row">
                        <div class="col-md-12">
                        @if($payment->status == 'paid')
                            @include('pages.checkout._confirmation-success')
                        @else
                            @include('pages.checkout._confirmation-processing')
                        @endif
                        </div>
                        <div class="col-md-12 mt-5 checkout-confirmation-summary">
                            <h4 class="mt-0 mb-1 font-weight-bold d-flex align-items-center">
                                <span>Pedido {{ $payment->order_id }}</span>
                                @if($payment->payment_method == 'Boleto')
                                <i class="fas fa-barcode ml-3" title="Boleto"></i>
                                @else
                                <i class="fas fa-credit-card ml-3" title="Cartão de Crédito"></i>
                                @endif
                            </h4>
                            <p class="mb-0">{{ $payment->created_at->formatLocalized('%d de %B de %Y') }}</p>

                            <div class="table-responsive mt-4">
                                <table class="table table-hover mb-0" id="tableCartItems">
                                    <thead>
                                        <tr>
                                            <th colspan="2">CURSO</th>
                                            <th class="text-right">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($items as $type => $arrayItem)
                                        @foreach($arrayItem as $item)
                                        @php
                                            $itemPrice = $type == 'trail' ? round($item->price * (1 - ($item->discount / 100)), 2) : $item->price;
                                            $itemPrice = numberFormatPrecision($itemPrice * (1 - (($payment->discount ?? 0)/100)), 2);
                                        @endphp
                                        <tr>
                                            <td class="item-image">
                                                <a class="d-block" href="{{ $type === 'trail' ? route('trails.show', [$item->slug]) : (isset($item->category_slug) ? route('courses.course_details', [$item->category_slug, $item->slug]) : '') }}">
                                                    <img class="img-fluid" src="{{ $type === 'trail' ? $item->cover : $item->image }}" />
                                                </a>
                                            </td>
                                            <td>
                                                <a class="d-block" href="{{ $type === 'trail' ? route('trails.show', [$item->slug]) : (isset($item->category_slug) ? route('courses.course_details', [$item->category_slug, $item->slug]) : '') }}">
                                                {{ $type === 'trail' ? 'TRILHA DO CONHECIMENTO - ' : '' }}{{ mb_strtoupper($item->title) }}
                                                </a>
                                            </td>
                                            <td class="text-right">R$ {{ number_format($itemPrice, 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="pt-4 mt-1 border-top border-dark">
                                <h4 class="font-weight-bold text-right">Total: R$ <label id="totalCost">{{ number_format($payment->amount, 2, ',', '.') }}</label></h4>
                            </div>

                            <hr>

                            <a href="/" class="btn btn-large btn-success back-to-site m-0">Voltar ao site</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
            integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        function copyText(e) {
            e.preventDefault();

            let text = $(this).data('barcode');
            navigator.clipboard.writeText(text);

            toastr.options.preventDuplicates = true;
            toastr.success('Link copiado com sucesso!');
        }

        $(document).on('click', 'button.copy', copyText);
    </script>
@endpush
