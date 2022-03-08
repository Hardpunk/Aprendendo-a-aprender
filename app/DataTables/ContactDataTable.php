<?php

namespace App\DataTables;

use App\Contact;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ContactDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin.contacts.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Contact $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contact $model)
    {
        return $model->newQuery();
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
            ->addAction([
                'width' => '80px',
                'title' => 'Ações',
                'className' => 'text-center',
                'printable' => false,
            ])
            ->parameters([
                'language' => [
                    'url' => '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json',
                ],
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    //['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => [
                'title' => '#ID',
                'searchable' => false,
                'width' => '60px',
                'className' => 'text-center'
            ],
            'name' => [
                'data' => 'name',
                'title' => 'Nome',
                'searchable' => true,
                'orderable' => true,
            ],
            'email' => [
                'data' => 'email',
                'title' => 'E-mail',
                'searchable' => true,
                'orderable' => true,
            ],
            'phone' => [
                'data' => 'phone',
                'title' => 'Telefone',
                'searchable' => false,
                'orderable' => false,
            ],
            'created_at' => [
                'data' => 'created_at',
                'title' => 'Data registro',
                'width' => '150px',
                'searchable' => false,
                'orderable' => true,
                'className' => 'text-center',
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
        return 'contatos_' . time();
    }
}
