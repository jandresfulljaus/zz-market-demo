<?php

namespace Main\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailPassword extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_email_passwords';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [
        'es'=>['ID', 'Email'],
        'en'=>['ID','Email'],
        'pt'=>['ID','Email']
    ];
    static public $list_fields = ['id', 'email'];
    static public $ordenable_fields = [false, true];

    static public $ordinal_field = '';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    static public function getdata()
    {
        $res = self::query();

        if (! empty($_POST['filter_search'])) {
            $res->where('email', 'like', "%{$_POST['filter_search']}%");
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
