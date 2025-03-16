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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $listAll = User::with(
            [
                'position:id,name',
                'department:id,name',
                'manager:id,name',
                'role:id,name',
            ]
        )
            ->where(function ($query) use ($request) {
                if (!empty($request->name)) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                    $query->orWhere('email', 'like', '%' . $request->name . '%');
                    $query->orWhere('code', 'like', '%' . $request->name . '%');
                }
                if (!empty($request->role_id)) {
                    $query->where('role_id', $request->role_id);
                }
                if (!empty($request->type)) {
                    $query->where('type', $request->type);
                }
                if (!empty($request->status)) {
                    $query->where('status', $request->status);
                }
                if (!empty($request->department_id)) {
                    $query->where('department_id', $request->department_id);
                }
                if (!empty($request->position_id)) {
                    $query->where('position_id', $request->position_id);
                }
                if (!empty($request->manager_id)) {
                    $query->where('manager_id', $request->manager_id);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $positions = Position::select(['id', 'name'])->get();
        $departments = Departments::select(['id', 'name'])->get();
        $roles = Roles::select(['id', 'name'])->get();
        $users = User::select(['id', 'name', 'code','status'])->get();
        $typeUser = TypeUser::options();
        $statusUser = StatusUser::options();
        $genderUser = GenderUser::options();

        return view('pages.users.index', compact(
            'listAll',
            'positions',
            'departments',
            'roles',
            'users',
            'typeUser',
            'statusUser',
            'genderUser'
        ));
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
        $users = User::select(['id', 'name', 'code','status'])->active()->get();
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
        DB::beginTransaction();
        try {
            $password_default = ConfigModel::getSetting('password_default');
            $result = User::create([
                'code' => self::genderUserCode(),
                'name' => $request->name,
                'password' => Hash::make($password_default),
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => $request->status,
                'type' => $request->type,
                'manager_id' => $request->manager_id,
                'role_id' => $request->role_id,

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


            if ($request->hasFile('fileAvatar')) {
                $imagePath = $request->file('fileAvatar')->store('uploads', 'public');

                $result->update([
                    'avatar' => $imagePath,
                    'face_descriptor' => $request->face_descriptor,
                ]);
            }
            DB::commit();

            return redirect()->route('users.index')
                ->with(
                    ['message' => Lang::get('messages.user-create_s'), 'status' => 'success']
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $result = User::with(
            [
                'position:id,name',
                'department:id,name',
                'manager:id,name',
            ]
        )->find($id);
        $positions = Position::select(['id', 'name'])->get();
        $departments = Departments::select(['id', 'name'])->get();
        $roles = Roles::select(['id', 'name'])->get();
        $users = User::select(['id', 'name', 'code','status'])->get();
        $typeUser = TypeUser::options();
        $statusUser = StatusUser::options();
        $genderUser = GenderUser::options();
        return view('pages.users.show', compact(
            'result',
            'positions',
            'departments',
            'roles',
            'users',
            'typeUser',
            'statusUser',
            'genderUser'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $result = User::with(
            [
                'position:id,name',
                'department:id,name',
                'manager:id,name',
            ]
        )->find($id);
        $positions = Position::select(['id', 'name'])->get();
        $departments = Departments::select(['id', 'name'])->get();
        $roles = Roles::select(['id', 'name'])->get();
        $users = User::select(['id', 'name', 'code','status'])->active()->get();
        $typeUser = TypeUser::options();
        $statusUser = StatusUser::options();
        $genderUser = GenderUser::options();
        return view('pages.users.edit', compact(
            'result',
            'positions',
            'departments',
            'roles',
            'users',
            'typeUser',
            'statusUser',
            'genderUser'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {

        DB::beginTransaction();
        try {
            $result = User::findOrFail($id);
            $result->update([
                'name' => $request->name,
                'position_id' => $request->position_id,
                'department_id' => $request->department_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => $request->status,
                'type' => $request->type,
                'manager_id' => $request->manager_id,
                'role_id' => $request->role_id,

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

            if (empty($request->avatar) && !$request->hasFile('fileAvatar')) {
                $result->update([
                    'avatar' => null,
                    'face_descriptor' => null,
                ]);
            }
            if ($request->hasFile('fileAvatar')) {
                if ($result->avatar) {
                    Storage::delete('public/' . $result->avatar);
                }

                $imagePath = $request->file('fileAvatar')->store('uploads', 'public');

                $result->update([
                    'avatar' => $imagePath,
                    'face_descriptor' => $request->face_descriptor,
                ]);
            }
            if ($result->isDirty('email')) {
                $result->update([
                    'email_verified_at' => null,
                ]);
            }
            DB::commit();
            return redirect()->route('users.index')
                ->with(
                    ['message' => Lang::get('messages.user-update_s'), 'status' => 'success']
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $record = User::find($id);
        $record->delete();
        return redirect()->route('users.index')
            ->with(
                ['message' => Lang::get('messages.user-delete_s'), 'status' => 'success']
            );
    }

    public function genderUserCode()
    {
        return 'CBNV' . str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
