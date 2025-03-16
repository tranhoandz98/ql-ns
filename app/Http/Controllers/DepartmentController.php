<?php

namespace App\Http\Controllers;

use App\Enums\User\StatusGlobalEnum;
use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\PositionRequest;
use App\Models\Departments;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class DepartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $listAll = Departments::where(function ($query) use ($request) {
            if (!empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
                // $query->orWhere('code', 'like', '%' . $request->name . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $users = User::select(['id', 'name', 'code'])->active()->get();
        $StatusGlobalEnum = StatusGlobalEnum::options();

        return view('pages.departments.index', compact(
            'listAll',
            'users',
            'StatusGlobalEnum'

        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::select(['id', 'name', 'code'])->active()->get();
        $StatusGlobalEnum = StatusGlobalEnum::options();

        return view(
            'pages.departments.create',
            compact(
                'users',
                'StatusGlobalEnum'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = Departments::create([
                'name' => $request->name,
                'description' => $request->description,
                'manager_id' => $request->manager_id,
                'founding_at' => !empty($request->founding_at) ? Carbon::createFromFormat('d/m/Y', $request->founding_at)->format('Y-m-d') : null,
                'status' => $request->status,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            DB::commit();

            return redirect()->route('departments.index')
                ->with(
                    ['message' => Lang::get('messages.department-create_s'), 'status' => 'success']
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
        $result = Departments::with(
            [
                'createdByData:id,name',
                'updatedByData:id,name',
            ]
        )->find($id);
        $StatusGlobalEnum = StatusGlobalEnum::options();
        $users = User::select(['id', 'name', 'code'])->active()->get();

        return view('pages.departments.show', compact(
            'result',
            'users',
            'StatusGlobalEnum'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

        $result = Departments::with(
            []
        )->find($id);
        $StatusGlobalEnum = StatusGlobalEnum::options();
        $users = User::select(['id', 'name', 'code'])->active()->get();

        return view('pages.departments.edit', compact(
            'result',
            'users',
            'StatusGlobalEnum'

        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, string $id)
    {

        DB::beginTransaction();
        try {
            $result = Departments::findOrFail($id);
            $result->update([
                'name' => $request->name,
                'description' => $request->description,
                'manager_id' => $request->manager_id,
                'founding_at' => !empty($request->founding_at) ? Carbon::createFromFormat('d/m/Y', $request->founding_at)->format('Y-m-d') : null,
                'status' => $request->status,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            DB::commit();
            return redirect()->route('departments.index')
                ->with(
                    ['message' => Lang::get('messages.department-update_s'), 'status' => 'success']
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
        $record = Departments::find($id);
        $record->delete();
        return redirect()->route('departments.index')
            ->with(
                ['message' => Lang::get('messages.department-delete_s'), 'status' => 'success']
            );
    }
}
