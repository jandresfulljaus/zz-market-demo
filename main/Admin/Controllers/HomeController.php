<?php

namespace Main\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Main\Admin\Libraries\Control;
use Main\Auth\Models\User;
use Main\People\Models\Person;
use Modules\Auditory\Models\Auditory;
use Modules\News\Models\Post;
use Modules\Orders\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auditory $auditory)
    {
        $this->auditory = $auditory;

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });

        $admin_info = new \stdClass();
        $admin_info->title = '';
        view()->share('admin_info', $admin_info);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $news=false;
        $holidays=false;

        $invalidPasswords = [
            '3caa76e639da203a77cf3008b15e61a9c9f1bcd0', // lortnoc
            'a2b1684c49dde20d5c623e6535b99ad2eda1a4b6', // control
        ];
        $showChangePassword = (in_array($this->user->password, $invalidPasswords));
        $showCardsInfo = array("ordersBOR" =>  Order::getcountordersbystatuscurrentmonth('BOR') ,"ordersENV" =>  Order::getcountordersbystatuscurrentmonth('ENV'), "ordersAPRO" => Order::getcountordersbystatuscurrentmonth('APRO'), "orders" => Order::getcountordersbystatuscurrentmonth(), "totalTransac" => Order::gettotaltranscurrentmonth());
        $this->auditory->save('access', 'Ingreso al inicio', 'admin');

        return view('Admin.Views.home', compact( 'showChangePassword', 'showCardsInfo' ));
    }
    
    public function locale(Request $request)
    {
        $locale = $request->locale;
        app()->setLocale($locale);
        session()->put('locale', $locale);
        //return $this->index();
        return redirect()->back();
    }

    public function error404()
    {
        $this->auditory->save('404', 'Solicitó un contenido no existente', 'admin');

        return view('Admin.Views.404');
    }

    public function profile()
    {
        $this->auditory->save('access', 'Ingresó a ver su perfíl', 'admin');

        $this->model_info = new \stdClass();
        $this->model_info->person = Person::find($this->user->person_id);
        $data = $this->user;
        $data->password = null;
        view()->share('model_info', $this->model_info);
        return view('Admin.Views.profile', compact('data'));
    }

    public function saveprofile(Request $request)
    {
        if ($request->isNotFilled('id')) {
            $this->auditory->save('error', 'Guardar perfíl: No se indicó el perfíl para guardar', 'admin');

            return redirect()
                ->route('admin.profile.edit')
                ->with('error', 'No se indicó el perfíl para guardar el registro');
        }

        $data = User::find($request->id);

        // Asignación de datos que vienen del Form para almacenar en la tabla
        $data->email2 = $request->email2 ?? null;
        $data->phone = $request->phone ?? null;

        if ($request->filled('password')) {
            $this->auditory->save('update', 'Actualizó su contraseña', 'admin');

            // si está editando y actualiza la clave
            $data->password = Control::hash($request->password);
        }

        if ($data->save()) {
            $this->auditory->setDiffFromObject($data);
            $this->auditory->save('update', 'Actualizó su perfíl', 'admin', User::class);

            Control::log();

            return redirect()
                ->route('admin.profile.edit')
                ->with('success', 'Las modificaciones se guardaron exitosamente.');
        }

        $this->auditory->save('error', 'Guardar perfíl: No se pudo guardar el registro', 'admin');

        return redirect()
            ->route('admin.profile.edit')
            ->with('error', 'No pude guardar el registro');
    }

    public function activity()
    {
        $this->auditory->save('access', 'Ingresó a ver su listado de actividad', 'admin');

        $data = Auditory::where('user_id', $this->user->id)->orderBy('id', 'DESC')->paginate();

        return view('Admin.Views.activity', compact('data'));
    }

    public function sessions()
    {
        $this->auditory->save('access', 'Ingresó a ver su listado de actividad', 'admin');

        // temporariamente lo dejo vacío hasta pasar las sesiones a db
        $data = Auditory::where('user_id', 'esto no anda')->orderBy('id', 'DESC')->paginate();

        return view('Admin.Views.sessions', compact('data'));
    }

    public function updateroutes()
    {
        Artisan::call('route:clear');
        Artisan::call('cache:clear');

        $routeCollection = Route::getRoutes()->get();

        $this->auditory->save('updateroutes', 'Actualizó las rutas de la aplicación', 'admin');

        foreach ($routeCollection as $value) {
            $action = $value->getName();
            $name = $value->getActionName();

            if(! isset($action) || empty($action) || substr($action, 0, 8) === "ignition") {
                // Nada de momento
            } else {
                // ver si esa ruta ya existe
                $route = DB::table('auth_perms')
                        ->where('name','=',$action)
                        ->get()->first();

                if (empty($route)) {
                    DB::table('auth_perms')->insert([
                        'slug' => $name,
                        'description' => $name,
                        'name' => $action
                    ]);
                }
            }
        }

        return redirect()->back();
    }

    public function phpinfo()
    {
        phpinfo();
    }
    
    public function icons()
    {
        return view('Admin.Views.icon');
    }
}
