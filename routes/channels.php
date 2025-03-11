<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user-collaborate-channel.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});