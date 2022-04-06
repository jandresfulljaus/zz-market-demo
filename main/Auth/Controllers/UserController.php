<?php

namespace Main\Auth\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Main\Admin\Controllers\BaseController;
use Main\Admin\Libraries\Control;
use Main\People\Models\Person;
use Main\Auth\Models\Organization;
use Main\Auth\Models\Role;
use Main\Auth\Models\User;

class UserController extends BaseController
{
    protected $model = User::class;
    protected $model_titles = [
        'es' => ['singular' => 'Usuario', 'plural' => 'Usuarios'],
        'en' => ['singular' => 'User', 'plural' => 'Users'],
        'pt' => ['singular' => 'Usuário', 'plural' => 'Usuários']
    ];

    protected $validation_fields = [];
    protected $message_fields = [];
    protected $names_fields = ['person_id' => 'Persona'];

    protected $routes = [
        'list' => 'auth.users.list',
        'create' => 'auth.users.create',
        'edit' => 'auth.users.edit',
        'editurl' => 'usuarios/editar/',
        'save' => 'auth.users.save',
        'delete' => 'auth.users.delete',
        'getdata' => 'auth.users.getdata',
        'sort' => 'auth.users.sort',
        'sheet' => 'auth.users.sheet'
    ];

    protected $view_main = 'auth::users.list';
    protected $view_edit = 'auth::users.edit';

    protected $paginate = 20;

    protected $showExportBtn = false;

    public function setAdminInfo()
    {
        $this->admin_info->openSidebars = [
            'menuAuthUser',
        ];
    }

    public function index()
    {
        $this->auditory->save('access', 'Accedió al listado de usuarios', 'user');

        return parent::index();
    }

    public function create()
    {
        $this->auditory->save('access', 'Accedió a crear un usuario', 'user');

        Gate::authorize('access',$this->routes['create']);

        $this->model_info->persons = [];
        $this->model_info->roles = Role::all(['id','name'])->sortBy('name');
        $this->model_info->user_role = [];
        $this->model_info->organizations = Organization::all(['id','name'])->sortBy('name');

        return parent::create();
    }

    public function edit($id)
    {
        Gate::authorize('access',$this->routes['edit']);

        $user = User::find($id);
        if (! empty($user) AND ! empty($user->person_id)) {
            $persons = Person::where('id','=',$user->person_id)->get()->sortBy('name');
        } else {
            $persons = [];
        }
        $this->model_info->persons = $persons;
        $this->model_info->roles = Role::all(['id','name'])->sortBy('name');
        $this->model_info->user_role = User::with('role')->find($id)->role->pluck(['id'])->all();
        $this->model_info->organizations = Organization::all(['id','name'])->sortBy('name');
        // var_dump( $this->model_info->organizations);
        // die;
        $nombre = @$persons[0]->name.' (UID: '.$user->id.')';

        $this->auditory->save('access', 'Accedió a editar al usuario '.$nombre, 'user');

        return parent::edit($id);
    }

    public function save(Request $request)
    {
        $this->validateFields($request);

        if (isset($request->id)) {
            $data = $this->validateData($request);
        } else {
            $data = new User();
        }

        $this->processCommonFields($request, $data);

        if (! empty($request->person_id)) {
            $data->person_id = $request->person_id;
        }
        $data->organization_id = $request-> organization_id ?? null;
        $data->email = $request->email ?? null;
        $data->email2 = $request->email2 ?? null;
        $data->phone = $request->phone ?? null;

        if (isset($request->id)) {
            if (! empty($request->password)) {
                $data->password = sha1($request->password);
            }
        } else {
            $data->password = sha1('control');
        }

        $data->status = ($request->status == 'on') ? 1 : 0;

        $person = Person::find($data->person_id);
        $nombre = $person->name.' (UID: '.$data->id.')';

        if ($data->save()) {
            Control::log();

            $data->role()->sync($request->get('role'));

            $this->auditory->setDiffFromObject($data);
            $this->auditory->save('save', 'Modificó los datos del usuario '.$nombre, 'user');

            return redirect()
                ->route($this->routes['list'])
                ->with('success', 'Las modificaciones se guardaron exitosamente.');
        }

        $this->auditory->save('error', 'Falló al modificar los datos del usuario '.$nombre, 'user');

        return redirect()
            ->route($this->routes['list'])
            ->with('error', 'No pude guardar el registro');
    }

    public function sheet()
    {
        return false;
    }

    public function getFromDepartment(Request $request)
    {
        $users = User::with('person:id,name')
            ->whereHas("departments", function ($query) use ($request) {
                $query->where('department_id', $request->id)
                    ->whereNull('organigram_assignments.deleted_at');
            })
            ->where('id', '!=', $this->user->id)
            ->get(['id', 'person_id']);
        $users->transform(function ($user) {
            $transformed['id'] = $user->id;
            $transformed['text'] = $user->name;

            return $transformed;
        });

        return response()->json($users);
    }
}
