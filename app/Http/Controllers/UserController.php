<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function login(Request $req){
        $validator = Validator::make($req->all(), [
            'username' => 'required|max:50',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $data = $validator->validated();
        $user = User::where('username', $data['username'])->first();
        
        if(!$user){
            return response()->json([
                'error' => 'Username or password was incorrect'
            ], 403);
        }

        if(!Hash::check($data['password'], $user['password'])){
            return response()->json([
                'error' => 'Username or password was incorrect'
            ], 403);
        }

        
        // generate token, create json response, set cookie to the response, and send it back
        $token = hash('md5', (Str::random(32))); 
        $response = new Response(['message' => 'Login successful!']);
        $response->withCookie(cookie('token', $token, 5000));

        $user['token'] = $token;
        if($user->save()){
            // update user profile and add token
            return $response;
        }

        return response()->json(['error' => 'Internal server error', 'message' => 'Something happened to the database :('], 500);
    }

    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json(['users' => $users], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|max:50',
            'password' => 'required',
            'privilage' => 'required|integer|in:0,1,2'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
            // Return a JSON response with validation errors and appropriate HTTP status code (422 Unprocessable Entity)
        }

        

        // Validation passed
        // Proceed with your logic for the validated data
        $data = $validator->validated();
        
        if(User::where('username', $data['username'])->first()){ 
            return response()->json(['error' => 'User already exists'], 403);
        }
        
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data); // save data to the database

        return response()->json(['user' => $user], 201);
    }

    public function show($id): JsonResponse
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'privilage' => 'required|integer|in:0,1,2',
            'token' => 'nullable'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        $user = User::find($id);
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }


        $validatedData = $validator->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);

        $user->update($validatedData);

        return response()->json(['user' => $user], 200);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::find($id);
        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User '. $user['username'] .' deleted successfully'], 200);
    }

    public function logout(Request $request){

        if (!$request->hasCookie('token')) {
            return response()->json(['error' => 'Token not found'], 404);
        }

        // retrieve token and find user from the database
        $token = $request->cookie('token');
        $user = User::where('token', $token)->first();

        if(!$user){
            return response()->json(['error' => 'User not found'], 404);
        }

        $user['token'] = null;

        if($user->save()){
            return response()->json(['message' => 'Logged out successfully!']);
        }
        return response()->json(['error' => 'Something happened'], 500);
    }
}
