<?php

use App\Models\Conversation;
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


Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    // Ensure the user is part of the conversation
    $conversation = Conversation::find($conversationId);
    if (!$conversation) {
        return false;
    }

    // Assuming `participants` is a relation or method that returns users in the conversation
    return $conversation->source_id == $user->id ||  $conversation->destination_id == $user->id;
});
