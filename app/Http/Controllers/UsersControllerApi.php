<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Users;

class UsersControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response(Users::limit($request->perpage ?? 5)
        ->offset(($request->perpage ?? 5) * ($request->page ?? 0))
        ->get());
    }

    public function total()
    {
        return response(Users::all()->count());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create-user')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на добавление пользователя',
            ]);
        }

        $validated = $request->validate([
            'full_name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'image' => 'required|file|image'
        ]);

        $file = $request->file('image');
        $file_name = rand(1, 100000).'_'.$file->getClientOriginalName();
        try {
            $path = Storage::disk('s3')->putFileAs('users_pictures', $file, $file_name);
            $file_url = Storage::disk('s3')->url($path);
        }
        catch (Exception $err) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка загрузки файла в хранилище S3',
            ]);
        };
        $user = new Users($validated);
        $user->picture_url = $file_url;
        $user->save();
        
        return response()->json([
            'code' => 0,
            'message' => 'Пользователь был успешно добавлен',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Users::find($id));
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
