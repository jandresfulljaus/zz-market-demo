<?php

namespace Modules\Form\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Main\Admin\Controllers\BaseController;
use Modules\Form\Models\DataUpdate;
use Modules\Form\Requests\DataUpdateRequest;

class DataUpdateController extends BaseController
{
    protected $model = DataUpdate::class;
    protected $model_titles = [
        'es' => ['singular' => 'Formulario de actualización de datos', 'plural' => 'Formulario de actualización de datos'],
        'en' => ['singular' => 'Data update form', 'plural' => 'Data update form']
    ];

    protected $routes = [
        'list' => 'form.data_updates.list',
        'create' => 'form.data_updates.create',
        'edit' => 'form.data_updates.edit',
        'editurl' => 'formularios/actualizacion-de-datos/editar/',
        'print' => 'form.data_updates.print',
        'printurl' => 'formularios/actualizacion-de-datos/imprimir/',
        'save' => 'form.data_updates.save',
        'process' => 'form.data_updates.process',
        'delete' => 'form.data_updates.delete',
        'getdata' => 'form.data_updates.getdata',
        'sort' => 'form.data_updates.sort',
        'sheet' => 'form.data_updates.sheet'
    ];

    protected $view_main = 'form::data-updates.list';
    protected $view_edit = 'form::data-updates.edit';
    protected $view_print = 'form::data-updates.print';

    protected $paginate = 20;

    protected $showExportBtn = false;

    public function initController()
    {
        parent::initController();

        if (! isset($this->model_info->actions['process']) && Gate::allows('access', $this->routes['process'])) {
            array_unshift($this->model_info->actions, [
                "type" => "button",
                "title" => "Procesar",
                "icon" =>"mi-done-all",
                "icon_class" =>"btn-primary btn-link btn-float font-size-sm font-weight-semibold",
                "route"=> route($this->routes['process']), "event" => 'onsubmit="return confirm(\'¿Está seguro que desea procesar este registro?\');"'
            ]);
        }

        if (! isset($this->model_info->actions['print']) && Gate::allows('access',$this->routes['print'])) {
            array_unshift($this->model_info->actions, [
                "type" => "print",
                "title" => "Imprimir",
                "icon" => "mi-print",
                "icon_class" => "btn-info btn-link btn-float font-size-sm font-weight-semibold",
                "route"=> '//'.request()->getHost().'/'.$this->routes['printurl']
            ]);
        }
    }

    public function setModelInfo()
    {
        $this->model_info->genders = [
            ['value' => 'Hombre'],
            ['value' => 'Mujer'],
            ['value' => 'Prefiero no decirlo'],
        ];
        $this->model_info->educations = [
            ['value' => 'Primario completo'],
            ['value' => 'Primario incompleto'],
            ['value' => 'Secundario completo'],
            ['value' => 'Secundario incompleto'],
            ['value' => 'Terciario'],
            ['value' => 'Universitario'],
        ];
        $this->model_info->marital_statuses = [
            ['value' => 'Casado/a'],
            ['value' => 'Soltero/a'],
            ['value' => 'Divorciado/a'],
            ['value' => 'Concubinato'],
            ['value' => 'Viudo/a'],
        ];
        $this->model_info->age_ranges = [
            ['value' => 'Menos de 18 años'],
            ['value' => '+18 años estudiando'],
            ['value' => '+18 años estudiando y trabajando'],
            ['value' => '+18 años trabajando'],
            ['value' => 'Ninguna de las anteriores'],
        ];
        $this->model_info->doctor_visits = [
            ['value' => 'Una vez por semana'],
            ['value' => 'Cada dos semanas'],
            ['value' => 'Una vez por mes'],
            ['value' => 'Nunca'],
        ];
    }

    public function edit($id)
    {
        Gate::authorize('access',$this->routes['edit']);

        $this->setModelInfo();
        $this->setAdminInfo();

        parent::initController();

        try {
            $form = $this->model::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route($this->routes['list'])
                ->with('error', 'No encontramos el registro a editar');
        }

        $personal_data = $form->personal_data;
        $family_unit = $form->family_unit;
        $housing = $form->housing;
        $health = $form->health;
        $contact = $form->contact;

        $data = array_merge(
            $personal_data,
            $family_unit,
            $housing,
            $health,
            $contact
        );
        $data['suggestions'] = $form->suggestions;

        $this->auditory->save('access', 'Accedió a editar los datos de '.$this->model_titles['singular'].' (ID: '.$id.')');

        return view($this->view_edit, compact('data'));
    }

    public function save(DataUpdateRequest $request)
    {
        if ($request->filled('id')) {
            try {
                $data = $this->model::findOrFail($request->id);
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return redirect()
                    ->route($this->routes['list'])
                    ->with('error', 'No encontramos el registro a guardar');
            }
        } else {
            $data = new DataUpdate();
            $data->user_id = $this->user->id;
        }

        $validatedData = $request->validated();
        $arrangedData = [
            'personal_data' => array_slice($validatedData, 0, 8),
            'family_unit' => array_slice($validatedData, 8, 7),
            'housing' => array_slice($validatedData, 15, 5),
            'health' => array_slice($validatedData, 20, 14),
            'contact' => array_slice($validatedData, 34, 9),
            'suggestions' => $validatedData['suggestions'],
        ];

        $this->processCommonFields($request, $data);

        $data->fill($arrangedData);

        return parent::store($data);
    }

    public function process(Request $request)
    {
        try {
            $data = $this->model::where('id', $request->id)
                ->whereNull('processed_by')
                ->whereNull('processed_at')
                ->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route($this->routes['list'])
                ->with('error', 'No encontramos el registro a procesar');
        }

        $data->processed_by = $this->user->id;
        $data->processed_at = now();

        return parent::store($data);
    }

    public function print($id)
    {
        try {
            $data = $this->model::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route($this->routes['list'])
                ->with('error', 'No encontramos el registro a imprimir');
        }

        $printed_by = $this->user->person->name;

        $pdf = PDF::loadView($this->view_print, compact("data", "printed_by"))->setPaper('A4', 'portrait');

        return $pdf->stream("actualizacion-de-datos-{$id}.pdf");
    }

    public function sheet()
    {
        return false;
    }
}
