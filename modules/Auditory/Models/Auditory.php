<?php

namespace Modules\Auditory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Main\Auth\Models\User;

class Auditory extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auditory_logs';

    /**
     * Se utiliza para controlar si se debe omitir el próximo registro
     * Se usa llamando a la función skipNextLog()
     */
    private $skipNextLog = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    static public $heads_fields = [
        'es'=>['ID', 'Fecha', 'Usuario', 'Descripción', 'Módulo', 'Tipo', 'IP'],
        'en'=>['ID', 'Date', 'User', 'Description', 'Module', 'Type', 'IP'],
        'pt'=>['ID',' Data', 'Usúario', 'Descrição', 'Módulo', 'Tipo','IP']
    ];
    static public $list_fields = ['id', 'when', 'user->person->name', 'description', 'module', 'action', 'ip'];
    static public $ordenable_fields = [false];

    static public $ordinal_field = 'id';
    static public $ordinal_order = 'DESC';
    static public $sort = false; // Debe existir un campo position en la base de datos

    static public function getdata()
    {
        $res = self::query();

        $res->with(['user', 'user.person']);

        if (! empty($_POST['filter_search'])) {
            $res->where('when', 'like', "%{$_POST['filter_search']}%")
                ->orWhere('action', 'like', "%{$_POST['filter_search']}%")
                ->orWhere('description', 'like', "%{$_POST['filter_search']}%")
                ->orWhere('ip', 'like', "%{$_POST['filter_search']}%")
                ->orWhereHas('user.person', function ($query) {
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Inicia los parámetros que pueden ser completados desde
     * un controlador, el resto de valores se asigna automaticamente
     * cuando se llama al método save()
     */
    public function setInitialParams()
    {
        $this->action = null;
        $this->description = null;

        $this->model = null;

        $this->old_value = null;
        $this->new_value = null;
    }

    /**
     * Se utiliza cuando un controlado extiende basecontroler y
     * pone su propio mensaje antes de llamar a un método de la clase padre
     * ej: cuando se llama a edit() y el child pone un mensaje custom
     * para que no se repita el mensaje dos veces en la auditoría
     */
    public function skipNextLog()
    {
        $this->skipNextLog = true;
    }

    /**
     * Recibe la instancia de un objeto de Eloquent
     * y saca la diferencia luego de actualizar el registro.
     * Se debe llamar luego de hacer un update(), save() o similar
     */
    public function setDiffFromObject($object)
    {
        // valores sensibles para no incluir
        $ignore = ['password'];

        $original = $object->getOriginal();
        $changes = $object->getChanges();

        if (empty($changes)) { return false; }

        $old = [];

        foreach ($changes as $key => $value) {
            if (isset($original[$key])) {
                $old[$key] = $original[$key];
            }
        }

        // sacar valores sensibles
        if (! empty($ignore)) {
            foreach ($ignore as $key => $value) {
                if (isset($old[$value])) {
                    unset($old[$value]);
                }

                if (isset($changes[$value])) {
                    unset($changes[$value]);
                }
            }
        }

        // sacar los archivos embebidos
        $old = $this->removeFilesData($old);
        $changes = $this->removeFilesData($changes);

        $this->old_value = json_encode($old);
        $this->new_value = json_encode($changes);
    }

    /**
     * Este es el método principal para guardar los registros
     * de auditoría, se complementa con setDiffFromObject.
     * Se puede llamar varias veces, ya que luego de guardar
     * se reinician las propiedades del objeto
     */
    public function save($action = null, $description = null, $model = null, $skip = false)
    {
        if ($this->skipNextLog) {
            $this->skipNextLog = false;

            return true;
        }

        if (! empty($action)) { $this->action = $action; }

        if (! empty($description)) { $this->description = $description; }

        if (! empty($model)) { $this->model = $model; }

        $route = Route::current()->getAction();

        $params = Request::all();

        if (! empty($params)) {
            $params = $this->removeFilesData($params);
            $params = json_encode($params);
        } else {
            $params = null;
        }

        $this->module = explode('\\', $route['controller'])[1];

        $this->user_id = @Auth::user()->id;
        $this->when = date('Y-m-d H:i:s');

        $this->ip = Request::ip();
        $this->device = Request::server()['HTTP_USER_AGENT'];
        $this->request = Request::path();;
        $this->method = Request::method();
        $this->params = $params;
        $this->status = 1;

        $this->controller = $route['controller'];

        return $this->doSave();
    }

    /**
     * Función recursiva para eliminar las imágenes del
     * registro de parámetros de la auditoría
     */
    private function removeFilesData($params)
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (is_array($value)) {
                    $params[$key] = $this->removeFilesData($value);
                }else{
                    // omitir archivos
                    if (strpos($value, 'data:') === 0) {
                        $value = '- Archivo omitido por su tamaño -';
                        $params[$key] = '- Archivo omitido por su tamaño -';
                    }

                    // omitir archivos embebidos en el contenido
                    $params[$key] = $this->removeFilesContent($value);
                }
            }
        }

        return $params;
    }

    private function removeFilesContent($content)
    {
        $position = strpos($content, 'src="data:');

        if ($position !== false) {
            $first = substr($content, 0, $position);

            // le sumo los 10 caracteres de src="data:
            $last = substr($content, ($position+10));

            // encontrar el cierre de los datos
            $end = strpos($last, '"');
            if ($end !== false) {
                // le sumo 1 para sacar la comilla
                $res = substr($last, ($end+1));
                $content = $first.'src="- omitido -"'.$res;
            }
        }

        // recursión
        if (strpos($content, 'src="data:') !== false) {
            $content = $this->removeFilesContent($content);
        }

        return $content;
    }

    /**
     * Este método es el que hace efectivamente el guardado
     * desde el método insert del modelo
     */
    private function doSave()
    {
        $attributes = $this->attributes;
        $attributes['created_at'] = now();
        $attributes['updated_at'] = $attributes['created_at'];

        $result = $this->insert($attributes);

        $this->setInitialParams();

        return $result;
    }
}
