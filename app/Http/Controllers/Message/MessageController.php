<?php

namespace App\Http\Controllers\Message;

use App\Events\ChatEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageRequest;
use App\Http\Resources\Message\ConversationResource;
use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\Message\NewMessageResource;
use App\Models\Conversation;
use App\Models\People;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user()->user;
        $response = Conversation::where(function ($query) use ($user) {
            return $query->where('from_id', $user->id)->orWhere('to_id', $user->id);
        });

        return $this->showAll(ConversationResource::collection($response->orderBy('updated_at', 'DESC')->get()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  People $people
     * @return \Illuminate\Http\Response
     */
    public function storeConversation(People $people)
    {
        try {
            $user = Auth::user()->user;
            $conversation = Conversation::where('from_id', $user->id)->where('to_id', $people->user->id)->orWhere(function ($query) use ($people, $user) {
                return $query->where('from_id', $people->user->id)->where('to_id', $user->id);
            })->first();

            if (!$conversation) {
                $conversation = $user->fromMessages()->firstOrCreate(['to_id' => $people->user->id]);
            }
            return $this->showOne(new ConversationResource($conversation));
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\MessageRequest  $request
     * @param  Conversation $conversation
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request, Conversation $conversation)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user()->user;
            $request['send_id'] = $user->id;
            $message = $conversation->messages()->create($request->only('message', 'type', 'send_id'));
            $conversation->view = 1;
            $conversation->updated_at = new Carbon();
            $conversation->saveOrFail();
            DB::commit();
            event(new ChatEvent(['message' => $message, 'conversation' => $conversation, 'to' => $conversation->to_id == $user->id ? $conversation->from_id : $conversation->to_id]));

            return $this->showOne(new NewMessageResource($message));
        } catch (Exception $e) {
            DB::rollback();
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation, Request $request)
    {
        return $this->showPaginated(MessageResource::collection($conversation->messages()->orderBy('id', 'DESC')->paginate($request->limit)->reverse()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
