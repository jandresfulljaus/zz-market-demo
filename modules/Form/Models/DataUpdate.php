<?php

namespace Modules\Form\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Main\Auth\Models\User;

class DataUpdate extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'form_data_updates';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'personal_data' => 'array',
        'family_unit' => 'array',
        'housing' => 'array',
        'health' => 'array',
        'contact' => 'array',
        'created_at' => 'datetime:d/m/Y',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name', 'is_processed'];

    static public $heads_fields = [
        'ID',
        'Legajo',
        'Vecino/DNI',
        'Fecha de solicitud/Atendió',
        'Procesado',
    ];
    static public $list_fields = [
        'id',
        'personal_data->file',
        'full_name+personal_data->dni',
        'created_at+user->person->name',
        'is_processed',
    ];
    static public $ordenable_fields = [false, false, false];

    static public $ordinal_field = '';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->personal_data['surname']} {$this->personal_data['name']}";
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getIsProcessedAttribute()
    {
        return ($this->processed_at) ? 'Si' : 'No';
    }

    static public function getdata()
    {
        $res = self::query();

        $res->with(['user:id,person_id', 'user.person:id,name']);

        if (! empty($_POST['filter_search'])) {
            $res->where('personal_data->surname', 'like', "%{$_POST['filter_search']}%")
                ->orWhere('personal_data->name', 'like', "%{$_POST['filter_search']}%")
                ->orWhere('personal_data->dni', 'like', "%{$_POST['filter_search']}%");
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
        return $this->belongsTo(User::class);
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
