<?php

namespace Main\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perm extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_perms';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [   
        'es'=>['ID', 'Nombre', 'Slug', 'Estado'],
        'en'=>['ID','Name','Slug','Status'],
        'pt'=>['ID','Nome','Slug','Status']
    ];
    static public $list_fields = ['id', 'name', 'slug', 'status'];
    static public $ordenable_fields = [false, true, true, false];

    static public $ordinal_field = '';
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

    public function role()
    {
        return $this->belongsToMany(Role::class, 'auth_perm_role')->withTimesTamps();
    }

}
