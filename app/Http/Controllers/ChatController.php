<?php

namespace App\Http\Controllers;

use App\Events\MessageRead;
use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(User $friend)
    {
        return view('chat', compact('friend'));
    }

    public function messages(User $friend)
    {
        ChatMessage::where('sender_id', $friend->id)->where('receiver_id', auth()->id())->update([
            'is_read' => 1
        ]);
        return ChatMessage::query()
            ->where(function ($query) use ($friend) {
                $query->where('sender_id', auth()->id())->where('receiver_id', $friend->id);
            })
            ->orWhere(function ($query) use ($friend) {
                $query->where('sender_id', $friend->id)->where('receiver_id', auth()->id());
            })
            ->with(['sender', 'receiver'])->orderBy('id', 'asc')->get();
    }

    public function message_save(User $friend)
    {
        $message = ChatMessage::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $friend->id,
            'text' => request()->input('message')
        ]);

        $message = ChatMessage::with(['sender', 'receiver'])->where('id', $message->id)->first();
        broadcast(new MessageSent($message));

        return $message;
    }

    public function markAsRead($message)
    {
        $message = ChatMessage::find($message);
        $message->is_read = true;
        $message->save();

        // Broadcast the update to other users
        broadcast(new MessageRead($message, $message->sender_id, $message->receiver_id))->toOthers();

        return response()->json(['status' => 'success', 'message' => 'Message marked as read']);

    }
}
