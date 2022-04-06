<?php

namespace Main\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use Modules\Auditory\Models\Auditory;
use Main\Admin\Libraries\Control;

// para obtener el usuario en los controladores
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public $user;                   // usuario logueado para usar en controladores

    protected $model;               // Modelo de datos asociado a este Controlador
    protected $model_titles;       // Array con los nombres en español. Ej: $model_titles = ['singular'=>'País', 'plural'=>'Paises']

    // Validación del lado del servidor
    protected $validation_fields;
    protected $message_fields;
    protected $names_fields;

    protected $routes;              // Array con las rutas para list,create,edit,sort
    protected $view_main;           // Nombre de la vista principal. Normalmente la lista.
    protected $view_edit;           // Nombre de la vista de edición/inserción de registros.
    protected $paginate;            // Cantidad de registros para Paginado para los listados

    protected $model_info;             // bigInfo le pasa todos los parametros a las vistas.
    protected $admin_info;

    public function __construct(Auditory $auditory)
    {
        $this->auditory = $auditory;

        // para tener al usuario en el controlador
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
   
            return $next($request);
        });


        if(!isset($this->admin_info))
        {
            $this->admin_info = new \stdClass();
        }
        if(!isset($this->model_info))
        {
            $this->model_info = new \stdClass();
        }
    }

    public function initController()
    {
        $this->admin_info->title= __('messages.managamentUsuarios').$this->model_titles[app()->getLocale()]['plural'];
        if(!isset($this->admin_info->buttons['sheet']) && Gate::allows('access',$this->routes['sheet']) && (!isset($this->showExportBtn) OR $this->showExportBtn != false))
        {
            $this->admin_info->buttons['sheet'] = ["title" => __('messages.ExportAuditIcon'), "icon" =>"icon-stack-down", "icon_class" =>"text-pink-700", "route"=> route($this->routes['sheet']) ];
        }
        if(!isset($this->admin_info->buttons['create']) && Gate::allows('access',$this->routes['create']) && (!isset($this->showCreateBtn) OR $this->showCreateBtn != false))
        {
            $this->admin_info->buttons['create'] = ["title" => __('messages.NewProductsIcon'), "icon" =>"mi-add-circle","icon_class" =>"text-green-700", "route"=> route($this->routes['create']) ];
        }

        view()->share('admin_info', $this->admin_info);

        $host = request()->getHttpHost();
        if(!isset($this->model_info->actions['edit']) && Gate::allows('access',$this->routes['edit']))
        {
            $this->model_info->actions['edit'] = ["type" => "link", "title" => "Editar", "icon" =>"mi-mode-edit","icon_class" =>"btn-success btn-link btn-float font-size-sm font-weight-semibold", "route"=> '//'.$host.'/'.$this->routes['editurl']];
        }

        if(!isset($this->model_info->actions['delete']) && Gate::allows('access',$this->routes['delete']))
        {
            $this->model_info->actions['delete'] = ["type" => "button", "title" => "Eliminar", "icon" =>"mi-delete","icon_class" =>"btn-danger btn-link btn-float font-size-sm font-weight-semibold", "route"=> route($this->routes['delete']), "event" => 'onsubmit="return confirm(\'Esta seguro que desea eliminar este registro?\');"'  ];
        }
        $this->model_info->auto = 'nombre';
        $this->model_info->model_titles = $this->model_titles;
        $this->model_info->heads_fields = $this->model::$heads_fields;
        $this->model_info->list_fields = $this->model::$list_fields;
        $this->model_info->ordenable_fields = $this->model::$ordenable_fields;
        $this->model_info->ordinal_field = $this->model::$ordinal_field;
        $this->model_info->ordinal_order = $this->model::$ordinal_order;
        $this->model_info->sort = $this->model::$sort;
        $this->model_info->routes = $this->routes;

        view()->share('model_info', $this->model_info);
    }

    

    public function index()
    {
        // si hay un home me voy ahí
        if (method_exists($this, 'home')) {
            $this->auditory->save('access', 'Accedió al inicio de '.$this->model_titles[app()->getLocale()]['plural']);
            return $this->home();
        }

        // sino al listado
        return $this->list();
    }

    public function list()
    {
        Gate::authorize('access',$this->routes['list']);

        $this->auditory->save('access', 'Accedió al listado de '.$this->model_titles[app()->getLocale()]['plural']);

        $this->setAdminInfo();
        $this->initController();

        //Control::log();
        $data = true;

        return view($this->view_main, compact('data'));
    }

    public function getdata(Request $request=null)
    {
        Gate::authorize('access',$this->routes['getdata']);

        $this->initController();

        $this->model::$ordinal_order = $_POST["organization_id"] = $this->user->organization->id;
        if(isset($_POST["ordinal_field"]) && $_POST["ordinal_field"]!="") {
            $this->model::$ordinal_field=$_POST["ordinal_field"];
            $this->model::$ordinal_order=$_POST["ordinal_order"];
        }

        $data = $this->model::getdata($request)->paginate($this->paginate);

        // SUCCESS
        $response = [
            'status' => 'true',
            'message' => 'Los datos se han enviado de forma satisfactoria',
            'data' => $data
        ];
        return response()->json($response, 200);
    }

    public function setModelInfo()
    {
        // $this->model_info->persons=Person::all(['id','name'])->sortBy('name');
    }

    public function setAdminInfo()
    {
        // $this->admin_info->persons=Person::all(['id','name'])->sortBy('name');
    }

    public function create()
    {
        Gate::authorize('access',$this->routes['create']);

        $this->auditory->save('access', 'Accedió a crear '.$this->model_titles[app()->getLocale()]['plural']);

        $this->setModelInfo();
        $this->setAdminInfo();

        $this->initController();
        Control::log();
        return view($this->view_edit);
    }

    public function processCommonFields(Request $request, &$data){
        // agregar el organization_id
        if (isset($data->organization_id)) {
            if (empty($data->organization_id)) {
                $data->organization_id = $this->user->organization_id;
            }
        }

        // ver el estado activo
        if (isset($data->status)) {
            $data->status = ($request->status == 'on')?1:0;
        }
    }

    public function store(&$data, $internal = false)
    {
        $redirect = $this->routes['list'];
        $method = 'route';

        if (isset($_POST['redirect'])) {
            $redirect = trim($_POST['redirect']);
            $method = 'to';
        }

        if ($data->save()) {
            Control::log();

            $this->auditory->setDiffFromObject($data);
            $this->auditory->save('save', 'Modificó los datos de '.$this->model_titles[app()->getLocale()]['singular'].' (ID: '.$data->id.')');

            if ($internal) { return true; }

            // SUCCESS
            return redirect()->$method($redirect)
            ->with('success', 'Las modificaciones se guardaron exitosamente.');
        }

        $this->auditory->save('error', 'Falló al modificar los datos de '.$this->model_titles[app()->getLocale()]['singular'].' (ID: '.$data->id.')');

        if ($internal) { return false; }

        return redirect()
        ->$method($redirect)
        ->with('error', 'No pude guardar el registro');

    }

    public function edit($id)
    {
        Gate::authorize('access',$this->routes['edit']);
        
        $this->setModelInfo();
        $this->setAdminInfo();

        $this->initController();

        // Verifico que el ID del registro sea mayor que 1
        if ((int) $id < 1)
        {
            $this->auditory->save('error', 'Falló al editar los datos de '.$this->model_titles[app()->getLocale()]['singular'].' (ID: no existente)');

            Control::log("Error: ". $this->routes['edit'],'El item ID no existe y por tanto no se puede editar');
            return redirect()
                ->route($this->routes['list'])
                ->with('error', 'El item ID no existe y por tanto no se puede editar');
        }

        if(isset($this->sql_edit) && !empty($this->sql_edit))
        {
            $query = str_replace('{{ id }}',$id,$this->sql_edit);
            $result = (array) DB::select($query);
            if(isset($result[0]))
            {
                $data = (array) $result[0];
            }
        } elseif(isset($this->model_info->data)) {
            $data = $this->model_info->data;
        } else {
            //$data = $this->model::select('*')->where('id',$id)->first()->toArray();
            $data = $this->model::find($id)->toArray();
        }

        // Si No lo encuentra, entonces vuelvo al listado
        if (!$data)
        {
            $this->auditory->save('error', 'Falló a editar los datos de '.$this->model_titles[app()->getLocale()]['singular'].' (ID: '.$id.')');

            Control::log("Error: ". $this->routes['edit'],'No encontré el registro con el ID:'.$id.' y por tanto no se puede editar');
            return redirect()
            ->route($this->routes['list'])
            ->with('error', 'No encontré el registro con el ID:'.$id.' y por tanto no se puede editar');
        }

        Control::log();

        $this->auditory->save('access', 'Accedió a editar los datos de '.$this->model_titles[app()->getLocale()]['singular'].' (ID: '.$id.')');

        return view($this->view_edit, compact('data'));

        //return $this->index();
    }

    public function delete(Request $request)
    {
        Gate::authorize('access',$this->routes['delete']);
        $this->initController();
        $data = $this->validateData($request,false);
        $organizationId = $this->user->organization_id;
        // dump($this->model_titles[app()->getLocale()]['singular']);die;
        // dd($request);

        if ($request->id != $organizationId) {

            // Elimino el registro y cargo el log
            if ($data->delete())
            {
                Control::log();

            $this->auditory->save('delete', 'Eliminó un registro de '.$this->model_titles[app()->getLocale()]['singular'].' (ID: '.$data->id.')');

                // SUCCESS
                return redirect()
                    ->route($this->routes['list'])
                    ->with('warning', 'Has eliminado el registro.');
            }

            $this->auditory->save('error', 'Falló al eliminar un registro de '.$this->model_titles[app()->getLocale()]['singular'].' (ID: '.$data->id.')');

            Control::log("Error: ". $this->routes['delete'],'El item ID no existe y por tanto no se puede eliminar');

            // Si no lo puedo eliminar vuelvo al listado
            return redirect()
                ->route($this->routes['list'])
                ->with('error', 'El item ID no existe y por tanto no se puede eliminar');

        } else {

            return redirect()
                ->route($this->routes['list'])
                ->with('error', 'No puedes eliminar tu registro de '.$this->model_titles[app()->getLocale()]['singular'].'.');
        }
    }

    public function sorting(Request $request)
    {
        // AJAX OR API VALIDATOR
        $validation_rules = [
            'rows' => 'required'
        ];

        $validator = Validator::make($request->all(), $validation_rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => 'Validation Error',
                'data' => $validator->errors()->messages()
            ]);
        }

        $rows = $request->input('rows');

        // convert to array
        $data = explode('&', $rows);

        $ordinal = 1;
        foreach ($data as $item) {
            // split the data
            $tmp = explode('[]=', $item);

            $object = $this->model::find($tmp[1]);
            $object->position = $ordinal;
            $object->save();

            $ordinal++;
        }

        // SUCCESS
        $response = [
            'status' => 'true',
            'message' => 'Datos reorganizados',
            'refresh' => 'list',
            'data' => $data
        ];
        return response()->json($response, 200);

    }

    public function validateData(Request $request)
    {
        // Obtengo el ID del registro a guardar
        $id = $request->id;

        // Verifico que el ID del registro sea mayor que 1
        if ((int) $id < 1)
        {
            return redirect()
                ->route($this->routes['list'])
                ->with('error', 'El ID no existe y por tanto no se puede guardar');
        }

        // Busco el registro a editar
        $data = $this->model::find($id);

        // Si No lo encuentra, entonces vuelvo al listado
        if (!$data)
        {
            return redirect()
                ->route($this->routes['list'])
                ->with('error', 'El ID no existe y por tanto no se puede guardar');
        }

        /*if($validate_fields)
        {
            $this->validateFields($request);
        }*/

        return $data;
    }

    public function validateFields(Request $request)
    {
        $this->validate($request, $this->validation_fields, $this->message_fields, $this->names_fields);
    }

    public function uploadFile($file, $maxSize, $allowedFormats)
    {
        $nombreOriginal = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        // Le agrego marca de tiempo
        $nombre = strtolower(basename($nombreOriginal, '.'.$extension)."-".date("Ymd_His").".".$extension);
        $nombre = str_replace(' ','_',$nombre);
        $nombre = str_replace('-','_',$nombre);
        $data['texto'] = $nombre;
        $data['error'] = false;

        // Validaciones del lado del servidor
        // Tamaño
        if(($file->getSize()/1024) > $maxSize)
        {
            $data['error']      = true;
            $data['texto']    = 'El tamaño del archivo excede el máximo permitido';

            return $data;
        }

        // Extensión
        if(strpos(strtolower($allowedFormats), strtolower($file->getClientOriginalExtension())) === false)
        {
            $data['error']      = true;
            $data['texto']    = 'La extensión del archivo no está permitida';

            return $data;
        }

        // Subo al storage
        $file->storeAs('public/news/post',$nombre);

        return $data;
    }

}
