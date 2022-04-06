<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModulesFulljauscms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fulljauscms:modules {name? : Nombre del modulo a crear} {del? : Elimina el modulo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando Fulljaus cms para crear un nuevo modulo';

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
        $folderName = ucwords(strtolower($this->argument('name')));

        $deleted = $this->argument('del');

        $path = base_path('modules/'.$folderName.'/');

        $isCreate=($deleted=="del" || $deleted=="delete")?false:true;
        $action=$isCreate?'Creando':'Eliminando';
        $this->info('************************************');
        $this->info($action.' un módulo de Fulljaus cms');
        $this->info('************************************' . PHP_EOL);

        $this->info('==========================');
        $this->info($action.' el Directorio: '. PHP_EOL . $path);
        $this->info('=========================='. PHP_EOL);

        //$subFolders = ['Controllers','Models','Views'];
        $subFolders = ['Controllers','Database','Database/Migrations','Database/Seeders','Routes','Models','Views'];

        if($isCreate)
        {
            if(!File::isDirectory($path))
            {
                File::makeDirectory($path, 0777, true, true);
            }
        } else {
            if(File::isDirectory($path))
            {
                File::deleteDirectory($path,false);
            }
        }

        $this->info('==========================');
        foreach($subFolders as $folder)
        {
            $pathFolder = base_path('modules/'.$folderName.'/'.$folder.'/');
            $this->info($action.' el Directorio: '. PHP_EOL .$pathFolder. PHP_EOL .'dentro de: '. PHP_EOL .$folderName);
            $this->info('==========================');

            if($isCreate)
            {
                if(!File::isDirectory($pathFolder))
                {
                    File::makeDirectory($pathFolder, 0777, true, true);
                }
            } else {
                //File::deleteDirectory($pathFolder,false);
            }

        }

        $filenameRoutes=$path.'Routes/fulljauscms.php';
        $contentRoutes= File::get($this->getStub().'fulljauscmsroutes.stub');
        $contentRoutes=str_replace('{{ modulename }}',$folderName,$contentRoutes);
        File::put($filenameRoutes,$contentRoutes);

        $filenameInfo=$path.'routes.readme.txt';

        $this->info(PHP_EOL);
        $instructions='';
        $instructions.="Requiera 'modules/{$folderName}/routes.php' en 'routes/fulljauscms.php':".PHP_EOL;
        $instructions.="require base_path('modules/{$folderName}/routes.php');".PHP_EOL;

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
