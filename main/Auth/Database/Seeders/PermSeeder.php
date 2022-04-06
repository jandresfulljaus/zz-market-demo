<?php

namespace Main\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PermSeeder extends Seeder
{
    public function run()
    {
        /* Creo Permisos */
        $routeCollection = Route::getRoutes();
        
        $id = 1;
        $lastaction='';
        foreach ($routeCollection as $value ) {
            $action = $value->getName();
            $name = $value->getActionName();
            if (! isset($action) || empty($action) || substr($action, 0, 8) == "ignition" || $lastaction==$action) {
                // Nada de momento
            } else {
                DB::table('auth_perms')->insert([
                    'id' => $id,
                    'slug' => $name,
                    'description' => $name,
                    'name' => $action
                ]);
                DB::table('auth_perm_role')->insert([
                    'perm_id' => $id,
                    'role_id' => 1
                ]);

                if (substr($action, 0, 3) == 'geo' || substr($action, 0, 9) == 'auth.role' || substr($action, 0, 9) == 'auth.perm') {

                } else  {
                    DB::table('auth_perm_role')->insert([
                        'perm_id' => $id,
                        'role_id' => 2
                    ]);
    
                }

                if ((substr($action, 0, 8) == 'products' && substr($action, 0, 22) != 'products.products.find' &&  substr($action, 0, 23) != 'products.prices.getdata' &&  substr($action, 0, 21) != 'products.prices.sheet'  && substr($action, 0, 20) != 'products.prices.list') || substr($action, 0, 3) == 'geo' || (substr($action, 0, 4) == 'auth' && substr($action, 0, 8) != 'auth.log' && $action != 'auth.do_login') || (substr($action, 0, 6) == 'orders' && substr($action, 0, 13) != 'orders.orders')) { 

                } else {
                    DB::table('auth_perm_role')->insert([
                        'perm_id' => $id,
                        'role_id' => 3
                    ]);
                }
            }
            $id++;
            $lastaction = $action;
        }



        /* Creo Permisos para esos roles */
        //DB::unprepared(file_get_contents(__DIR__.'/sqls/auth_perm_role.sql'));
    }
}
