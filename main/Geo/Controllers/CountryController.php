<?php

namespace Main\Geo\Controllers;

use Illuminate\Http\Request;
use Main\Admin\Controllers\BaseController;
use Main\Geo\Models\Country;

class CountryController extends BaseController
{
    protected $model = Country::class;
    protected $model_titles = [
        'es' => ['singular' => 'País', 'plural' => 'Paises'],
        'en' => ['singular' => 'Country', 'plural' => 'Countries'],
        'pt' => ['singular' => 'País', 'plural' => 'Países']
    ];

    protected $validation_fields = ['name' => 'required', 'phone' => 'required|min:1|max:4', 'iso' => 'required|min:1|max:3'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre', 'phone' => 'Código Telefónico' , 'iso' => 'Código ISO'];

    protected $routes = [
        'list' => 'geo.countries.list',
        'create' => 'geo.countries.create',
        'edit' => 'geo.countries.edit',
        'editurl' => 'geo/paises/editar/',
        'save' => 'geo.countries.save',
        'delete' => 'geo.countries.delete',
        'getdata' => 'geo.countries.getdata',
        'sort' => 'geo.countries.sort',
        'sheet' => 'geo.countries.sheet',
    ];

    protected $view_main = 'geo::countries.list';
    protected $view_edit = 'geo::countries.edit';

    protected $paginate = 20;

    protected $showExportBtn = false;


    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = 'menuConfGeo';
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if (isset($request->id)) {
            $data = $this->validateData($request);
            $data->position = $request->position;
        } else {
            $last_id = Country::latest()->first()->id;
            $data = new Country();
            $data->position = $last_id + 1;
        }

        $this->processCommonFields($request, $data);

        $data->name = $request->name;
        $data->iso = $request->iso;
        $data->phone = $request->phone;

        return parent::store($data);
    }

    public function sheet()
    {
        return false;
    }
}
