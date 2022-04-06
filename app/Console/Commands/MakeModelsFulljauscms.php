<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
//use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class MakeModelsFulljauscms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fulljauscms:models {module=System : Nombre del modulo donde crearemos el model} {model=SysUser : Nombre del modelo a crear} {modelplural=SysUsers : Nombre del modelo en plural para crear las tablas} {del? : Elimina el modelo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando Fulljaus cms para crear un nuevo modelo de datos. Crea el Controlador, las vistas de form y listado y el modelo + la migracion. El nombre del modelo se ingresa en Singular y se crea la tabla en plural';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $moduleName = ucwords(strtolower($this->argument('module')));
        $modelName = ucwords(strtolower($this->argument('model')));
        if($this->argument('modelplural') !== "SysUsers")
        {
            $modelPlural=ucwords(strtolower($this->argument('modelplural')));
        } else {
            $modelPlural=Str::plural($modelName);
        }

        $deleted = $this->argument('del');

        $pathModule = base_path("modules/".$moduleName.'/');

        if(!File::isDirectory($pathModule))
        {
            $this->error("No existe el Directorio: ". PHP_EOL .$pathModule);
            $this->info('Utilize:'. PHP_EOL .'@php artisan fulljauscms:modules NombreDelModulo');
            $this->info('para crear los directorios de los módulos');
            return 0;
        }

        $subFolders = ['Controllers','Database','Routes','Models','Views'];
        foreach($subFolders as $folder)
        {
            $pathFolder = $pathModule.$folder.'/';
            if(!File::isDirectory($pathFolder))
            {
                $this->error('No existe el Directorio: '. PHP_EOL .$pathFolder);
                $this->info('Utilize:'. PHP_EOL .'@php artisan fulljauscms:modules NombreDelModulo');
                $this->info('para crear los directorios de los módulos');
                return 0;
            }
        }
        $isCreate=($deleted=="del" || $deleted=="delete")?false:true;
        $action=$isCreate?'Creando':'Eliminando';

        $readSingular=$this->ask('Nombre en Español, en minúsculas y en Singular para este modelo?');
        $readPlural=$this->ask('Nombre en Español, en minúsculas y en Plural para este modelo?');
        //$readRoute=$this->ask('Nombre en Español, en minúsculas, sin caracteres extraños y en Singular para las rutas de este modelo?');
        if ($this->confirm('Vas a utilizar el campo position como ordinal? [yes|no]'))
        {
            $position='position';
        } else {
            $position='';
        }


        $tableName=strtolower($moduleName).'_'.strtolower($modelPlural);
        $classMigrationName='Create'.$moduleName.$modelPlural.'Table';
        $controllerName=$modelName.'Controller';
        $seederName=ucwords($modelPlural);
        $pathViews = $pathModule.'Views/'.strtolower($modelPlural);

        $filenameModel=$pathModule.'Models/'.$modelName.'.php';
        $filenameMigration=$pathModule.'Database/Migrations/'.date('Y_m_d').'_000000_create_'.$tableName.'_table.php';
        $filenameController=$pathModule.'Controllers/'.$controllerName.'.php';
        $filenameSheet=$pathModule.'Controllers/'.$modelName.'Sheet.php';
        $filenameSeeder=$pathModule.'Database/Seeders/'.$seederName.'Seeder.php';
        $filenameViewList=$pathViews.'/list.blade.php';
        $filenameViewEdit=$pathViews.'/edit.blade.php';
        $filenameInfo=$pathModule.strtolower($modelName).'.readme.txt';

        if(!File::isDirectory($pathViews.'/'))
        {
            File::makeDirectory($pathViews.'/',0777,true,true);
        }

        if(!$isCreate)
        {
            // Eliminar todos los archivos
        }

        /*****************************/
        /* Comienzo con el Modelo    */
        /*****************************/

        $this->info('*****************************************************************************');
        $this->info($action.' el modelo '.$modelName.' en el módulo '.$moduleName.' de Fulljaus cms');
        $this->info('*****************************************************************************');

        // Leo la plantilla de stub
        $contentModel=File::get($this->getStub().'fulljauscmsmodel.stub');

        // Reemplazo el contenido
        $contentModel=str_replace('{{ namespace }}','Modules\\'.$moduleName.'\\Models',$contentModel);
        $contentModel=str_replace('{{ class }}',$modelName,$contentModel);
        $contentModel=str_replace('{{ table }}',$tableName,$contentModel);

        $contentModel=str_replace('{{ position }}',$position,$contentModel);

        $positionField=($position=='')?$position:"'".$position."', ";
        $contentModel=str_replace('{{ positionlist }}',$positionField,$contentModel);
        $positionField=($position=='')?$position:"'Ord.', ";
        $contentModel=str_replace('{{ positionhead }}',$positionField,$contentModel);

        $positionField=($position=='')?$position:"'true', ";
        $contentModel=str_replace('{{ positionsort }}',$positionField,$contentModel);

        $positionField=($position=='')?"false":"true";
        $contentModel=str_replace('{{ positionsorting }}',$positionField,$contentModel);

        // Grabo la nueva clase en base a la plantilla
        File::put($filenameModel,$contentModel);


        /*****************************/
        /* Comienzo con la Migracion */
        /*****************************/
        $this->info('*****************************************************************************');
        $this->info($action.' la migracion del modelo '.$modelName);
        $this->info('*****************************************************************************');

        // Leo la plantilla de stub
        $contentMigration=File::get($this->getStub().'fulljauscmsmigration.stub');

        // Reemplazo el contenido
        $contentMigration=str_replace('{{ table }}',$tableName,$contentMigration);
        $contentMigration=str_replace('{{ class }}',$classMigrationName,$contentMigration);

        $positionField=($position=='')?$position:"\$"."table->bigInteger('position')->nullable()->default(0);";
        $contentMigration=str_replace('{{ position }}',$positionField,$contentMigration);

        // Grabo la nueva clase de Migracion en base a la plantilla
        File::put($filenameMigration,$contentMigration);


        /*****************************/
        /* Comienzo con la Semilla   */
        /*****************************/
        $this->info('*****************************************************************************');
        $this->info($action.' la semilla del modelo '.$modelName);
        $this->info('*****************************************************************************');
        // Leo la plantilla de stub
        $contentSeeder=File::get($this->getStub().'fulljauscmsseeder.stub');

        // Reemplazo el contenido
        $contentSeeder=str_replace('{{ class }}',$seederName,$contentSeeder);
        $contentSeeder=str_replace('{{ table }}',$tableName,$contentSeeder);

        // Grabo la nueva clase de Migracion en base a la plantilla
        File::put($filenameSeeder,$contentSeeder);

        /*****************************/
        /* Comienzo SheetController  */
        /*****************************/

        $this->info('*****************************************************************************');
        $this->info($action.' el Controlador de Exportación '.$modelName.'Sheet en el módulo '.$moduleName.' de Fulljaus cms');
        $this->info('*****************************************************************************');

        // Leo la plantilla de stub
        $contentSheet=File::get($this->getStub().'fulljauscmssheet.stub');
        $contentSheet=str_replace('{{ namespace }}','Modules\\'.$moduleName.'\\Controllers',$contentSheet);
        $contentSheet=str_replace('{{ model }}','Modules\\'.$moduleName.'\\Models\\'.$modelName,$contentSheet);
        $contentSheet=str_replace('{{ class }}',$modelName,$contentSheet);

        File::put($filenameSheet,$contentSheet);

        /*****************************/
        /* Comienzo con Controlador  */
        /*****************************/

        $this->info('*****************************************************************************');
        $this->info($action.' el Controlador '.$modelName.' en el módulo '.$moduleName.' de Fulljaus cms');
        $this->info('*****************************************************************************');

        // Leo la plantilla de stub
        $contentController=File::get($this->getStub().'fulljauscmscontroller.stub');

        // Reemplazo el contenido
        $contentController=str_replace('{{ namespace }}','Modules\\'.$moduleName.'\\Controllers',$contentController);
        $contentController=str_replace('{{ model }}','Modules\\'.$moduleName.'\\Models\\'.$modelName,$contentController);
        $contentController=str_replace('{{ modelname }}',$modelName,$contentController);
        $contentController=str_replace('{{ class }}',$modelName,$contentController);
        $contentController=str_replace('{{ table }}',$tableName,$contentController);
        $contentController=str_replace('{{ singular }}',ucwords(strtolower($readSingular)),$contentController);
        $contentController=str_replace('{{ singularminuscula }}',strtolower($readSingular),$contentController);
        $contentController=str_replace('{{ plural }}',ucwords(strtolower($readPlural)),$contentController);
        $contentController=str_replace('{{ viewmain }}',$moduleName.'.Views.'.strtolower($modelPlural).'.list',$contentController);
        $contentController=str_replace('{{ viewedit }}',$moduleName.'.Views.'.strtolower($modelPlural).'.edit',$contentController);
        $contentController=str_replace('{{ position }}',$position,$contentController);

        $positionField=($position=='')?$position:"'".$position."', ";
        $contentController=str_replace('{{ positionfield }}',$positionField,$contentController);
        $positionField=($position=='')?$position:"'Ord.', ";
        $contentController=str_replace('{{ positionhead }}',$positionField,$contentController);

        $routeroot=strtolower($moduleName).'.'.strtolower($modelPlural);

        $contentController=str_replace('{{ routelist }}',$routeroot.'.list',$contentController);
        $contentController=str_replace('{{ routeedit }}',$routeroot.'.edit',$contentController);
        $contentController=str_replace('{{ routedelete }}',$routeroot.'.delete',$contentController);
        $contentController=str_replace('{{ routecreate }}',$routeroot.'.create',$contentController);
        $contentController=str_replace('{{ routesort }}',$routeroot.'.sort',$contentController);
        $contentController=str_replace('{{ routesave }}',$routeroot.'.save',$contentController);
        $contentController=str_replace('{{ routegetdata }}',$routeroot.'.getdata',$contentController);
        $contentController=str_replace('{{ routesheet }}',$routeroot.'.sheet',$contentController);

        // Grabo la nueva clase en base a la plantilla
        File::put($filenameController,$contentController);


        /*****************************/
        /* Comienzo con las vistas   */
        /*****************************/

        $this->info('*****************************************************************************');
        $this->info($action.' la vista de '.$modelName.' en el módulo '.$moduleName.' de Fulljaus cms');
        $this->info('*****************************************************************************');

        // Leo la plantilla de stub
        $contentView=File::get($this->getStub().'fulljauscmslist.blade.stub');
        File::put($filenameViewList,$contentView);

        $contentView=File::get($this->getStub().'fulljauscmsedit.blade.stub');
        File::put($filenameViewEdit,$contentView);

        /*****************************/
        /* Comienzo a informar       */
        /*****************************/
        $instructions='';
        $instructions.=' '.PHP_EOL;
        $instructions.='Acciones de Base de datos'.PHP_EOL;
        $instructions.='========================='.PHP_EOL;
        $instructions.='- Modifique la estructura de la base de datos en el archivo de migración:'.PHP_EOL;
        $instructions.=$filenameMigration.PHP_EOL.PHP_EOL;
        $instructions.='- Rellene la semilla:'.PHP_EOL;
        $instructions.=$filenameSeeder.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL;

        $instructions.='- Ya puedes probar si la migración y la semilla funcionan:'.PHP_EOL;
        $instructions.='Ejecute:'.PHP_EOL.' composer dump-autoload'.PHP_EOL;
        $instructions.='luego: '.PHP_EOL.' @php artisan migrate:fresh --seed '.PHP_EOL.'para obtener una base de datos inicial.'.PHP_EOL.PHP_EOL.PHP_EOL;

        $instructions.='Acciones en el Módulo'.PHP_EOL;
        $instructions.='====================='.PHP_EOL;
        $instructions.='- Edite el array $fillable. en el archivo del modelo de datos:'.PHP_EOL;
        $instructions.='    * Modifique la consulta getdata e incluya sus propias consultas relacionadas:'.PHP_EOL;
        $instructions.=$filenameModel.PHP_EOL.PHP_EOL;
        $instructions.='- Edite el Controlador del modelo de datos:'.PHP_EOL;
        $instructions.=$filenameController.PHP_EOL.PHP_EOL;
        $instructions.='- Complete el formulario de edición/inserción de registros:'.PHP_EOL;
        $instructions.=$filenameViewEdit.PHP_EOL.PHP_EOL;
        $instructions.='- Puede mejorar el listado de registros o agregar una nueva vista principal:'.PHP_EOL;
        $instructions.=$filenameViewList.PHP_EOL.PHP_EOL.PHP_EOL;

        $instructions.='- Agrega al sidebar menu la opción para administrar este modelo'.PHP_EOL;
        $instructions.='<li><a href="{{ route(\''.$routeroot.'.list\')}}"><i class="material-icons">assignment_ind</i><p>'.ucwords(strtolower($readPlural)).'</p></a></li>'.PHP_EOL.PHP_EOL;

        $instructions.='- Edite el archivo routes.php del módulo y agregue:'.PHP_EOL;
        $instructions.='// '.$moduleName.' - '.$modelName.PHP_EOL;
        $instructions.="Route::get('/".strtolower($readPlural)."', '".$modelName."Controller@index')->name('".$routeroot.".list');".PHP_EOL;
        $instructions.="Route::get('/nuevo/".strtolower($readSingular)."', '".$modelName."Controller@create')->name('".$routeroot.".create');".PHP_EOL;
        $instructions.="Route::post('/ordenar/".strtolower($readPlural)."', '".$modelName."Controller@sorting')->name('".$routeroot.".sort');".PHP_EOL;
        $instructions.="Route::get('/editar/".strtolower($readSingular)."/{id}', '".$modelName."Controller@edit')->name('".$routeroot.".edit');".PHP_EOL;
        $instructions.="Route::post('/eliminar/".strtolower($readSingular)."', '".$modelName."Controller@delete')->name('".$routeroot.".delete');".PHP_EOL;
        $instructions.="Route::post('/guardar/".strtolower($readSingular)."', '".$modelName."Controller@save')->name('".$routeroot.".save');".PHP_EOL;
        $instructions.="Route::post('/obtener/".strtolower($readPlural)."', '".$modelName."Controller@getdata')->name('".$routeroot.".getdata');".PHP_EOL;
        $instructions.="Route::get('/exportar/".strtolower($readPlural)."', '".$modelName."Controller@sheet')->name('".$routeroot.".sheet');".PHP_EOL;

        $instructions.=' '.PHP_EOL.PHP_EOL;


        $this->info($instructions);

        $this->info("Estas instrucciones puedes encontrarlas en:");
        $this->info($filenameInfo);

        File::put($filenameInfo,$instructions);

        return 0;
    }

    /**
    * Get the stub file for the generator.
    *
    * @return string
    */
    protected function getStub()
    {
        return  base_path('stubs/');
    }
}
