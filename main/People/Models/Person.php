<?php

namespace Main\People\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Main\Geo\Models\City;
use Modules\Bank\Models\Account;
use Modules\Record\Models\Record;

class Person extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'people_persons';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [
        'es'=>['ID', 'Nombre', 'DNI', 'CUIT', 'Ciudad', 'Estado'],
        'en'=>['ID', 'Name', 'DNI', 'CUIT', 'City', 'Status'],
        'pt'=>['ID','Nome','DNI','CUIT','Cidade','Status']
    ];
    static public $list_fields = ['id', 'name', 'dni', 'cuit', 'city->name', 'status'];
    static public $ordenable_fields = [true, true, true, false, false];

    static public $ordinal_field = '';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    static public function getdata()
    {
        $res = self::query();

        $res->with(['city', 'city.region', 'city.region.country']);

        if (! empty($_POST['filter_search'])) {
            $res->where('name', 'like', "%{$_POST['filter_search']}%")
                ->orWhere('dni', 'like', "%{$_POST['filter_search']}%")
                ->orWhere('cuit', 'like', "%{$_POST['filter_search']}%");
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

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function relatives()
    {
        return $this->hasMany(Relative::class);
    }

    public function relativesIds()
    {
        return $this->relatives()->pluck('relative_id')->toArray();
    }

    public function records()
    {
        return $this->morphMany(Record::class, 'recordable');
    }

    public function getDottedDniAttribute()
    {
        return number_format($this->dni, 0, ',', '.');
    }
}
