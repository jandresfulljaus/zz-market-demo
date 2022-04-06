<?php

namespace Main\Auth\Controllers;

use Illuminate\Http\Request;
use Main\Admin\Controllers\BaseController;
use Main\Auth\Models\Perm;

class PermController extends BaseController
{
    protected $model = Perm::class;
    protected $model_titles = [
        'es' => ['singular' => 'Permiso', 'plural' => 'Permisos'],
        'en' => ['singular' => 'Permission', 'plural' => 'Permissions'],
        'pt' => ['singular' => 'Permissão', 'plural' => 'Permissões']
    ];

    protected $validation_fields = ['name' => 'required', 'slug' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre'];

    protected $routes = [
        'list' => 'auth.perms.list',
        'create' => 'auth.perms.create',
        'edit' => 'auth.perms.edit',
        'editurl' => 'permisos/editar/',
        'save' => 'auth.perms.save',
        'delete' => 'auth.perms.delete',
        'getdata' => 'auth.perms.getdata',
        'sort' => 'auth.perms.sort',
        'sheet' => 'auth.perms.sheet'
    ];

    protected $view_main = 'auth::perms.list';
    protected $view_edit = 'auth::perms.edit';

    protected $paginate = 20;

    protected $showExportBtn = false;
    protected $showCreateBtn = false;

    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = [
            'menuAuthPerm',
        ];
        
    }
    public function setModelInfo()
    {
        $this->model_info->actions['edit']=[];
        $this->model_info->actions['delete']=[];
    }

    public function list()
    {
        $this->setModelInfo();
        return parent::list();
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if (isset($request->id)) {
            $data = $this->validateData($request);
        } else {
            $data = new Perm();
        }

        $data->name = $request->name;

        $this->processCommonFields($request, $data);

        return parent::store($data);
    }

    public function sheet()
    {
        return false;
    }
}
