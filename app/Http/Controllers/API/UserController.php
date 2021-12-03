<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Middleware\RoleNotEmployee;
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
        return resp(
            false,
            'Fungsi tidak ada.',
            '',
            404
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function my(Request $request)
    {
        $user = $request->user();
        return resp(
            true,
            'Berhasil mengambil data user.',
            $user,
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        return resp(
            true,
            'Berhasil mengambil seluruh data user.',
            User::all(),
            200
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return resp(
            false,
            'Fungsi tidak ada.',
            '',
            404
        );
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
        return resp(
            true,
            'Berhasil mengambil data user' . $id,
            User::find($id),
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return resp(
            false,
            'Fungsi tidak ada.',
            '',
            404
        );
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

        return resp(
            true,
            'Berhasil mengubah user ' . $user->name,
            $user,
            200
        );
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

        return resp(
            true,
            'Berhasil menghapus user ' . $user->name,
            $user,
            200
        );

    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender_id' => 'required'
        ]);

        $fields['department_id'] = 2;

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'department_id' => $fields['department_id'],
            'gender_id' => $fields['gender_id'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return resp(
            true,
            'Berhasil register user.',
            $user,
            201,
            $token
        );
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return resp(
                false,
                'Bad Creds',
                '',
                401
            );
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return resp(
            true,
            'Hi '.$user->name.', welcome to SIAPIMAI',
            '',
            200,
            $token
        );
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

        return resp(
            true,
            'Berhasil log out',
            'Berhasil',
            200
        );
    }
}
