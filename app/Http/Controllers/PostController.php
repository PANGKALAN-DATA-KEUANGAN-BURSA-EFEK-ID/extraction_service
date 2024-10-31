<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Posts;
use App\Models\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PostController extends Controller
{
    // GET /posts
    public function index()
    {
        return response()->json(Posts::all(), Response::HTTP_OK);
    }

    // POST /posts
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'UserID' => 'required|string|max:255',
            'PostText' => 'required|string|max:255',
            'PostType' => 'required|string|max:255',
        ]);

        $userData = Users::find($validatedData['UserID']);
        if(!$userData){
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $postData = Posts::create([
            'UserID' => $validatedData['UserID'],
            'PostText' => $validatedData['PostText'],
            'PostType' => $validatedData['PostType'],
            'Status' => 'Y',
            'CreateWho' => 'TEST_ADMIN',
            'ChangeWho' => 'TEST_ADMIN'
        ]);

        return response()->json($postData, Response::HTTP_CREATED);
    }

    // GET /posts/{id}
    public function show($id)
    {
        $postRecord = Posts::find($id);

        if(!$postRecord) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($postRecord, Response::HTTP_OK);
    }

    // GET /posts/user/{userID}
    public function showByUser($userID)
    {
        $postRecords =  Posts::where([
            'UserID' => $userID,
            'Status' => 'Y'
        ])->get();

        if($postRecords->isEmpty()){
            return response()->json(['message' => 'Posts not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($postRecords, Response::HTTP_OK);
    }

    // PUT /posts/{id}
    public function update(Request $request, $id)
    {
        $postRecord = Posts::find($id);

        if(!$postRecord) {
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'PostText' => 'required|string|max:255',
            'PostType' => 'required|string|max:255',
        ]);

        $postRecord->update([
            'PostText' => $validatedData['PostText'],
            'PostType' => $validatedData['PostType'],
            'ChangeWho' => "TEST_ADMIN"
        ]);

        return response()->json($postRecord, Response::HTTP_OK);
    }

    // DELETE /posts/{id}
    public function destroy($id)
    {
        $postRecord = Posts::find($id);

        if(!$postRecord){
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }
        
        Comments::where('UserPostID', $id)->delete();
        $postRecord->delete();

        return response()->json(['message' => 'Post deleted successfully'], Response::HTTP_OK);
    }
}
