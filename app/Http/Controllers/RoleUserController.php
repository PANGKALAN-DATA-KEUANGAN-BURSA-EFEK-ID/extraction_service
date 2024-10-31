<?php

namespace App\Http\Controllers;

use App\Models\RoleUsers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleUserController extends Controller
{
    // GET /roleusers
    public function index()
    {
        return response()->json(RoleUsers::all(), Response::HTTP_OK);
    }

    // POST /roleusers
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'RoleUserName' => 'required|string|max:255'
        ]);

        $roleUserData = RoleUsers::create([
            'RoleUserName' => $validatedData['RoleUserName'],
            'Status' => 'Y',
            'CreateWho' => 'TEST_ADMIN',
            'ChangeWho' => 'TEST_ADMIN'
        ]);

        return response()->json($roleUserData, Response::HTTP_CREATED);
    }

    // GET /roleusers/{id}
    public function show($id)
    {
        $roleUserRecord = RoleUsers::find($id);

        if(!$roleUserRecord) {
            return response()->json(['message' => 'Role User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($roleUserRecord, Response::HTTP_OK);
    }

    // PUT /roleusers/{id}
    public function update(Request $request, $id)
    {
        $roleUserRecord = RoleUsers::find($id);

        if(!$roleUserRecord) {
            return response()->json(['message' => 'Role User not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'RoleUserName' => 'required|string|max:255'
        ]);

        $roleUserRecord->update([
            'RoleUserName' => $validatedData['RoleUserName'],
            'ChangeWho' => "TEST_ADMIN"
        ]);

        return response()->json($roleUserRecord, Response::HTTP_OK);
    }

    // DELETE /roleusers/{id}
    public function destroy($id)
    {
        $roleUserRecord = RoleUsers::find($id);

        if(!$roleUserRecord){
            return response()->json(['message' => 'Role User not found'], Response::HTTP_NOT_FOUND);
        }

        $roleUserRecord->delete();

        return response()->json(['message' => 'Role User deleted successfully'], Response::HTTP_OK);
    }
}
