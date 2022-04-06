<?php

namespace Main\Auth\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Main\Admin\Libraries\Control;
use Main\People\Models\Person;
use Modules\Organigram\Models\Department;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auth_users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    //static public $heads_fields = ['ID', 'Nombre', 'Email', 'Teléfono', 'Estado'];
    
    static public $heads_fields = [
        'es'=>['ID', 'Nombre', 'Email', 'Teléfono', 'Estado'],
        'en'=>['ID','Name','Email','Phone Number', 'Status'],
        'pt'=>['ID','Nome','Email','Telefone','Status']
    ];
    static public $list_fields = ['id', 'person->name', 'email', 'phone', 'status'];
    static public $ordenable_fields = [false, true, false, false, false];

    static public $ordinal_field = '';
    static public $ordinal_order = 'ASC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    /**
     * Get the user's name.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->person->name;
    }

    static public function getdata()
    {
        $res = self::query();

        $res->with(['person', 'organization', 'role']);

        if (! empty($_POST['filter_search'])) {
            $res->where('email', 'like', "%{$_POST['filter_search']}%")
                ->orWhereHas('person', function ($query) {
                    $query->where('name', 'like', "%{$_POST['filter_search']}%");
                });
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

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'auth_role_user')->withTimesTamps();
    }

    // TODO: refactorizar código de asignaciones
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'organigram_assignments')
            ->withTimestamps()
            ->whereNull('organigram_assignments.deleted_at');
    }

    public function departmentsIds()
    {
        return $this->departments()->pluck('department_id')->toArray();
    }

    public function belongsToDepartment($department_id) {
        return $this->departments()
            ->where('department_id', $department_id)
            ->exists();
    }

    public function havePermission($permission)
    {
        foreach($this->role as $role ) {
            if($role->access === "full") {
                return true;
            }

            foreach ($role->perm as $perm) {
                if ($perm->name === $permission ) {
                    return true;
                }
            }
        }

        return false;
    }

    static public function hasWeakPassword($user_id)
    {
        $res = null;

        $user = self::with('person')->find($user_id);

        if (empty($user)) { return $res; }

        $weakPass = [
            $user->person->name,
            $user->person->dni,
            $user->person->cuit,
            'control',
            'lortnoc',
            '12345678',
            '1234567',
            '123456',
            '12345',
            '1234',
            'qwer1234',
        ];

        foreach ($weakPass as $key => $value) {
            $weakPass[$key] = Control::hash($value);
        }

        return (in_array($user->password, $weakPass));
    }

    public static function getForNotification($module, $filters)
    {
        if (isset($filters['user_id'])) {
            return self::find($filters['user_id']);
        }

        if (isset($filters['send_to'])) {
            if (count($filters['send_to']) === 1) {
                return self::find($filters['send_to'][0]);
            } else {
                return self::whereIn('id', $filters['send_to'])->get();
            }
        }

        $query = User::query();

        $query->where('id', '!=', auth()->user()->id);

        switch ($module) {
            case 'record':
                $query->whereHas('role', function($query) {
                    $query->where('access', 'full')
                        ->orWhereHas('perm', function($query) {
                            $query->where('name', 'record.records.show');
                        });
                    })
                    ->whereHas('departments', function($query) use ($filters) {
                        $query->where('department_id', $filters['department_id']);
                    });
                break;
            case 'ticket':
                $query->whereHas('role', function($query) {
                    $query->where('access', 'full')
                        ->orWhereHas('perm', function($query) {
                            $query->where('name', 'ticket.tickets.show');
                        });
                    })
                    ->whereHas('departments', function($query) use ($filters) {
                        $query->where('department_id', $filters['department_id']);
                    });
                break;
        }

        return $query->get();
    }

    public function isRootOrAdmin()
    {
        foreach($this->role as $role){
            if($role->name == 'Root' || $role->name == 'Admin')
                return true;
        }
        return false;
    }

    public function isUser()
    {
        foreach($this->role as $role){
            if($role->name == 'User')
                return true;
        }
        return false;
    }

    public function isRoot()
    {
        foreach($this->role as $role){
            if($role->name == 'Root')
                return true;
        }
        return false;
    }

    public function isAdmin()
    {
        foreach($this->role as $role){
            if($role->name == 'Admin')
                return true;
        }
        return false;
    }
}
