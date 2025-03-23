<?php

namespace App\Http\Controllers;

use App\Enums\User\StatusGlobalEnum;
use App\Enums\User\StatusNotifyReadEnum;
use App\Http\Requests\DepartmentRequest;
use App\Models\Notifications;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class NotificationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $listAll = Notifications::where(function ($query) use ($request) {
            if (!empty($request->name)) {
                $query->where('title', 'like', '%' . $request->name . '%');
                $query->where('content', 'like', '%' . $request->name . '%');
                // $query->orWhere('code', 'like', '%' . $request->name . '%');
            }
            if (!empty($request->is_read)) {
                $query->where('is_read', $request->is_read);
            }
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $statusNotifyReadEnum = StatusNotifyReadEnum::options();
        return view('pages.notifications.index', compact(
            'listAll',
            'statusNotifyReadEnum'

        ));
    }

    public function listLimit(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $listAll = Notifications::where(function ($query) use ($request) {
            if (!empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
                // $query->orWhere('code', 'like', '%' . $request->name . '%');
            }
            if (!empty($request->status)) {
                $query->where('status', $request->status);
            }
        })
            ->orderBy('created_at', 'desc')
            ->limit($perPage)
            ->get();
        // ->paginate($perPage);
        return response()->json($listAll);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $record = Notifications::findOrFail($id);
        $record->delete();
        return redirect()->route('notifications.index')
            ->with(
                ['message' => Lang::get('messages.notification-delete_s'), 'status' => 'success']
            );
    }


    public function updateRead(string $id)
    {
        $record = Notifications::findOrFail($id);
        $user = Auth::user();
        if ($record->is_read === StatusNotifyReadEnum::READ->value) {
            $record->update([
                'is_read' => StatusNotifyReadEnum::UNREAD
            ]);

            $user->unread_notification = $user->unread_notification + 1 ?? 0;
            $user->save();
        } else {
            $record->update([
                'is_read' => StatusNotifyReadEnum::READ
            ]);

            if ($user && $user->unread_notification > 0) {
                $user->unread_notification = $user->unread_notification - 1;
                $user->save();
            }
        }

        return redirect()->route('notifications.index')
            ->with(
                ['message' => Lang::get('messages.notification-update_s'), 'status' => 'success']
            );
    }

    public function read(string $id)
    {
        $record = Notifications::findOrFail($id);
        $record->update([
            'is_read' => StatusNotifyReadEnum::READ
        ]);


        $user = Auth::user();
        if ($user && $user->unread_notification > 0) {
            $user->unread_notification = $user->unread_notification - 1;
            $user->save();
        }

        // return redirect()->route('notifications.index')
        //     ->with(
        //         ['message' => Lang::get('messages.notification-update_s'), 'status' => 'success']
        //     );
    }
}
