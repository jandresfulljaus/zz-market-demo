<?php

namespace Main\Admin\Libraries;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Main\System\Models\Log;

Class Control {

    function __construct(){
    }

    public static function hash($string)
    {
        return sha1($string.'_lortnoc');
    }

    public static function log($slug='',$description='')
    {
        $user_id=2;
        $organization_id=1;

        $user = auth()->user();

        if(!empty($user->id))
        {
            $user_id=$user->id;
            $organization_id=$user->organization_id;
        }
        if($slug=='')
        {
            $slug = Route::currentRouteAction();
        }
        if($description=='')
        {
            $description = Route::currentRouteName();
        }

        $log = new Log();
        $log->user_id = $user_id;
        $log->organization_id = $organization_id;
        $log->slug = $slug;
        $log->description = $description;
        $log->save();
    }


}
