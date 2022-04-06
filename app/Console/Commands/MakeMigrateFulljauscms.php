<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Artisan;

class MakeMigrateFulljauscms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fulljauscms:migrate {name? : Nombre del dominio donde se encuentra el archivo config.php} {subdomain? : Nombre del subdominio para tomar la config de la db}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando Fulljaus cms para hacer una migración en una organización de acuerdo a su nombre de dominio';

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
        $folderName = strtolower($this->argument('name'));
        $subdomain = strtolower($this->argument('subdomain'));

        if(empty($folderName)) {
            $folderName=strtolower($this->ask('Ingrese el nombre del dominio de la organización sin extension ni subdominio (Ej: miweb)?'));
        }

        if ($this->confirm('Seguro, el dominio se llama '.$folderName.'? [yes|no]'))
        {
            $path = base_path('organizations/'.$folderName);
            $pathstorage = base_path('organizations/'.$folderName.'/storage/');
            $filesql = base_path('organizations/'.$folderName.'/sqls/'.$folderName.'.sql');
            
            $filenameConfig=$path."/config.php";
            $filenameController=$path."/web/Controllers/HomeController.php";

            if(!File::isDirectory($path))
            {
                $this->info('Vamos a crear primero las estructuras de archivo de la Organización.');
                $this->info('Necesito que tenga a mano el ID de organizacion y los datos de la base de datos');
                if ($this->confirm('Seguro, desea continuar y crear la estructura de archivos y hacer la migración? [yes|no]'))
                {
                    File::makeDirectory($path, $mode = 0777, true, true);
                    File::makeDirectory($path.'/web', $mode = 0777, true, true);
                    File::makeDirectory($path.'/web/Controllers', $mode = 0777, true, true);
                    File::makeDirectory($path.'/web/Assets', $mode = 0777, true, true);
                    File::makeDirectory($path.'/web/Views', $mode = 0777, true, true);

                    /*******************************************/
                    /* Creo la estructura de la Organizacion   */
                    /******************************************/
                    $this->info('*****************************************************************************');
                    $this->info('Creando la estructura de archivos de '.$folderName);
                    $this->info('*****************************************************************************');

                    $organization_id=strtolower($this->ask('Ingrese el ID de organizacion'));
                    $host=strtolower($this->ask('Ingrese el nombre o IP del host mysql Ej: localhost '));
                    $database=strtolower($this->ask('Ingrese el nombre de la base de datos '));
                    $username=strtolower($this->ask('Ingrese el usuario de la base de datos '));
                    $password=strtolower($this->ask('Ingrese el password de la base de datos '));

                    // Leo la plantilla de stub
                    $contentConfig=File::get($this->getStub().'fulljauscmsconfig.stub');
                    $contentConfig=str_replace('{{ host }}',$host,$contentConfig);
                    $contentConfig=str_replace('{{ database }}',$database,$contentConfig);
                    $contentConfig=str_replace('{{ username }}',$username,$contentConfig);
                    $contentConfig=str_replace('{{ password }}',$password,$contentConfig);
                    $contentConfig=str_replace('{{ organization_id }}',$organization_id,$contentConfig);
                    File::put($filenameConfig,$contentConfig);


                    $contentController=File::get($this->getStub().'fulljauscmshomecontroller.stub');
                    $contentController=str_replace('{{ domain }}',$folderName,$contentController);
                    File::put($filenameController,$contentController);

                } else {
                    $this->info('** Proceso cancelado.');
                    return false;
                }

            }


            if(!File::isDirectory($pathstorage))
            {
                $this->info('*****************************************************************************');
                $this->info('Creando la estructura de archivos de '.$pathstorage);
                $this->info('*****************************************************************************');

                if(!File::isDirectory(base_path('storage/organizations/')))
                {
                    File::makeDirectory(base_path('storage/organizations/'), $mode = 0777, true, true);
                }
                File::makeDirectory($pathstorage, $mode = 0777, true, true);
                File::makeDirectory($pathstorage.'/private', $mode = 0777, true, true);
                File::makeDirectory($pathstorage.'/public', $mode = 0777, true, true);
            } else {
                $this->info('Ya existe: '.$pathstorage);
            }

            $this->info('**************************************************************');
            $this->info(' Migrando los datos de la base de datos de '.$folderName);
            $this->info('**************************************************************' . PHP_EOL);

            $cfg = require $filenameConfig;

            $dbconnection='mysql_com';
            if (!empty($subdomain)) {
                if (isset($cfg["dbconnection"]['mysql_'.$subdomain])) {
                    $dbconnection='mysql_'.$subdomain;
                }
            }

            Config::set('database.connections.mysql', $cfg["dbconnection"][$dbconnection]);
            Config::set('database.default', 'mysql');
            Config::set('fulljauscms', $cfg);

            Artisan::call("migrate:fresh --seed");
            dd(Artisan::output());
            
            if(File::isFile($filesql))
            {
                DB::unprepared(file_get_contents($filesql));
            }    
        } else {
            $this->info('** Proceso cancelado.');
        }

    }

    /*Route::get('db_dump', function () {
        /*
        Needed in SQL File:
    
        SET GLOBAL sql_mode = '';
        SET SESSION sql_mode = '';
        
        Cerrar -> * /

        $get_all_table_query = "SHOW TABLES";
        $result = DB::select(DB::raw($get_all_table_query));
    
        $tables = [
            'admins',
            'migrations',
        ];
    
        $structure = '';
        $data = '';
        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
    
            $show_table_result = DB::select(DB::raw($show_table_query));
    
            foreach ($show_table_result as $show_table_row) {
                $show_table_row = (array)$show_table_row;
                $structure .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }
            $select_query = "SELECT * FROM " . $table;
            $records = DB::select(DB::raw($select_query));
    
            foreach ($records as $record) {
                $record = (array)$record;
                $table_column_array = array_keys($record);
                foreach ($table_column_array as $key => $name) {
                    $table_column_array[$key] = '`' . $table_column_array[$key] . '`';
                }
    
                $table_value_array = array_values($record);
                $data .= "\nINSERT INTO $table (";
    
                $data .= "" . implode(", ", $table_column_array) . ") VALUES \n";
    
                foreach($table_value_array as $key => $record_column)
                    $table_value_array[$key] = addslashes($record_column);
    
                $data .= "('" . implode("','", $table_value_array) . "');\n";
            }
        }
        $file_name = __DIR__ . '/../database/database_backup_on_' . date('y_m_d') . '.sql';
        $file_handle = fopen($file_name, 'w + ');
    
        $output = $structure . $data;
        fwrite($file_handle, $output);
        fclose($file_handle);
        echo "DB backup ready";
    });*/

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
