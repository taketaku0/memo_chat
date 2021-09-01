<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all();
        return Inertia::render('Group/index', ['groups' => $groups]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Group $group)
    {
        //  
    }

    public function edit(Group $group)
    {
        //
    }

    public function update(Request $request, Group $group)
    {
        //
    }

    public function destroy(Group $group)
    {
        // 
    }
}
