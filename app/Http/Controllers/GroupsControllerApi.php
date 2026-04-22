<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Groups;

class GroupsControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response(Groups::limit($request->perpage ?? 5)
        ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
        ->get());
    }

    public function total()
    {
        return response(Groups::all()->count());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create-group')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на добавление группы',
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|unique:groups|max:255',
            'image' => 'required|file'
        ]);

        $file = $request->file('image');
        $file_name = rand(1, 100000).'_'.$file->getClientOriginalName();
        try {
            $path = Storage::disk('s3')->putFileAs('groups_pictures', $file, $file_name);
            $file_url = Storage::disk('s3')->url($path);
        }
        catch (Exception $err) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка загрузки файла в хранилище S3',
            ]);
        };
        $group = new Groups($validated);
        $group->picture_url = $file_url;
        $group->save();

        return response()->json([
            'code' => 0,
            'message' => 'Группа была успешно добавлена',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Groups::find($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
