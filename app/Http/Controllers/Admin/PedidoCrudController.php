<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PedidoRequest;
use App\Models\Pedido;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PedidoCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PedidoCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use ShowOperation;
    use DeleteOperation {
        destroy as traitDestroy;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Pedido::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/pedido');
        CRUD::setEntityNameStrings('pedido', 'pedidos');
    }

    public function destroy($id)
    {
        CRUD::hasAccessOrFail('delete');
        Pedido::findOrFail($id)->update(['status' => 'ex']);
        return CRUD::delete($id);
    }


    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::addColumn([
            'name' => 'id',
        ]);
        CRUD::addColumn([
            'name' => 'numero_pedido',
            'label' => 'Nº Pedido',
        ]);
        CRUD::addColumn([
            'name' => 'cliente_id',
            'label' => 'Cliente',
            'attribute' => 'nome',
        ]);
        CRUD::addColumn([
            'name' => 'comprador_nome',
            'label' => 'Comprador',
        ]);
        CRUD::addColumn([
            'name' => 'placa',
        ]);
        CRUD::addColumn([
            'name' => 'status',
            'type' => 'select_from_array',
            'options' => [
                'ab' => 'Aberto',
                'ea' => 'Em Andamento',
                'co' => 'Concluído',
                'sc' => 'Solicitado Cancelamento',
                'ex' => 'Excluído',
                'pe' => 'Pendente',
                'rp' => 'Em Análise',
            ],
            'wrapper' => [
                'element' => 'span',
                'class' => function ($crud, $column, $entry, $related_key) {
                    switch ($entry->status) {
                        case 'co':
                        case 'ab':
                            return 'badge rounded-pill bg-success';
                        case 'ea':
                            return 'badge rounded-pill bg-primary';
                        case 'pe':
                        case 'rp':
                        case 'sc':
                            return 'badge rounded-pill bg-warning';
                        case 'ex':
                            return 'badge rounded-pill bg-danger';
                    }
                },
            ],
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PedidoRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    protected function setupShowOperation()
    {
        $this->setupCreateOperation();
    }
}
