<?php

namespace Modules\Auditory\Controllers;

use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Main\Admin\Controllers\BaseController;
use Modules\Auditory\Models\Auditory;

class AuditoryController extends BaseController
{
    protected $model = Auditory::class;
    protected $model_titles = [
        'es' => ['singular' => 'Auditoría', 'plural' => 'Auditorías'],
        'en' => ['singular' => 'Audit', 'plural' => 'Audits'],
        'pt' => ['singular' => 'Auditoria', 'plural' => 'Auditorias']
    ];

    protected $validation_fields = ['name' => 'required'];
    protected $message_fields = [];
    protected $names_fields = ['name' => 'Nombre'];

    protected $routes = [
        'list' => 'auditory.list',
        'create' => 'auditory.create',
        'edit' => 'auditory.edit',
        'editurl' => 'auditoria/editar/',
        'save' => 'auditory.save',
        'delete' => 'auditory.delete',
        'getdata' => 'auditory.getdata',
        'sort' => 'auditory.sort',
        'sheet' => 'auditory.sheet'
    ];

    protected $view_main = 'auditory::auditories.list';
    protected $view_edit = 'auditory::auditories.edit';

    protected $paginate = 20;

    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = [
            'menuAuthAuditory',
        ];
        $this->showCreateBtn=false;
    }

    public function setModelInfo()
    {
        $this->model_info->actions['edit']=[];
        $this->model_info->actions['delete']=[];
        
    }

    public function list()
    {
        $this->setModelInfo();
        $this->auditory->save('access', 'Accedió al listado de auditoría', 'auditory');
        return parent::list();
    }

    public function sheet()
    {
        Gate::authorize('access',$this->routes['sheet']);

        $this->auditory->save('sheet', 'Exportó el listado de auditoría', 'auditory');

        $filename = date('YmdHis') . '_Auditoria';

        return Excel::download(new AuditorySheet, $filename.'.xlsx');
    }
}
