<?php

namespace Main\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Main\Admin\Controllers\BaseController;
use Main\Auth\Models\Organization;
use Main\Geo\Models\City;

class OrganizationController extends BaseController
{
    protected $model = Organization::class;
    protected $model_titles = [
        'es' => ['singular' => 'Solicitante', 'plural' => 'Solicitantes'],
        'en' => ['singular' => 'Applicant', 'plural' => 'Applicants'],
        'pt' => ['singular' => 'Requerente', 'plural' => 'Requerentes']
    ];

    protected $validation_fields = ['name' => 'required', 'url' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre', 'url' => 'URL de la organizacion'];

    protected $routes = [
        'list' => 'auth.organizations.list',
        'create' => 'auth.organizations.create',
        'edit' => 'auth.organizations.edit',
        'editurl' => 'solicitantes/editar/',
        'save' => 'auth.organizations.save',
        'delete' => 'auth.organizations.delete',
        'getdata' => 'auth.organizations.getdata',
        'mygetdata' => 'auth.organizations.mygetdata',
        'sort' => 'auth.organizations.sort',
        'sheet' => 'auth.organizations.sheet',
        'precreate' => 'auth.organizations.precreate',
    ];

    protected $view_main = 'auth::organizations.list';
    protected $view_edit = 'auth::organizations.edit';
    protected $view_organizations = 'auth::organizations.list-to-create-order';

    protected $paginate = 20;

    protected $showExportBtn = false;

    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = [
            'menuAuthOrganizations',
        ];
    }

    public function setModelInfo()
    {
        City::$ordinal_field = 'name';
        $this->model_info->cities = City::getdata()->get();
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if (isset($request->id)) {
            $data = $this->validateData($request);
        } else {
            $data = new Organization();
        }

        $data->name = $request->name;
        $data->url = $request->url;
        $data->city_id = $request->city_id;

        $this->processCommonFields($request, $data);

        return parent::store($data);
    }


    public function mygetdata(Request $request = null)
    {
        Gate::authorize('access',$this->routes['mygetdata']);
        if (isset($_POST["ordinal_field"]) && $_POST["ordinal_field"]!="") {
            $this->model::$ordinal_field=$_POST["ordinal_field"];
            $this->model::$ordinal_order=$_POST["ordinal_order"];
        }

        $data = $this->model::mygetdata($request)->paginate($this->paginate);

        // SUCCESS
        $response = [
            'status' => 'true',
            'message' => 'Los datos se han enviado de forma satisfactoria',
            'data' => $data
        ];

        return response()->json($response, 200);
    }




    public function sheet()
    {
        return false;
    }
}
