<?php

namespace App\Http\Controllers;

use App\Models\UserFollows;
use App\Models\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserFollowController extends Controller
{
    // GET /userfollows/{UserID} - Show user follow that a user have
    public function show($userID)
    {
        $userFollowRecords =  UserFollows::where([
            'UserID' => $userID,
            'Status' => 'Y'
        ])->get();

        if($userFollowRecords->isEmpty()){
            return response()->json(['message' => 'User Follows not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($userFollowRecords, Response::HTTP_OK);
    }

    // POST /userfollows
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'UserID' => 'required|string|max:255',
            'FollowerID' => 'required|string|max:255',
        ]);

        $userRecord = Users::find($validatedData['UserID']);
        $followerRecord = Users::find($validatedData['FollowerID']);

        if(!$userRecord || !$followerRecord) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $userFollowData = UserFollows::create([
            'UserID' => $validatedData['UserID'],
            'FollowerID' => $validatedData['FollowerID'],
            'Status' => 'Y',
            'CreateWho' => 'TEST_ADMIN',
            'ChangeWho' => 'TEST_ADMIN',
        ]);

        return response()->json($userFollowData, Response::HTTP_CREATED);
    }

    // DELETE /userfollows/{id}
    public function destroy($id)
    {
        $userFollowRecord = UserFollows::find($id);

        if(!$userFollowRecord){
            return response()->json(['message' => 'User Follow not found'], Response::HTTP_NOT_FOUND);
        }

        $userFollowRecord->delete();

        return response()->json(['message' => 'User Follow deleted successfully'], Response::HTTP_OK);
    }
}
