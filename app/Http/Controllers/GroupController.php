<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return Inertia::render('Group/Index', [
            'groups' => $groups,
            'user' => Auth::user()
        ]);
    }

    public function create()
    {
        return Inertia::render('Group/Create', ['user_id' => Auth::id()]);
    }

    public function store(Request $request)
    {
        $request->validateWithBag('createGroup', [
            'group_name' => ['required'],
        ]);

        $group = new Group;
        $group->group_name = $request->group_name;
        $group->group_description = $request->group_description;
        $group->host = $request->host;
        $group->save();

        return Redirect::route('group.index');
    }

    public function show(Group $group)
    {
        session(['currentGroup' => ['id' => $group->id, 'group_name' => $group->group_name]]);
        Inertia::share('currentGroup', ['id' => $group->id, 'group_name' => $group->group_name]);
        return Inertia::render('Group/Show', [
            'group' => $group, 
            'user' => Auth::user(), 
            'members' => $group->users()->pluck('name', 'users.id'), 
            'messages' => $group->messages
        ]);
    }

    public function edit(Group $group)
    {
        return Inertia::render('Group/Edit', ['group' => $group]);
    }

    public function update(Request $request, Group $group)
    {
        $request->validateWithBag('updateGroup', [
            'group_name' => ['required'],
        ]);

        $group->update([
            'group_name' => $request->group_name,
            'group_description' => $request->group_description,
            'host' => $request->host
        ]);

        return Redirect::route('group.index');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        return Redirect::route('group.index');  
    }

    public function join(Group $group)
    {
        $group->users()->syncWithoutDetaching(Auth::id());
        return Redirect::route('group.show', $group->id);
    }
    
    public function search(Request $request)
    {
        $searchString = $request->searchString;
        $groups = Group::where('group_name', 'like', '%'.$searchString.'%')->get();
        
        return response($groups, 200);  
    }
}
