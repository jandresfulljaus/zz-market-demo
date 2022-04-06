<?php

namespace Main\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Main\Admin\Controllers\BaseController;
use Main\Auth\Models\Perm;
use Main\Auth\Models\Role;

class RoleController extends BaseController
{
    protected $model = Role::class;
    protected $model_titles = [
        'es' => ['singular' => 'Rol', 'plural' => 'Roles'],
        'en' => ['singular' => 'Role', 'plural' => 'Roles'],
        'pt' => ['singular' => 'Função', 'plural' => 'Funções']
    ];

    protected $validation_fields = ['name' => 'required', 'slug' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre'];

    protected $routes = [
        'list' => 'auth.roles.list',
        'create' => 'auth.roles.create',
        'edit' => 'auth.roles.edit',
        'editurl' => 'roles/editar/',
        'save' => 'auth.roles.save',
        'delete' => 'auth.roles.delete',
        'getdata' => 'auth.roles.getdata',
        'sort' => 'auth.roles.sort',
        'sheet' => 'auth.roles.sheet'
    ];

    protected $view_main = 'auth::roles.list';
    protected $view_edit = 'auth::roles.edit';

    protected $paginate = 20;

    protected $showExportBtn = false;

    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = [
            'menuAuthRole',
        ];
    }

    public function create()
    {
        Gate::authorize('access',$this->routes['create']);

        $this->model_info->perms= Perm::all(['id','name']);
        $this->model_info->perms_role = [];

        return parent::create();
    }

    public function edit($id)
    {
        Gate::authorize('access',$this->routes['edit']);

        $this->model_info->perms = Perm::all(['id','name']);
        $this->model_info->perms_role = Role::with('perm')->find($id)->perm->pluck(['id'])->all();

        return parent::edit($id);
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if (isset($request->id)) {
            $data = $this->validateData($request);
        } else {
            $data = new Role();
        }

        $this->processCommonFields($request, $data);

        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->access = $request->access;

        if ($data->save()) {
            $data->perm()->sync($request->get('perm'));

            return redirect()
                ->route($this->routes['list'])
                ->with('success', 'Las modificaciones se guardaron exitosamente.');
        }

        return redirect()
            ->route($this->routes['list'])
            ->with('error', 'No pude guardar el registro');
    }

    public function sheet()
    {
        return false;
    }
}
