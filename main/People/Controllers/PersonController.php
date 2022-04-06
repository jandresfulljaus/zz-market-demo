<?php

namespace Main\People\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Main\Admin\Controllers\BaseController;
use Main\Geo\Models\City;
use Main\People\Models\Person;

class PersonController extends BaseController
{
    protected $model = Person::class;
    protected $model_titles = [
        'es' => ['singular' => 'Persona', 'plural' => 'Personas'],
        'en' => ['singular' => 'Person', 'plural' => 'People'],
        'pt' => ['singular' => 'Pessoa', 'plural' => 'Pessoas']
    ];

    protected $validation_fields = [
        'name' => 'required|string|max:200',
        'typedni' => 'required|string|max:6',
        'dni' => 'required|string|max:10',
        'cuit' => 'nullable|string|max:13',
        'birthday' => 'nullable|date',
        'city_id' => 'required|exists:geo_cities,id',
    ];
    protected $message_fields = [];
    protected $names_fields = [
        'name' => 'Nombre',
        'typedni' => 'Tipo de documento',
        'dni' => 'Nro. de documento',
        'cuit' => 'CUIT',
        'birthday' => 'Fecha de nacimiento',
        'city_id' => 'Ciudad',
    ];

    protected $routes = [
        'list' => 'people.persons.list',
        'edit' => 'people.persons.edit',
        'editurl' => 'personas/editar/',
        'delete' => 'people.persons.delete',
        'create' => 'people.persons.create',
        'sort' => 'people.persons.sort',
        'save' => 'people.persons.save',
        'getdata' => 'people.persons.getdata',
        'sheet' => 'people.persons.sheet'
    ];

    protected $view_main = 'people::persons.list';
    protected $view_edit = 'people::persons.edit';

    protected $paginate = 20;

    protected $showExportBtn = false;

    public function initController()
    {
        parent::initController();
    }

    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = [
            'menuAuthUser',
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
            $data = new Person();
        }

        $this->processCommonFields($request, $data);

        $data->name = $request->name;
        $data->dni = $request->dni;
        $data->typedni = $request->typedni;
        $data->birthday = $request->birthday;
        $data->city_id = $request->city_id;
        $data->cuit = $request->cuit;

        return parent::store($data);
    }

    public function find(Request $request = null)
    {
        return parent::getdata($request);
    }

    public function sheet()
    {
        return false;
    }
}
