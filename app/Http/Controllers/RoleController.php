<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $listAll = Roles::where(function ($query) use ($request) {
            if (!empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return view('pages.roles.index', compact('listAll'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permission = Permission::select(['id', 'name', 'display_name', 'parent', 'parent_name'])->get()->groupBy('parent_name')->toArray();
        return view('pages.roles.create', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $result = Roles::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $listPermission = json_decode($request->permission, true);
        if ($result) {
            foreach ($listPermission as $permission_uuid) {
                if (is_numeric($permission_uuid)) {
                    RolePermission::create([
                        'role_id' => $result->id,
                        'permission_id' => $permission_uuid,
                    ]);
                }
            }
            return redirect()->route('roles.index')
                ->with(
                    ['message' => Lang::get('messages.role-create_s'), 'status' => 'success']
                );
        }
        return redirect()->route('roles.index')->with((['status' => 'danger', 'message' => 'Có lỗi xảy ra!']));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $permission = Permission::select()->get()->groupBy('parent_name')->toArray();
        $result = Roles::find($id);
        $permissionOld = $result->getPermissionSingleton()->pluck('id')->toArray();
        return view('pages.roles.show', compact('result', 'permission', 'permissionOld'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $permission = Permission::select(['id', 'name', 'display_name', 'parent', 'parent_name'])->get()->groupBy('parent_name')->toArray();
        $result = Roles::find($id);
        $permissionOld = $result->getPermissionSingleton()->pluck('id')->toArray();
        return view('pages.roles.edit', compact('result', 'permission', 'permissionOld'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        //
        $result = Roles::find($id);
        $result->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Xóa tất cả RolePermission cũ
        RolePermission::where('role_id', $result->id)->delete();

        $listPermission = json_decode($request->permission, true);
        if ($result) {
            foreach ($listPermission as $permission_uuid) {
                if (is_numeric($permission_uuid)) {
                    RolePermission::create([
                        'role_id' => $result->id,
                        'permission_id' => $permission_uuid,
                    ]);
                }
            }
            return redirect()->route('roles.index')
                ->with(
                    ['message' => Lang::get('messages.role-update_s'), 'status' => 'success']
                );
        }
        return redirect()->route('roles.index')
            ->with(
                ['message' => Lang::get('messages.role-update_f'), 'status' => 'danger']
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $record = Roles::find($id);
        $record->delete();
        return redirect()->route('roles.index')
            ->with(
                ['message' => Lang::get('messages.role-delete_s'), 'status' => 'success']
            );
    }
}
