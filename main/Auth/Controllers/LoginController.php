<?php

namespace Main\Auth\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Main\Admin\Controllers\BaseController;
use Main\Admin\Libraries\Control;
use Main\Auth\Models\Organization;
use Main\Auth\Models\User;
use Modules\Auditory\Models\Auditory;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $validation_fields = [
        'username' => 'required',
        'password' => 'required'
    ];
    protected $message_fields = [];
    protected $names_fields = [
        'username' => 'DNI o Correo Electrónico',
        'password'=>'Clave de acceso'
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auditory $auditory)
    {
        parent::__construct($auditory);

        $this->middleware('guest')->except('logout');
    }

    public function showlogin()
    {   
        $this->auditory->save('access', 'Ingresó al login', 'login');

        $organization_id = Config::get('fulljauscms.organization.id');
        $organization = Organization::find($organization_id);

        $admin_info = new \stdClass();
        $admin_info->title = $organization->name;
        view()->share('admin_info', $admin_info);

        return view('auth::login');
    }

    public function login(Request $request)
    {
        // Valido si tengo los campos username y password
        $this->validateFields($request);

        //$organizationConfig = Config::get('fulljauscms');
        //$organization_id = $organizationConfig["organization_id"];

        $password = sha1($request->password);
        $username = $request->username;

        $user = User::with(['person'])
                ->get()
                ->where('password', '=', $password)
                ->where('email', '=', $username)
                ->first();

        if (empty($user)) {
            $this->auditory->save('error', 'Login: Los datos ingresados no son correctos', 'login');

            return redirect()->back()->with('error', 'Los datos ingresados no son correctos');
        }

        $remember = false;
        if ($request->filled('remember')){
            $remember = ($request->remember == '1');
        }

        Auth::login($user, $remember);

        $this->auditory->save('access', 'Inició sesión', 'login', Auth::class);

        return redirect()->intended();
    }

    public function logout(Request $request)
    {
        Auth::logoutCurrentDevice();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $this->auditory->save('access', 'Cerró sesión', 'login');

        return redirect()
            ->route('auth.login')
            ->with('success', __('messages.sessionClosedSuccessfullyIndex'));
    }

    public function loginas(Request $request)
    {
        echo 'acà vengo';
    }
}
