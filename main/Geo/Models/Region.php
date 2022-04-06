<?php

namespace Main\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Main\Geo\Models\Country;

class Region extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'geo_regions';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [
        'es'=>['Ord.', 'ID', 'Pais', 'Provincia', 'Estado'],
        'en'=>['Ord.', 'ID', 'Country', 'Province', 'Status'],
        'pt'=>['Ord.', 'ID', 'País', 'Província', 'Status'] 
    ];
    static public $list_fields = ['position', 'id', 'country->name', 'name', 'status'];
    static public $ordenable_fields = [false, false, false, false, false];

    static public $ordinal_field = 'position';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos


    static public function getdata()
    {
        $res = self::query();

        $res->with('country');

        if (! empty($_POST['filter_id'])) {
            $res->where('country_id', $_POST['filter_id']);
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

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
