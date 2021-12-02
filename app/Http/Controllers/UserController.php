<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response([
            'data' => User::all(),
            'message' => 'Berhasil mengambil seluruh data user',
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->register($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response([
            'data' => User::find($id),
            'message' => 'Berhasil mengambil data user' . $id,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response([
            'message' => 'Fungsi tidak ada.'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user){
            return response([
                'message' => 'Tidak menemukan data user.'
            ], 404);
        };
        $passwd = bcrypt($request->password);
        $request->merge(['password' => $passwd]);
        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response([
            'message' => 'Berhasil menghapus user ' . $user->name,
        ], 200);

    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'department_id' => 'required',
            'gender_id' => 'required'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'department_id' => $fields['department_id'],
            'gender_id' => $fields['gender_id'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'data' => $user,
            'access_token' => $token, 
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        $respond = [
            'message' => 'Hi '.$user->name.', welcome to SIAPIMAI',
            'access_token' => $token, 
            'token_type' => 'Bearer', 
        ];

        return response($respond, 200);
    }

    // method for user logout and delete token
    public function logout(Request $request)
    {
        /** 
         * @var \App\Models\User $user
         * 
        **/
        $user = Auth::user();
        $user->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }
}
