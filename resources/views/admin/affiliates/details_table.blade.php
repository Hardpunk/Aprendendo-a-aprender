@push('third_party_stylesheets')
    @include('layouts.datatables_css')
@endpush


<div class="table-responsive">
    <table id="affiliate-details-table" class="w-100 table table-striped table-bordered">
        <thead>
        <tr>
            <th>Aluno</th>
            <th style="width: 180px;" class="text-center">Data venda</th>
            <th style="width: 80px;" class="text-center">Detalhes</th>
            <th class="d-none"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($affiliate->payments as $payment)
            <tr>
                <td>{{ $payment->user->name }}</td>
                <td class="text-center">{{ $payment->created_at->format('d/m/Y  -  H:i') }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-success">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
                <td class="d-none trails">
                    @json($payment->trails)
                </td>
                <td class="d-none courses">
                    @json($payment->courses)
                </td>
                <td class="d-none discount">{{ $payment->discount ?? 0 }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


@push('third_party_scripts')
    @include('layouts.datatables_js')
    <script>
        let commission = {{ number_format($affiliate->commission/100, 2, '.', '') }};
        let oTable = $('#affiliate-details-table').DataTable({
            order: [[1, 'desc']],
            columnDefs: [
                {
                    targets: 3,
                    visible: false
                },
                {
                    targets: 4,
                    visible: false
                },
                {
                    targets: 5,
                    visible: false,
                }
            ],
            columns: [
                {
                    name: "Aluno",
                    searchable: false
                },
                {
                    name: "Data venda",
                    searchable: false
                },
                {
                    name: "Detalhes",
                    searchable: false,
                    orderable: false,
                    className: 'payment-details-control'
                },
                {
                    data: "trails",
                    visible: false,
                },
                {
                    data: "courses",
                    visible: false,
                },
                {
                    data: "discount",
                    visible: false,
                }
            ],
            processing: true,
            language: {url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'},
            dom: 'rtip',
        });

        $('#affiliate-details-table tbody').on('click', 'td.payment-details-control > button', function () {
            let $this = $(this),
                tr = $this.closest('tr'),
                row = oTable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                $this.find('i.fas').removeClass('fa-minus').addClass('fa-plus');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
                $this.find('i.fas').removeClass('fa-plus').addClass('fa-minus');
            }
        });

        function format(d) {
            let trails = JSON.parse(d.trails),
                courses = JSON.parse(d.courses),
                discount = parseFloat(d.discount)/100,
                moneyFormatter = new Intl.NumberFormat('pt-BR', {
                    style: 'currency',
                    currency: 'BRL'
                }),
                percentFormatter = new Intl.NumberFormat('pt-BR', {
                    style: 'percent',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

            /*if (coupon) {
                discount = (coupon.discount/100);
            }*/

            let html = `
                <table class="table table-bordered table-sm mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Curso</th>
                            <th class="text-center">Cupom desconto</th>
                            <th class="text-center">Valor total</th>
                            <th class="text-center">Comissão</th>
                        </tr>
                    </thead>
                    <tbody>`;

            if (trails.length > 0) {
                trails.forEach(function (trail, i) {
                    html += `
                        <tr>
                            <td>${trail.checkout_title}</td>
                            <td class="text-center" style="width: 180px">${percentFormatter.format(discount)}</td>
                            <td class="text-center" style="width: 150px">${moneyFormatter.format(trail.price * (1 - discount))}</td>
                            <td class="text-center" style="width: 180px">${moneyFormatter.format((trail.price * (1 - discount)) * commission)}  (${percentFormatter.format(commission)})</td>
                        </tr>
                    `;
                });
            }

            if (courses.length > 0) {
                courses.forEach(function(course, i) {
                    html += `
                        <tr>
                            <td>${course.title}</td>
                            <td class="text-center" style="width: 180px">${percentFormatter.format(discount)}</td>
                            <td class="text-center" style="width: 150px">${moneyFormatter.format(course.price * (1 - discount))}</td>
                            <td class="text-center" style="width: 180px">${moneyFormatter.format((course.price * (1 - discount)) * commission)}  (${percentFormatter.format(commission)})</td>
                        </tr>
                    `;
                });
            }

            html += `
                    </tbody>
                </table>`;

            return html;
        }
    </script>
@endpush
