<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user()->user;

        return $this->showPaginated(NotificationResource::collection($user->notifications()->orderBy('created_at', 'DESC')->paginate($request->limit)));
    }

    public function updateOne(Notification $notification)
    {
        try {
            $notification->view = 1;
            $notification->saveOrFail();
            return $this->showOne(new NotificationResource($notification));
        } catch (Exception $e) {
            return $e;
        }
    }

    public function updateAll()
    {
        try {
            Notification::where('user_id', Auth::user()->user->id)->where('view', 0)->update(['view' => 1]);
            return $this->successfulResponse();
        } catch (Exception $e) {
            return $e;
        }
    }
}
