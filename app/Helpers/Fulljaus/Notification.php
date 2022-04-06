<?php

namespace App\Helpers\Fulljaus;

use App\Notifications\FulljausNotification;
use Illuminate\Support\Facades\Notification as NotificationFacade;
use Main\Auth\Models\User;

class Notification
{
    /**
     * Sends a notification.
     *
     * @param  string  $module
     * @param  string  $model
     * @param  string  $action
     * @param  array  $filters
     * @param  array $objects
     * @return void
     */
    public static function send($module, $model, $action, $filters, $objects = null)
    {
        $users = User::getForNotification($model, $filters);

        $hasUsersAssigned = isset($filters['user_id']) || isset($filters['send_to']);

        $notificationData = static::$module($model, $action, $objects, $hasUsersAssigned);

        [$title, $description, $content, $url] = $notificationData;

        NotificationFacade::send($users, new FulljausNotification($module, $title, $description, $content, $url));
    }

    /**
     * Formats the notifications of the record module
     *
     * @param  string  $model
     * @param  string  $action
     * @param  array  $objects
     * @param  bool  $hasUsersAssigned
     * @return array
     */
    private static function record($model, $action, $objects, $hasUsersAssigned)
    {
        $username = auth()->user()->name;
        [$record] = $objects;

        switch ($model) {
            case 'action':
                switch ($action) {
                    case 'created':
                        $title = "Se realizó una actuación en un expediente";
                        $description = "{$username} realizó una actuación en el expediente {$record->code}";
                        break;
                }
                break;
            case 'move':
                switch ($action) {
                    case 'created':
                        if ($hasUsersAssigned) {
                            $title = "Te transfirieron un expediente";
                            $description = "{$username} te transfirió el expediente {$record->code}";
                        } else {
                            $title = "Se transfirió un expediente a tu oficina";
                            $description = "{$username} transfirió el expediente {$record->code} a tu oficina";
                        }
                        break;
                }
                break;
            case 'record':
                switch ($action) {
                    case 'created':
                        if ($hasUsersAssigned) {
                            $title = "Te asignaron a un expediente";
                            $description = "{$username} inició el expediente {$record->code} y te asignó";
                        } else {
                            $title = "Se inició un expediente a tu oficina";
                            $description = "{$username} inició el expediente {$record->code} asignado a tu oficina";
                        }
                        break;
                }
                break;
            case 'rename':
                switch ($action) {
                    case 'created':
                        $title = "Se recaratuló un expediente";
                        $description = "{$username} recaratuló el expediente {$record->code}";
                        break;
                }
                break;
            case 'status':
                switch ($action) {
                    case 'created':
                        $title = "Se cambió el estado de un expediente";
                        $description = "{$username} cambío el estado del expediente {$record->code}";
                        break;
                }
                break;
        }

        $content = null;
        $url = route('record.records.show', $record->id);

        return [$title, $description, $content, $url];
    }

    /**
     * Formats the notifications of the ticket module
     *
     * @param  string  $model
     * @param  string  $action
     * @param  array  $objects
     * @param  bool  $hasUsersAssigned
     * @return array
     */
    private static function ticket($model, $action, $objects, $hasUsersAssigned)
    {
        $username = auth()->user()->name;
        [$ticket] = $objects;

        switch ($model) {
            case 'message':
                switch ($action) {
                    case 'created':
                        $title = "Se envió un mensaje a un ticket";
                        $description = "{$username} envió un mensaje al ticket {$ticket->number}";
                        break;
                }
                break;
            case 'move':
                switch ($action) {
                    case 'created':
                        if ($hasUsersAssigned) {
                            $title = "Te transfirieron un ticket";
                            $description = "{$username} te transfirió el ticket {$ticket->number}";
                        } else {
                            $title = "Se transfirió un ticket a tu oficina";
                            $description = "{$username} transfirió el ticket {$ticket->number} a tu oficina";
                        }
                        break;
                }
                break;
            case 'ticket':
                switch ($action) {
                    case 'created':
                        if ($hasUsersAssigned) {
                            $title = "Te asignaron a un ticket";
                            $description = "{$username} inició el ticket {$ticket->number} y te asignó";
                        } else {
                            $title = "Se inició un ticket a tu oficina";
                            $description = "{$username} inició el ticket {$ticket->number} asignado a tu oficina";
                        }
                        break;
                    case 'resolved':
                        $title = "Se resolvió un ticket";
                        $description = "{$username} resolvió el ticket {$ticket->number}";
                        break;
                }
                break;
        }

        $content = null;
        $url = route('ticket.tickets.show', $ticket->id);

        return [$title, $description, $content, $url];
    }
}
