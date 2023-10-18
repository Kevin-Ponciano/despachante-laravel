<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Request;

class UserCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation {
        store as traitStore;
    }
    use UpdateOperation {
        update as traitUpdate;
    }
    use DeleteOperation;

    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.models.user'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(backpack_url('user'));
    }

    public function setupListOperation()
    {
        $filtroEmpresa = Request::get('empresa-filtro');
        if ($filtroEmpresa)
            CRUD::addClause('whereHas', $filtroEmpresa);
        $this->crud->addColumn([
            'name' => 'id',
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => trans('backpack::permissionmanager.name'),
            'type' => 'text',
        ]);
        $this->crud->addColumn([
            'name' => 'email',
            'label' => trans('backpack::permissionmanager.email'),
            'type' => 'email',
        ]);
        if ($filtroEmpresa == 'despachante') {
            $this->crud->addColumn([
                'name' => 'despachante_id',
                'label' => 'Despachante',
                'entity' => 'despachante',
                'attribute' => 'razao_social',
                'wrapper' => [
                    'element' => 'a',
                    'class' => 'badge bg-primary',
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('despachante/' . $entry->despachante->id . '/show');
                    },
                ]
            ]);
        } elseif ($filtroEmpresa == 'cliente') {
            $this->crud->addColumn([
                'name' => 'cliente_id',
                'label' => 'Cliente',
                'entity' => 'cliente',
                'attribute' => 'nome',
                'wrapper' => [
                    'element' => 'a',
                    'class' => 'badge bg-warning',
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('cliente/' . $entry->cliente->id . '/show');
                    },
                ]
            ]);
        } else {
            $this->crud->addColumn([
                'name' => 'empresa_',
                'label' => 'Empresa',
                'type' => 'closure',
                'function' => function ($entry) {
                    return $entry->empresa()->getNome();
                },
                'wrapper' => [
                    'element' => 'a',
                    'class' => function ($crud, $column, $entry, $related_key) {
                        if ($entry->isDespachante()) {
                            return 'badge rounded-pill bg-primary';
                        } elseif ($entry->isCliente()) {
                            return 'badge rounded-pill bg-warning';
                        } else {
                            return 'badge rounded-pill bg-danger';
                        }
                    },
                    'href' => function ($crud, $column, $entry, $related_key) {
                        if ($entry->isDespachante())
                            return backpack_url('despachante/' . $entry->despachante->id . '/show');
                        elseif ($entry->isCliente())
                            return backpack_url('cliente/' . $entry->cliente->id . '/show');
                        else
                            return '#';
                    },
                ],
            ]);
        }
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'select_from_array',
            'options' => [
                'at' => 'Ativo',
                'in' => 'Inativo',
                'ex' => 'Excluído',
            ],
            'wrapper' => [
                'element' => 'span',
                'class' => function ($crud, $column, $entry, $related_key) {
                    switch ($entry->status) {
                        case 'at':
                            return 'badge rounded-pill bg-success';
                        case 'in':
                            return 'badge rounded-pill bg-warning';
                        case 'ex':
                            return 'badge rounded-pill bg-danger';
                    }
                },
            ],
        ]);
        $this->crud->addColumn([ // n-n relationship (with pivot table)
            'label' => trans('backpack::permissionmanager.roles'), // Table column heading
            'type' => 'select_multiple',
            'name' => 'roles', // the method that defines the relationship in your Model
            'entity' => 'roles', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => config('permission.models.role'), // foreign key model
        ]);
        $this->crud->addColumn([ // n-n relationship (with pivot table)
            'label' => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
            'type' => 'select_multiple',
            'name' => 'permissions', // the method that defines the relationship in your Model
            'entity' => 'permissions', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => config('permission.models.permission'), // foreign key model
        ]);
        CRUD::addButtonFromView('top', 'empresas', 'empresas', 'end');
    }


    public function setupCreateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(StoreRequest::class);
    }

    protected function addUserFields()
    {
        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'email',
            ],
            [
                'name' => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type' => 'password',
            ],
            [
                'name' => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type' => 'password',
            ],
            [
                // two interconnected entities
                'label' => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type' => 'checklist_dependency',
                'name' => 'roles,permissions',
                'subfields' => [
                    'primary' => [
                        'label' => trans('backpack::permissionmanager.roles'),
                        'name' => 'roles', // the method that defines the relationship in your Model
                        'entity' => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user
                        'model' => config('permission.models.role'), // foreign key model
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label' => mb_ucfirst(trans('backpack::permissionmanager.permission_plural')),
                        'name' => 'permissions', // the method that defines the relationship in your Model
                        'entity' => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user
                        'model' => config('permission.models.permission'), // foreign key model
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
        ]);
    }

    public function setupUpdateOperation()
    {
        $this->addUserFields();
        $this->crud->setValidation(UpdateRequest::class);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitStore();
    }

    /**
     * Handle password input fields.
     */
    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }

    /**
     * Update the specified resource in the database.
     *
     * @return RedirectResponse
     */
    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitUpdate();
    }
}
