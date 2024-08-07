<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::all()->map(function ($group) {
            $group->members = User::whereIn('email', $group->members)->get();
            return $group;
        });
        return response()->json($groups);
    }

    public function show($id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        // Fetch detailed user information if necessary
        $group->members = User::whereIn('email', $group->members)->get();

        return response()->json($group);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'members' => 'array',
            'members.*' => 'string|exists:users,email', // Validate each member ID exists
        ]);

        // Create the group with members
        $group = Group::create([
            'name' => $request->name,
            'members' => $request->members,
        ]);

        return response()->json($group, 201);
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'members' => 'array',
            'members.*' => 'string|exists:users,email',
        ]);

        $group->update($request->only(['name', 'members']));

        return response()->json($group);
    }

    public function destroy(Group $group)
    {
        $groupId = $group->id; // Get the ID of the group to be deleted
        $group->delete(); // Delete the group

        // Return a response with the deleted group ID
        return response()->json(['message' => 'Group deleted successfully.', 'groupId' => $groupId]);
    }
}
