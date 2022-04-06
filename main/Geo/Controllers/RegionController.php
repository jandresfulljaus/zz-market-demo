<?php

namespace Main\Geo\Controllers;

use Main\Admin\Controllers\BaseController;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Main\Geo\Models\Country;
use Main\Geo\Models\Region;

class RegionController extends BaseController
{
    protected $model = Region::class;
    protected $model_titles = [
        'es' => ['singular' => 'Provincia', 'plural' => 'Provincias'],
        'en' => ['singular' => 'Province', 'plural' => 'Provinces'],
        'pt' => ['singular' => 'Província', 'plural' => 'Províncias']
    ];

    protected $validation_fields = ['name' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre'];

    protected $routes = [
        'list' => 'geo.regions.list',
        'create' => 'geo.regions.create',
        'edit' => 'geo.regions.edit',
        'editurl' => 'geo/provincias/editar/',
        'save' => 'geo.regions.save',
        'delete' => 'geo.regions.delete',
        'getdata' => 'geo.regions.getdata',
        'sort' => 'geo.regions.sort',
        'sheet' => 'geo.regions.sheet'
    ];

    protected $view_main = 'geo::regions.list';
    protected $view_edit = 'geo::regions.edit';

    protected $paginate = 20;

    protected $showExportBtn = false;

    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = 'menuConfGeo';
    }

    public function index()
    {
        $this->model_info->filter = Country::all(['id','name'])->sortBy('position');

        return parent::index();
    }

    public function create()
    {
        $this->model_info->countries = Country::all(['id','name'])->sortBy('position');

        return parent::create();
    }

    public function edit($id)
    {
        $this->model_info->countries = Country::all(['id','name'])->sortBy('position');

        return parent::edit($id);
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if (isset($request->id)) {
            $data = $this->validateData($request);
            $data->position=$request->position;
        } else {
            $last_id = Region::all()->last()->id;
            $data = new Region();
            $data->position = $last_id + 1;
        }

        $data->name = $request->name;
        $data->country_id = $request->country_id;

        $this->processCommonFields($request, $data);

        return parent::store($data);
    }

    public function sheet()
    {
        return false;
    }
}
