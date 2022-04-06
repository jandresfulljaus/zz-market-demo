<?php

namespace Main\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'geo_countries';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [
        'es'=>['Ord.', 'ID', 'Nombre', 'ISO', 'Cod. Telefonico', 'Estado'],
        'en'=>['Ord.', 'ID', 'Name', 'ISO', 'Phone Code', 'Status'],
        'pt'=>['Ord.', 'ID', 'Nome', 'ISO', 'Prefijo Telefonico', 'Status']
    ];
    static public $list_fields = ['position', 'id', 'name', 'iso', 'phone', 'status'];
    static public $ordenable_fields = [true, false, true, false, false, false];

    static public $ordinal_field = 'position';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    static public function getdata()
    {
        $res = self::query();

        if (! empty($_POST['filter_search'])) {
            $res->where('name', 'like', "%{$_POST['filter_search']}%");
        }

        if (! empty($_POST['ordinal_field'])) {
            self::$ordinal_field = $_POST['ordinal_field'];

            if (! empty($_POST['ordinal_order'])) {
                self::$ordinal_order = $_POST['ordinal_order'];
            }
        }

        if (! empty(self::$ordinal_field)) {
            $res->orderBy(self::$ordinal_field, self::$ordinal_order);
        }

        return $res;
    }
}
