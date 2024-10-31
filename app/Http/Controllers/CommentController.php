<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Posts;
use App\Models\Comments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    // GET /comments
    public function index()
    {
        return response()->json(Comments::all(), Response::HTTP_OK);
    }

    // POST /comments
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'UserID' => 'required|string|max:255',
            'UserPostID' => 'required|string|max:255',
            'ReplyText' => 'required|string|max:255',
        ]);

        $userData = Users::find($validatedData['UserID']);
        if(!$userData){
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $postData = Posts::find($validatedData['UserPostID']);
        if(!$postData){
            return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
        }

        $commentData = Comments::create([
            'UserID' => $validatedData['UserID'],
            'UserPostID' => $validatedData['UserPostID'],
            'ReplyText' => $validatedData['ReplyText'],
            'Status' => 'Y',
            'CreateWho' => 'TEST_ADMIN',
            'ChangeWho' => 'TEST_ADMIN'
        ]);

        return response()->json($commentData, Response::HTTP_CREATED);
    }

    // GET /comments/{id}
    public function show($id)
    {
        $commentRecord = Comments::find($id);

        if(!$commentRecord) {
            return response()->json(['message' => 'Comment not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($commentRecord, Response::HTTP_OK);
    }

    // GET /comments/post/{userPostID}
    public function showByPost($userPostID)
    {
        $commentRecords =  Comments::where([
            'UserPostID' => $userPostID,
            'Status' => 'Y'
        ])->get();

        if($commentRecords->isEmpty()){
            return response()->json(['message' => 'Comments not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($commentRecords, Response::HTTP_OK);
    }

    // PUT /comments/{id}
    public function update(Request $request, $id)
    {
        $commentRecord = Comments::find($id);

        if(!$commentRecord) {
            return response()->json(['message' => 'Comment not found'], Response::HTTP_NOT_FOUND);
        }

        $validatedData = $request->validate([
            'ReplyText' => 'required|string|max:255',
        ]);

        $commentRecord->update([
            'ReplyText' => $validatedData['ReplyText'],
            'ChangeWho' => "TEST_ADMIN"
        ]);

        return response()->json($commentRecord, Response::HTTP_OK);
    }

    // DELETE /comments/{id}
    public function destroy($id)
    {
        $commentRecord = Comments::find($id);

        if(!$commentRecord){
            return response()->json(['message' => 'Comment not found'], Response::HTTP_NOT_FOUND);
        }
        
        $commentRecord->delete();

        return response()->json(['message' => 'Comment deleted successfully'], Response::HTTP_OK);
    }}
