<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chat-message.{id}', function ($user, $id) {
    return (int) $user->user->id === (int) $id;
});

Broadcast::channel('new-conversation.{id}', function ($user, $id) {
    return (int) $user->user->id === (int) $id;
});

Broadcast::channel('new-order.{id}', function ($user, $id) {
    if ($user->user->roles[0]->name == 'admin') {
        return (int) $user->user->id === (int) $id;
    }
    return false;
});

Broadcast::channel('listUsers', function ($user) {
    return $user->user;
});
