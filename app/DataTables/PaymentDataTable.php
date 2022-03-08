<?php

namespace App\DataTables;

use App\Payment;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class PaymentDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query  Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin.payments.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Payment  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Payment $model)
    {
        return $model->newQuery()->with('courses', 'trails', 'user.profile');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(
                [
                    'width'     => '80px',
                    'title'     => 'Ações',
                    'className' => 'text-center',
                    'printable' => false
                ]
            )
            ->parameters(
                [
                    'language'  => [
                        'url' => '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json',
                    ],
                    'dom'       => 'Bfrtip',
                    'stateSave' => true,
                    'order'     => [[0, 'desc']],
                    'buttons'   => [
                        ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                        ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                        ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                    ],
                ]
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id'             => [
                'data'       => 'id',
                'title'      => '#ID',
                'width'      => '60px',
                'searchable' => false,
                'orderable'  => true,
                'className'  => 'text-center',
            ],
            'name'           => [
                'data'       => 'user.name',
                'title'      => 'Aluno',
                'searchable' => true,
                'orderable'  => true,
            ],
            'payment_method' => [
                'data'       => 'payment_method',
                'title'      => 'Método Pagamento',
                'width'      => '150px',
                'searchable' => false,
                'orderable'  => false,
                'className'  => 'text-center',
            ],
            'amount'         => [
                'data'       => 'amount',
                'title'      => 'Valor',
                'width'      => '120px',
                'searchable' => false,
                'orderable'  => true,
                'className'  => 'text-center',
                'render'     => function () {
                    return 'function ( data, type, row ) {
                        return parseFloat(data).toLocaleString("pt-br",{style: "currency", currency: "BRL"});
                    }';
                },
            ],
            'installments'   => [
                'data'       => 'installments',
                'title'      => 'Parcelas',
                'width'      => '80px',
                'searchable' => false,
                'orderable'  => false,
                'className'  => 'text-center',
            ],
            'status'         => [
                'data'       => 'status',
                'title'      => 'Status',
                'width'      => '120px',
                'searchable' => false,
                'orderable'  => true,
                'className'  => 'text-center',
                'render'     => function () {
                    return 'function( data, type, row ) {
                        let label = "";
                        switch(data) {
                            case "Aprovado":
                                label = "<span class=\"badge badge-success\">"+data+"</span>";
                                break;
                            case "Recusado":
                                label = "<span class=\"badge badge-danger\">"+data+"</span>";
                                break;
                            case "Em processo":
                                label = "<span class=\"badge badge-info\">"+data+"</span>";
                                break;
                        }
                        return label;
                    }';
                },
            ],
            'created_at'     => [
                'data'       => 'created_at',
                'title'      => 'Data venda',
                'width'      => '150px',
                'searchable' => false,
                'orderable'  => true,
                'className'  => 'text-center',
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'relatorio_vendas_'.time();
    }
}
