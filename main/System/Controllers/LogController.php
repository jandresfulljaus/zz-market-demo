<?php

namespace Main\System\Controllers;

use Illuminate\Http\Request;
use Main\Admin\Controllers\BaseController;
use Main\Auth\Models\Organization;
use Main\System\Models\Log;

class LogController extends BaseController
{
    protected $model = Log::class;
    protected $model_titles = [
        'es' => ['singular' => 'Log', 'plural' => 'Logs'],
        'en' => ['singular' => 'Log', 'plural' => 'Logs']
    ];

    protected $validation_fields = ['name' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre'];

    protected $routes = [
        'list' => 'system.logs.list',
        'create' => 'system.logs.create',
        'edit' => 'system.logs.edit',
        'save' => 'system.logs.save',
        'delete' => 'system.logs.delete',
        'getdata' => 'system.logs.getdata',
        'sort' => 'system.logs.sort',
        'sheet' => 'system.logs.sheet'
    ];

    protected $view_main = 'system::logs.list';
    protected $view_edit = 'system::logs.edit';

    protected $paginate = 20;

    public function index()
    {
        $this->model_info->filter = Organization::all(['id','name']);

        return parent::index();
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if (isset($request->id)) {
            $data = $this->validateData($request);
        } else {
            $data = new Log();
        }

        $this->processCommonFields($request, $data);

        $data->name = $request->name;

        return parent::store($data);
    }

    public function sheet()
    {
        return false;
    }
}
