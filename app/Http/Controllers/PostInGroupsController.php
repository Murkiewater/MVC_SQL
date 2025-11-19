<?php

namespace App\Http\Controllers;

use App\Models\PostInGroups;
use Illuminate\Http\Request;

class PostInGroupsController extends Controller
{
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 2;
        $posts = PostInGroups::with(['user','group'])
                  ->latest('date_of_post')
                  ->paginate($perpage)->withQueryString();

        return view('post_in_groups.index', compact('posts'));
    }

    public function create()
    {
        return view('post_in_groups.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'      => ['required','exists:users,id'],
            'group_id'     => ['required','exists:groups,id'],
            'text'         => ['required','string'],
            'date_of_post' => ['nullable','date'],
        ]);

        $data['date_of_post'] = $data['date_of_post'] ?? now();

        PostInGroups::create($data);

        return redirect()->route('post-in-groups.index')
            ->with('success', 'Пост создан');
    }

    public function edit(PostInGroups $postInGroup)
    {
        return view('post_in_groups.edit', compact('postInGroup'));
    }

    public function update(Request $request, PostInGroups $postInGroup)
    {
        $data = $request->validate([
            'user_id'      => ['required','exists:users,id'],
            'group_id'     => ['required','exists:groups,id'],
            'text'         => ['required','string'],
            'date_of_post' => ['nullable','date'],
        ]);

        $postInGroup->update($data);

        return redirect()->route('post-in-groups.index')
            ->with('success', 'Пост обновлён');
    }

    public function destroy(PostInGroups $postInGroup)
    {
        $postInGroup->delete();

        return redirect()->route('post-in-groups.index')
            ->with('success', 'Пост удалён');
    }
}