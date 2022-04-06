<?php

namespace Main\Auth\Controllers;

use Illuminate\Http\Request;
use Main\Admin\Controllers\BaseController;
use Main\Auth\Models\Branch;
use Main\Auth\Models\Organization;
use Main\Geo\Models\City;

class BranchController extends BaseController
{
    protected $model = Branch::class;
    protected $model_titles = [
        'es' => ['singular' => 'Destinatario', 'plural' => 'Destinatarios'],
        'en' => ['singular' => 'Addressee', 'plural' => 'Addressees'],
        'pt'=>['singular'=>'Destinatário','plural'=>'Destinatários']
    ];

    protected $validation_fields = ['name' => 'required', 'address' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre', 'address' => 'Dirección'];

    protected $routes = [
        'list' => 'auth.branches.list',
        'create' => 'auth.branches.create',
        'edit' => 'auth.branches.edit',
        'editurl' => 'destinatario/editar/',
        'save' => 'auth.branches.save',
        'delete' => 'auth.branches.delete',
        'getdata' => 'auth.branches.getdata',
        'sort' => 'auth.branches.sort',
        'sheet' => 'auth.branches.sheet'
    ];

    protected $view_main = 'Auth.Views.branches.list';
    protected $view_edit = 'Auth.Views.branches.edit';

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
        $cities = City::getdata()->get();

        foreach ($cities as $key => $city) {
            $cities[$key]->name = $city->name.', '.$city->region->name.', '.$city->region->country->name;
        }

        // $this->model_info->cities = City::getdata()->get();
        $this->model_info->cities = $cities;
        Organization::$ordinal_field = 'name';
        $this->model_info->organizations = Organization::select(['id','name'])->where('id', '>', 1)->get();
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if ($request->filled('id')) {
            $data = $this->validateData($request);
        } else {
            $data = new Branch();
        }

        $data->name = $request->name;
        $data->address = $request->address;
        $data->organization_id = $request->organization_id;
        $data->city_id = $request->city_id;

        $this->processCommonFields($request, $data);

        $data->name = $request->name;

        return parent::store($data);
    }

    public function sheet()
    {
        return false;
    }
}
