<?php

namespace Main\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Main\Geo\Models\City;

class Organization extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_organizations';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [
        'es'=>['ID', 'Nombre', 'Ciudad', 'Estado'],
        'en'=>['ID','Name','City', 'Status'],
        'pt'=>['ID','Nome','Cidade','Status']
    ];
    static public $list_fields = ['id', 'name', 'city->name', 'status'];
    static public $ordenable_fields = [true, true, false, false];

    static public $ordinal_field = '';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    static public function getdata()
    {
        $res = self::query();

        $res->with('city');

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

    static public function mygetdata()
    {
        $res = self::query();

        $res->with('city');


        $res->where('status', 1)->where('id','!=', 1);

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

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function region()
    {
        return $this->city->region;
    }

    public function country()
    {
        return $this->region()->country;
    }

    public function json()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->name,
            'pais' => $this->country()->name,
            'region' => $this->region()->name,
            'ciudad' => $this->city->name
        ];
    }
}
