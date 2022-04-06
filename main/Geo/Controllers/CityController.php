<?php

namespace Main\Geo\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Main\Admin\Controllers\BaseController;
use Main\Geo\Models\City;
use Main\Geo\Models\Region;

class CityController extends BaseController
{
    protected $model = City::class;
    protected $model_titles = [
        'es' => ['singular' => 'Ciudad', 'plural' => 'Ciudades'],
        'en' => ['singular' => 'City', 'plural' => 'Cities'],
        'pt' => ['singular' => 'Cidade', 'plural' => 'Cidades']
    ];

    protected $validation_fields = ['name' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre'];

    protected $routes = [
        'list' => 'geo.cities.list',
        'create' => 'geo.cities.create',
        'edit' => 'geo.cities.edit',
        'editurl' => 'geo/ciudades/editar/',
        'save' => 'geo.cities.save',
        'delete' => 'geo.cities.delete',
        'getdata' => 'geo.cities.getdata',
        'sort' => 'geo.cities.sort',
        'sheet' => 'geo.cities.sheet'
    ];

    protected $view_main = 'geo::cities.list';
    protected $view_edit = 'geo::cities.edit';

    protected $paginate = 20;

    protected $showExportBtn = false;

    public function index()
    {
        $this->model_info->filter = Region::select('geo_regions.id', DB::raw('CONCAT(geo_countries.name, " - ", geo_regions.name) AS name'))
            ->join('geo_countries', 'geo_regions.country_id', '=', 'geo_countries.id')
            ->orderBy('geo_countries.name','ASC')
            ->get();

        return parent::index();
    }

    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = 'menuConfGeo';
    }

    public function create()
    {
        $this->model_info->regions = Region::all(['id','name'])->sortBy('position');

        return parent::create();
    }

    public function edit($id)
    {
        $this->model_info->regions = Region::select('geo_regions.id', DB::raw('CONCAT(geo_countries.name, " - ", geo_regions.name) AS name'))
            ->join('geo_countries', 'geo_regions.country_id', '=', 'geo_countries.id')
            ->orderBy('geo_countries.name','ASC')
            ->get();

        return parent::edit($id);
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if (isset($request->id)) {
            $data = $this->validateData($request);
        } else {
            $last_id = City::all()->last()->id;

            $data = new City();

            $data->position = $last_id + 1;
        }

        $this->processCommonFields($request, $data);

        $data->zonename = $request->zonename;
        $data->name = $request->name;
        $data->region_id = $request->region_id;
        $data->longitude = $request->longitude;
        $data->latitude = $request->latitude;
        $data->status = ($request->status == 'on') ? 1 : 0;

        return parent::store($data);
    }

    public function sheet()
    {
        return false;
    }
}
