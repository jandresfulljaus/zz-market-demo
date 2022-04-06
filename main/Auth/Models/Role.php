<?php

namespace Main\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_roles';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [
        'es'=>['ID', 'Slug', 'Nombre', 'Acceso completo', 'Estado'],
        'en'=>['ID','Slug','Name','Complete access','Status'],
        'pt'=>['ID','Slug','Nome','Acesso total','Status']
    ];
    static public $list_fields = ['id', 'slug', 'name', 'access', 'status'];
    static public $ordenable_fields = [false, true, true, true, false];

    static public $ordinal_field = '';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    static public function getdata()
    {
        $res = self::query();

        $res->with('perm');

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

    public function user()
    {
        return $this->belongsToMany(User::class, 'auth_role_user')->withTimesTamps();
    }

    public function perm()
    {
        return $this->belongsToMany(Perm::class, 'auth_perm_role')->withTimesTamps();
    }
}
