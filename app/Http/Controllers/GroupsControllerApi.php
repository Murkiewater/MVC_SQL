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
        $search = strtolower($request->search ?? '');

        return response(
            Groups::query()
                ->where('name', 'ILIKE', ['%' . preg_replace('/\s+/', '%', strtolower($search)) . '%'])
                ->limit($request->perpage ?? 5)
                ->offset(($request->page ?? 0) * ($request->perpage ?? 5))
                ->get()
        );
    }

    public function total(Request $request)
    {
        return response(Groups::where('name', 'LIKE', '%'.$request->search.'%')
            ->count());
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
            ], 401);
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
        if (!Gate::allows('update-group')) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на редактирование группы',
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|max:255|unique:groups,name,'.$id,
            'image' => 'nullable|file|image|max:2048'
        ]);

        try {
            $group = Groups::findOrFail($id);
            $group->name = $validated['name'];

            if ($request->hasFile('image')) {
                try {
                    if ($group->picture_url) {
                        $base_url = Storage::disk('s3')->getClient()->getEndpoint();
                        $old_path = str_replace($base_url, '', $group->picture_url);
                        if (Storage::disk('s3')->exists($old_path)) {
                            Storage::disk('s3')->delete($old_path);
                        }
                    }
                    $file = $request->file('image');
                    $file_name = rand(1, 100000).'_'.$file->getClientOriginalName();
                    $path = Storage::disk('s3')->putFileAs('groups_pictures', $file, $file_name);
                    $group->picture_url = Storage::disk('s3')->url($path);
                } catch (Exception $err) {
                    return response()->json(['message' => 'Ошибка загрузки файла в S3: ',
                        'error' => ['code' => $err->getCode(), 'message' => $err->getMessage()]], 500);
                }
            }
            $group->save();
            return response()->json([
                'code' => 0,
                'message' => 'Группа успешно обновлена!',
            ]);
        } catch (\Exception $err) {
            return response()->json([
                'code' => 2,
                'message' => 'Ошибка при обновлении: '.$err->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Groups::find($id);

        if (!$group) {
            return response()->json(['code' => 1, 'error' => 'Группа не найдена']);
        }

        if (!Gate::allows('destroy-group', $group)) {
            return response()->json([
                'code' => 1,
                'message' => 'У вас нет прав на удаление группы',
            ], 401);
        }

        if ($group->posts()->exists()) {
            return response()->json([
                'code' => 1,
                'error' => 'Нельзя удалить группу - в ней есть посты'
            ]);
        }

        Groups::destroy($id);

        return response()->json([
            'code' => 0,
            'message' => 'Группа успешно удалена'
        ]);
    }
}
