<?php

namespace App\Http\Controllers;

use App\Enums\User\GenderUser;
use App\Enums\User\StatusUser;
use App\Enums\User\TypeUser;
use App\Http\Requests\UserRequest;
use App\Models\ConfigModel;
use App\Models\Departments;
use App\Models\Permission;
use App\Models\Position;
use App\Models\RolePermission;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $listAll = User::where(function ($query) use ($request) {
            if (!empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
                $query->orWhere('email', 'like', '%' . $request->name . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            // ->select('id', 'name', 'email')
            ->paginate($perPage);
        return view('pages.users.index', compact('listAll'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $positions = Position::select(['id', 'name'])->get();
        $departments = Departments::select(['id', 'name'])->get();
        $roles = Roles::select(['id', 'name'])->get();
        $users = User::select(['id', 'name', 'code'])->get();
        $typeUser = TypeUser::options();
        $statusUser = StatusUser::options();
        $genderUser = GenderUser::options();
        return view('pages.users.create', compact('positions', 'departments', 'roles', 'users', 'typeUser', 'statusUser', 'genderUser'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $password_default = ConfigModel::getSetting('password_default');
        User::create([
            'code' => self::genderUserCode(),
            'name' => $request->name,
            'password' => Hash::make($password_default),
            'position_id' => $request->position_id,
            'department_id' => $request->department_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'status' => $request->status,
            'type' => $request->type,
            'manager' => $request->manager,

            'bank_account' => $request->bank_account,
            'bank_branch' => $request->bank_branch,
            'bank' => $request->bank,
            'permanent_address' => $request->permanent_address,
            'current_address' => $request->current_address,
            'nation' => $request->nation,
            'nationality' => $request->nationality,
            'date_of_birth' => $request->date_of_birth,

            'place_of_issue' => $request->place_of_issue,
            'date_of_issue' => $request->date_of_issue,

            'start_date' => $request->start_date,
            'person_tax_code' => $request->person_tax_code,
            'identifier' => $request->identifier,
        ]);

        return redirect()->route('users.index')
            ->with(
                ['message' => Lang::get('messages.user-create_s'), 'status' => 'success']
            );
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
        return view('pages.users.show', compact('result', 'permission', 'permissionOld'));
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
        return view('pages.users.edit', compact('result', 'permission', 'permissionOld'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
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
            return redirect()->route('users.index')
                ->with(
                    ['message' => Lang::get('messages.role-update_s'), 'status' => 'success']
                );
        }
        return redirect()->route('users.index')
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
        return redirect()->route('users.index')
            ->with(
                ['message' => Lang::get('messages.role-delete_s'), 'status' => 'success']
            );
    }

    public function genderUserCode()
    {
        return 'CBNV' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
