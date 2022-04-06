<?php

namespace Main\Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Modules\Auditory\Models\Auditory;
use Modules\Record\Models\Record;
use Modules\Ticket\Models\Ticket;
use Modules\Web\Models\Messages;
use Webklex\PHPIMAP\ClientManager;
use Main\Auth\Models\EmailPassword;

class NotificationController extends Controller
{
    /**
     * The user making the current request.
     *
     * @var \Main\Auth\Models\User
     */
    public $user;

    /**
     * The resource routes.
     *
     * @var array
     */
    protected $routes = [
        'index' => 'admin.notifications.index',
        'read-selected' => 'admin.notifications.read-selected',
        'unread-selected' => 'admin.notifications.unread-selected',
        'read' => 'admin.notifications.read',
        'unread' => 'admin.notifications.unread',
    ];

    /**
     * The resource views.
     *
     * @var array
     */
    protected $views = [
        'index' => 'Admin.Views.notifications.index',
        'show' => 'Admin.Views.notifications.show',
    ];

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function __construct(Auditory $auditory)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });

        $this->auditory = $auditory;
    }

    public function setTemplateData()
    {
        $templateData = new class
        {
        };

        $templateData->routes = $this->routes;
        $templateData->modulesNames = [
            'record' => 'Expedientes',
            'ticket' => 'Tickets',
        ];

        view()->share("templateData", $templateData);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('access', $this->routes['index']);

        if (request()->ajax()) {
            if ($this->user->unreadNotifications->isNotEmpty()) {
                $this->user->unreadNotifications->transform(function ($item) {
                    $item->howLong = $item->created_at->diffForHumans();
                    return $item;
                });
            }

            $response = new \stdClass();
            $response->notifications = $this->user->unreadNotifications;
            $response->emails = $this->getUnreadEmails();

            if (Config::get('fulljauscms.modules.record') == 1) {
                $response->records = Record::ongoing()->count();
            }

            if (Config::get('fulljauscms.modules.ticket') == 1) {
                $response->tickets = Ticket::pending()->count();
            }

            if (Config::get('fulljauscms.modules.web') == 1) {
                $response->messages = Messages::where('status', 1)->count();
            }

            return response()->json($response);
        }

        switch (request('f')) {
            case 'unread':
                $filter = 'No leídas';
                $data = $this->user->unreadNotifications()->paginate()->withQueryString();
                break;
            case 'read':
                $filter = 'Leídas';
                $data = $this->user->readNotifications()->paginate()->withQueryString();
                break;
            case 'all':
                $filter = 'Todas';
                $data = $this->user->notifications()->paginate()->withQueryString();
                break;
            default:
                return back()->with('error', 'No pudimos ingresar al listado de notificaciones');
        }

        $this->setTemplateData();

        $this->auditory->save('access', 'Accedió al listado de notificaciones');

        return view($this->views['index'], compact("data", "filter"));
    }

    private function getUnreadEmails()
    {
        if (empty($this->user->email)) {
            return [];
        }

        $res = [];
        $emailConfig = config('fulljauscms.email');

        if (empty($emailConfig)) {
            return [];
        }

        $imapConfig = [
            'host'          => $emailConfig['host'],
            'port'          => $emailConfig['port'],
            'password'      => 'ayd352008MJ', // $emailConfig['password'],
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'protocol'      => 'imap'
        ];

        $emails = explode(',', $this->user->email);
        foreach ($emails as $k => $email) {
            $imapConfig['username'] = $email;

            // vamos con las claves custom
            $emailPassword = EmailPassword::where('email', $email)->first();
            $customPassword = null;
            if (!empty($emailPassword) AND !empty($emailPassword['password'])) {
                $customPassword = $emailPassword['password'];
            }

            $imapConfig['password'] = (!empty($customPassword))?$customPassword:'ayd352008MJ';

            $cm = new ClientManager($imapConfig);
            $client = $cm->make($imapConfig);

            try {
                $client->connect();
            } catch (\Exception $e) {
                continue;
            }

            $messages = $client->getFolderByName('INBOX')->query()->unseen()->count();

            $res[$k] = $messages;
        }

        return $res;
    }

    /**
     * Mark the selected notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function readSelected(Request $request)
    {
        Gate::authorize('access', $this->routes['read-selected']);

        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'notifications' => ['required', 'array'],
                'notifications.*' => ['distinct', 'exists:notifications,id'],
            ]);

            $this->user
                ->notifications()
                ->whereIn('id', $validatedData['notifications'])
                ->update(['read_at' => now()]);
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th);

            $this->auditory->save('error', "Intentó marcar múltiples notificaciones como leídas");

            return back()->with('error', 'No pudimos marcar las notificaciones como leídas');
        }
        DB::commit();

        $this->auditory->save('update', 'Marcó múltiples notificaciones como leídas');

        return back()->with('success', 'Notificaciones marcadas como leídas');
    }

    /**
     * Mark the selected notifications as unread.
     *
     * @return \Illuminate\Http\Response
     */
    public function unreadSelected(Request $request)
    {
        Gate::authorize('access', $this->routes['unread-selected']);

        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'notifications' => ['required', 'array'],
                'notifications.*' => ['distinct', 'exists:notifications,id'],
            ]);

            $this->user
                ->notifications()
                ->whereIn('id', $validatedData['notifications'])
                ->update(['read_at' => null]);
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->auditory->save('error', "Intentó marcar múltiples notificaciones como no leídas");

            return back()->with('error', 'No pudimos marcar las notificaciones como no leídas');
        }
        DB::commit();

        $this->auditory->save('update', 'Marcó múltiples notificaciones como no leídas');

        return back()->with('success', 'Notificaciones marcadas como no leídas');
    }

    /**
     * Mark the notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function read($id)
    {
        Gate::authorize('access', $this->routes['read']);

        DB::beginTransaction();
        try {
            $notification = $this->user->notifications()->findOrFail($id);

            $notification->markAsRead();
        } catch (\Throwable $th) {
            DB::commit();

            $this->auditory->save('error', "Intentó marcar una notificación eliminada o no existente como leída (ID: {$id})");

            return back()->with('error', 'No encontramos la notificación a marcar como leída');
        }
        DB::commit();

        $this->auditory->save('update', 'Marcó una notificación como leída');

        return back()->with('success', 'Notificación marcada como leída');
    }

    /**
     * Mark the notification as unread.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unread($id)
    {
        Gate::authorize('access', $this->routes['unread']);

        DB::beginTransaction();
        try {
            $notification = $this->user->notifications()->findOrFail($id);

            $notification->read_at = null;
            $notification->save();
        } catch (\Throwable $th) {
            DB::rollBack();

            $this->auditory->save('error', "Intentó marcar una notificación eliminada o no existente como no leída (ID: {$id})");

            return back()->with('error', 'No encontramos la notificación a marcar como no leída');
        }
        DB::commit();

        $this->auditory->save('update', 'Marcó una notificación como no leída');

        return back()->with('success', 'Notificación marcada como no leída');
    }
}
