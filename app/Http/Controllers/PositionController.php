<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class PositionController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $listAll = Position::where(function ($query) use ($request) {
            if (!empty($request->name)) {
                $query->where('name', 'like', '%' . $request->name . '%');
                // $query->orWhere('code', 'like', '%' . $request->name . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);


        return view('pages.positions.index', compact(
            'listAll',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PositionRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = Position::create([
                // 'code' => self::GenderUserEnumCode(),
                'name' => $request->name,
                'description' => $request->description,
            ]);
            DB::commit();

            return redirect()->route('positions.index')
                ->with(
                    ['message' => Lang::get('messages.position-create_s'), 'status' => 'success']
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
        $result = Position::with(
            [
                'createdByData:id,name',
                'updatedByData:id,name',
            ]
        )->find($id);

        return view('pages.positions.show', compact(
            'result',

        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $result = Position::with(
            []
        )->find($id);

        return view('pages.positions.edit', compact(
            'result',

        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PositionRequest $request, string $id)
    {

        DB::beginTransaction();
        try {
            $result = Position::findOrFail($id);
            $result->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
            DB::commit();
            return redirect()->route('positions.index')
                ->with(
                    ['message' => Lang::get('messages.position-update_s'), 'status' => 'success']
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
        $record = Position::findOrFail($id);
        $checkUse = false;

        $user = User::where('position_id', $record->id)->first();
        if ($user) {
            $checkUse = true;
        }

        if ($checkUse || !$record) {
            return redirect()->route('positions.index')
                ->with(['message' => Lang::get('messages.position-cc1'), 'status' => 'error']);
        }

        $record->delete();
        return redirect()->route('positions.index')
            ->with(
                ['message' => Lang::get('messages.position-delete_s'), 'status' => 'success']
            );
    }
}
