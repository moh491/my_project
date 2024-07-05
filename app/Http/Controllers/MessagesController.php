<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Freelancer;
use App\Models\Message;
use App\Models\Project_Owners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{

    public function fetchConversations(): \Illuminate\Http\JsonResponse
    {
        $authUser = Auth::user();

        $conversations = Conversation::with('lastMessage')->where('source_id', $authUser->id)
            ->where('source_type', get_class($authUser))
            ->orWhere(function ($query) use ($authUser) {
                $query->where('destination_id', $authUser->id)
                    ->where('destination_type', get_class($authUser));
            })
            ->with(['source', 'destination'])
            ->get()
            ->map(function ($conversation) use ($authUser) {
//                $conversation->last_message = $conversation->lastMessage->body;
                if ($conversation->source_id == $authUser->id && $conversation->source_type == get_class($authUser)) {
                    $conversation->contact = $conversation->destination;
                } else {
                    $conversation->contact = $conversation->source;
                }
                return $conversation;
            });

        return response()->json($conversations);
    }


    public function sendMessage(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = auth::user();

        $message = Message::create([
            'source_id' => $user->id,
            'source_type' => get_class($user),
            'destination_id' => $request['destination_id'],
            'destination_type' => $request['destination_type'],
            'body' => $request['body'],
            'conversation_id' => $request['conversation_id']
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json(['message' => $message]);
    }


    public function fetchMessages(string $conversationId): \Illuminate\Http\JsonResponse
    {
        $messages = Message::where('conversation_id', $conversationId)->get();
        $con= Conversation::find($conversationId);
        $data = [
            'user_des' => [
                'id' =>  $con->destination_id,
                'type' => $con->destination_type
            ] ,
            'user_source' => [
                'id' =>  $con->source_id,
                'type' => $con->source_type
            ] ,
            'messages' => $messages
        ];
        return response()->json($data);
    }

}