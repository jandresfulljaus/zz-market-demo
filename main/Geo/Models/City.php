<?php

namespace Main\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'geo_cities';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [
        'es'=>['ID', 'Pais', 'Provincia', 'Zona', 'Nombre', 'Estado'],
        'en'=>['ID', 'Country', 'Province', 'Zone','Name', 'Status'],
        'pt'=>['ID', 'País', 'Província', 'Zona','Nome', 'Status']
    ];
    static public $list_fields = ['id', 'region->country->name', 'region->name', 'zonename', 'name', 'status'];
    static public $ordenable_fields = [true, false, false, true, true, false];

    static public $ordinal_field = 'id';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    static public function getdata()
    {
        $res = self::query();

        $res->with(['region', 'region.country']);

        if (! empty($_POST['filter_id'])) {
            $res->where('region_id', $_POST['filter_id']);
        }

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

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
