<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function getContacts()
    {
        $contacts = User::where('id','!=',auth()->user()->id)->get();

        $unreadIds = Message::select(DB::raw('`from` as sender_id,count(`from`) as message_count'))
            ->where('to',auth()->id())
            ->where('read',false)
            ->groupBy('from')
            ->get();

        $contacts = $contacts->map(function ($contact) use ($unreadIds){

            $contactUnread =$unreadIds->where('sender_id',$contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->message_count : 0;

            return $contact;
        });

        return response()->json($contacts);
    }

    public function conversationWith($id)
    {
        Message::where('from',$id)->where('to',auth()->id())->update(['read'=>true]);

        $conversationWith = Message::where(function ($q) use($id){
            $q->where('from',auth()->user()->id);
            $q->where('to',$id);
        })->orWhere(function ($q) use($id){
            $q->where('from',$id);
            $q->where('to',auth()->user()->id);
        })->get();


        return response()->json($conversationWith);
    }

    public function send(Request $request){

       $message = Message::create([
            'from'=>auth()->user()->id,
            'to'=>$request['contact_id'],
            'text'=>$request['text']
        ]);

       broadcast(new NewMessage($message))->toOthers();

        return response()->json($message);
    }
}
