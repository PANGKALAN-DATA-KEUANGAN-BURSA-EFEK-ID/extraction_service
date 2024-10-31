<?php

namespace App\Http\Controllers;

use App\Models\UserFollows;
use App\Models\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // GET /users
    public function index()
    {
        return response()->json(Users::all(), Response::HTTP_OK);
    }

    // POST /users
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'RoleUserID' => 'required|string|max:255',
            'RoleUserName' => 'required|string|max:255',
            'SubscriptionPriceIdr' => 'required|numeric|min:0',
            'SubscriptionPercentage' => 'required|numeric|min:0',
            'FullName' => 'required|string|max:255',
            'Email' => 'required|email|unique:App\Models\Users',
            'Password' => 'required|string|min:6|max:50'
        ]);

        $userData = Users::create([
            'RoleUserID' => $validatedData['RoleUserID'],
            'RoleUserName' => $validatedData['RoleUserName'],
            'SubscriptionPriceIdr' => $validatedData['SubscriptionPriceIdr'],
            'SubscriptionPercentage' => $validatedData['SubscriptionPercentage'],
            'FullName' => $validatedData['FullName'],
            'Email' => $validatedData['Email'],
            'Password' => Hash::make($validatedData['Password']),
            'Status' => 'Y',
            'CreateWho' => 'TEST_ADMIN',
            'ChangeWho' => 'TEST_ADMIN'
        ]);

        return response()->json($userData, Response::HTTP_CREATED);
    }

    // GET /users/{id}
    public function show($id)
    {
        $userRecord = Users::find($id);

        if(!$userRecord) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($userRecord, Response::HTTP_OK);
    }

    // PUT /users/{id}
    public function update(Request $request, $id)
    {
        $userRecord = Users::find($id);

        if(!$userRecord) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'RoleUserID' => 'required|string|max:255',
            'RoleUserName' => 'required|string|max:255',
            'SubscriptionPriceIdr' => 'required|numeric|min:0',
            'SubscriptionPercentage' => 'required|numeric|min:0',
            'FullName' => 'required|string|max:255',
            'Email' => 'required|email',
            'Password' => 'string|min:6|max:50'
        ]);

        $userData = [
            'RoleUserID' => $validatedData['RoleUserID'],
            'RoleUserName' => $validatedData['RoleUserName'],
            'SubscriptionPriceIdr' => $validatedData['SubscriptionPriceIdr'],
            'SubscriptionPercentage' => $validatedData['SubscriptionPercentage'],
            'FullName' => $validatedData['FullName'],
            'Email' => $validatedData['Email'],
            'ChangeWho' => "TEST_ADMIN"
        ];

        if($validatedData['Password']){
            $userData['Password'] = Hash::make($validatedData['Password']);
        }

        $userRecord->update($userData);

        return response()->json($userRecord, Response::HTTP_OK);
    }

    // DELETE /users/{id}
    public function destroy($id)
    {
        $userRecord = Users::find($id);

        if(!$userRecord){
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $userRecord->delete();

        return response()->json(['message' => 'User deleted successfully'], Response::HTTP_OK);
    }
}
