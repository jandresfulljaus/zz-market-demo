<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/';

    public $fulljauscmsEnvironment;

    public $config = [
        // aplicacion a correr (fulljauscms | web)
        "app" => null,

        // ruta de donde cargar el config de la organización
        "route" => null,

        // url segmentada
        "prefix" => null,
        "subdomain" => null,
        "domain" => null,
        "extension" => null,

        // url completa
        "hostmain" => null,
        "hostweb" => null,

        // entorno
        "environment" => null,

        // organización a cargar
        "organization" => null,
        "organization_id" => null,
        "organization_name" => null,

        "url_web" => null,
        "url_fulljauscms" => null,
    ];


    // aplicaciones mapeadas por subdominio
    private $availableSubdomains = [
        'www' => 'web',
        'admin' => 'fulljauscms'
    ];

    // extenciones de dominio habilitadas y su entorno
    private $availableExtensions = [
        // dominios locales
        '.fj' => 'fj',
        '.jla' => 'jla',
        '.local' => 'local',

        // dominios testing
        '.xyz' => 'testing',
        '.com' => 'com',

    ];

    public function boot()
    {
        $this->configureApi();
        $this->parseDomain();
        $this->setApplication();
        $this->setOrganization();
        $this->setConfigRoute();

        $this->setPublicsUrls();

        $this->loadConfig();
        //dd($this->config);

        if (isset($_GET['debug_config'])) {
            showvar($this->config);
            die;
        }
    }

    public function parseDomain()
    {
        $prefix = request()->getScheme();
        $this->config['prefix'] = $prefix.'://';

        //$host = request()->getHttpHost();
        $host = request()->getHost();

        Config::set('app.url',$prefix.$host);

        $this->config['environment'] = 'online';

        // sacar las extensiones válidas
        foreach ($this->availableExtensions as $extension => $environment) {
            if (strpos($host, $extension) !== false) {
                $this->config['extension'] = $extension;
                $this->config['environment'] = $environment;
                break;
            }
        }

        // sacar la extensión para trabajar el dominio
        $host = str_replace($extension, '', $host);


        $this->config['hostmain'] = $host.$extension;

        $exp_host = explode('.', $host);
        

        // si viene la petición sin subdominio, asumo www
        if (count($exp_host) == 1) {
            $new = ['www'];

            foreach($exp_host as $key => $value){
                $new[] = $value;
            }

            $exp_host = $new;
        }

        // subdominio
        $this->config['subdomain'] = $exp_host[0];

        // dominio
        unset($exp_host[0]);
        $host = implode('.', $exp_host);
        

        $this->config['domain'] = $host;
    }

    public function setApplication()
    {
        // por si ya se seteó en el custom
        if (!empty($this->config['app'])) { return; }

        if (isset($this->availableSubdomains[$this->config['subdomain']])) {
            $this->config['app'] = $this->availableSubdomains[$this->config['subdomain']];
        }else{
            $this->config['app'] = $this->config['subdomain'];
        }
    }

    public function setOrganization()
    {
        // por si ya se seteó en el custom
        if (!empty($this->config['organization_name'])) { return; }

        $this->config['organization_name'] = ($this->config['domain']=='fulljaus') ? 'market':$this->config['domain'];
    }

    public function setConfigRoute()
    {
        // por si ya se seteó en el custom
        if (!empty($this->config['route'])) { return; }

        switch ($this->config['app']) {
            case 'fulljauscms':
                $route = "routes/fulljauscms.php";
                break;

            case 'web':
                $route = "organizations/".$this->config['organization_name']."/web/web.php";
                break;
   
            default:
                $route = "organizations/".$this->config['organization_name']."/".$this->config['app']."/".$this->config['app'].".php";
                break;
        }

        $this->config['route'] = $route;
    }

    public function setPublicsUrls()
    {
        if ($this->config['app'] == 'fulljauscms') {
            $fulljauscms = $this->config['prefix'].$this->config['hostmain'];

            $web = str_replace($this->config['subdomain'], 'img', $this->config['subdomain']);
            $web = $this->config['prefix'].$web.'.'.$this->config['domain'].$this->config['extension'];
        }

        if ($this->config['app'] == 'web') {
            $web = $this->config['prefix'].$this->config['hostmain'];

            $fulljauscms = str_replace($this->config['subdomain'], 'fulljauscms', $this->config['subdomain']);
            $fulljauscms = $this->config['prefix'].$fulljauscms.'.'.$this->config['domain'].$this->config['extension'];
        }

        
        if (!empty($web) AND !empty($fulljauscms)) {
            if($this->config['domain'] == 'market'){
                $this->config['url_web'] = $web.':8000';
            }else{
                $this->config['url_web'] = $web;
            }
            $this->config['url_fulljauscms'] = $fulljauscms;
        }else{
            if (isset($_GET['dario'])) {
                dd($this->config);
            }
        }

    }

    public function loadConfig()
    {
        $cfg = require base_path("organizations/".$this->config['organization_name']."/config.php");
        $this->config['organization_id'] = $cfg["organization"]['id'];
        $this->config = $cfg + $this->config; // para sumar los datos de configuración

        Config::set("fulljauscms", $this->config);

        // por si ya se seteó en el custom
        if (empty($this->config['route'])) { return; }

        $this->setDatabase();
        $this->setStorage();
        $this->setAssets();
        $this->setRoutes();
    }

    private function setDatabase()
    {
        // si es local, ver si hay configuración para cada desarrollador
        if ($this->config['environment'] != 'online' AND isset($this->config["dbconnection"]['mysql_'.$this->config['extension']])) {
            $dbconnection = 'mysql_'.$this->config['extension'];
        }else{
            $dbconnection = 'mysql_'.$this->config['environment'];
        }

        Config::set('database.connections.mysql', @$this->config["dbconnection"][$dbconnection]);
        Config::set('database.default', 'mysql');
    }

    private function setStorage()
    {
        $org = $this->config['organization_name'];
        app()->useStoragePath(base_path('organizations/'.$org.'/storage/public'));

        Config::set('filesystems.disks.local.root',base_path('organizations/'.$org.'/storage/public'));
        Config::set('filesystems.disks.private.root',base_path('organizations/'.$org.'/storage/private'));
        Config::set('filesystems.disks.public.root',base_path('organizations/'.$org.'/storage/public'));

        // las urls las guardo sin dominio, para que anden en todos lados
        Config::set('filesystems.disks.private.url','/'.$org.'/storage/private');
        Config::set('filesystems.disks.public.url','/'.$org.'/storage/public');
    }

    private function setAssets()
    {
        if($this->config['app'] == 'fulljauscms')
        {
            $ruta_assets = '/Admin/Assets';
        } else {
            if($this->config['app']=='radio')
            {
                $ruta_assets = '/'.$this->config['organization_name'].'/web/Assets';
            } else {
                $ruta_assets = '/'.$this->config['organization_name'].'/'.$this->config['app'].'/Assets';
            }
        }

        Config::set('app.asset_url', $ruta_assets);
    }

    // no tengo muy claro que hace, copio del anterior
    private function setRoutes()
    {
        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            if(strpos(php_sapi_name(), 'cli') !== false)
            {
                Route::middleware('fulljauscms')
                ->namespace($this->namespace)
                ->group(base_path('routes/fulljauscms.php'));
            } else {
                $app = ($this->config['app'] == 'fulljauscms')?'fulljauscms':'web';
                Route::middleware($app)->namespace($this->namespace)
                ->group(base_path($this->config["route"]));
            }

        });
    }

    public function configureApi()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }

}
