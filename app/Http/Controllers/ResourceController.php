<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Modules\Auditory\Models\Auditory;

class ResourceController extends Controller
{
    /**
     * The user making the current request.
     *
     * @var \Main\Auth\Models\User
     */
    public $user;

    /**
     * The resource model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The resource routes.
     *
     * @var array
     */
    protected $routes;

    /**
     * The resource views.
     *
     * @var array
     */
    protected $views;

    /**
     * The resource buttons.
     *
     * @var array
     */
    protected $buttons;

    /**
     * Data required for the correct rendering of forms.
     *
     * @var \stdClass
     */
    protected $formData;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function __construct(Auditory $auditory)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });

        $this->auditory = $auditory;

        if (! isset($this->formData)) {
            $this->formData = new \stdClass();
        }
    }

    public function setTemplateData()
    {
        $templateData = new Class {};

        if ($this->buttons['create'] && Gate::allows('access',$this->routes['create'])) {
            $templateData->buttons['create'] = [
                "title" => __('messages.NewProductsIcon'),
                "url" => route($this->routes['create']),
                "icon" => "mi-add-circle",
                "color" => "text-green-700",
            ];
        }

        $templateData->routes = $this->routes;

        view()->share("templateData", $templateData);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('access', $this->routes['index']);

        $data = $this->model::getListData();

        $this->setTemplateData();

        $this->auditory->save('access', 'Accedió al listado de registros');

        return view($this->views['index'], compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('access', $this->routes['create']);

        if (method_exists($this, 'createFormData') && is_callable([$this, 'createFormData'])) {
            $this->createFormData();
            view()->share('formData', $this->formData);
        }

        $this->setTemplateData();

        $this->auditory->save('access', 'Accedió a crear un registro');

        return view($this->views['create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $validatedData
     * @return \Illuminate\Http\Response
     */
    public function storeResource($validatedData)
    {
        Gate::authorize('access', $this->routes['store']);

        DB::beginTransaction();
        try {
            $data = $this->model::create($validatedData);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->auditory->save('error', 'Intentó crear un registro');

            return redirect()
                    ->route($this->routes['index'])
                    ->with('error', 'No pudimos crear el registro');
        }
        DB::commit();

        $this->auditory->setDiffFromObject($data);
        $this->auditory->save('save', "Creó un registro (ID: {$data->id})");

        return redirect()
                ->route($this->routes['index'])
                ->with('success', 'Registro creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('access', $this->routes['edit']);

        $data = $this->verifyModelExistance($id);

        if (method_exists($this, 'editFormData') && is_callable([$this, 'editFormData'])) {
            $this->editFormData($id);
            view()->share('formData', $this->formData);
        }

        $this->setTemplateData();

        $this->auditory->save('access', "Accedió a editar un registro (ID: {$id})");

        return view($this->views['edit'], compact("data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  array  $validatedData
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateResource($validatedData, $id)
    {
        Gate::authorize('access', $this->routes['update']);

        $data = $this->verifyModelExistance($id);

        DB::beginTransaction();
        try {
            $data->fill($validatedData);
            $data->save();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->auditory->save('error', "Intentó modificar un registro (ID: {$data->id})");

            return redirect()
                ->route($this->routes['edit'], $id)
                ->with('error', 'No pudimos modificar el registro');
        }
        DB::commit();

        $this->auditory->setDiffFromObject($data);
        $this->auditory->save('save', "Modificó los datos de un registro (ID: {$data->id})");

        return redirect()
                ->route($this->routes['index'])
                ->with('success', 'Registro modificado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Gate::authorize('access', $this->routes['delete']);

        $data = $this->verifyModelExistance($id);

        DB::beginTransaction();
        try {
            $data->delete();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->auditory->save('error', "Intentó eliminar un registro (ID: {$id})");

            return redirect()
                    ->route($this->routes['index'])
                    ->with('error', 'No pudimos eliminar el registro');
        }
        DB::commit();

        $this->auditory->save('delete', "Eliminó un registro (ID: {$data->id})");

        return redirect()
                ->route($this->routes['index'])
                ->with('warning', 'Registro eliminado exitosamente');
    }

    public function verifyModelExistance($id)
    {
        try {
            $data = $this->model::findOrFail($id);
        } catch (\Throwable $th) {
            $this->auditory->save('error', "Intentó utilizar un registro eliminado o no existente (ID: {$id})");

            return redirect()
                    ->route($this->routes['index'])
                    ->with('error', 'No encontramos el registro');
        }

        return $data;
    }
}
