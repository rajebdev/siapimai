<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return resp(
            true,
            'Berhasil mengambil seluruh data izin.',
            Permission::all(),
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
        if ($request->user()::with('department')
        ->first()->department->slug === 'employee') {
            return resp(
                false,
                'Pelanggaran',
                [],
                403,
                0,
                [
                    'message' => 'Anda tidak memiliki izin untuk mengakses bagian ini!'
                ]
            );
        }
        return resp(
            true,
            'Berhasil mengambil seluruh data izin.',
            Permission::all(),
            200
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        if ($request->user()::with('department')
        ->first()->department->slug === 'employee') {
            return resp(
                false,
                'Pelanggaran',
                [],
                403,
                0,
                [
                    'message' => 'Anda tidak memiliki izin untuk mengakses bagian ini!'
                ]
            );
        }

        $fields = $request->validate([
            'id' => 'required',
            'is_approved' => 'required',
        ]);

        $fields['permission_status_id'] = $request->is_approved ? Permission::APPROVED : Permission::REJECTED;

        $permission = Permission::find($request->id);

        $permission->update($fields);
        
        return resp(
            true,
            'Sukses mengubah status izin!',
            $permission,
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
        $fields = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'permission_type_id' => 'required',
            'photo' => 'required',
            'start_date' => 'required',
            'due_date' => 'required',
            'file_name' => 'required',
        ]);
        $fields['user_id'] = $request->user()->id;
        $fields['permission_status_id'] = Permission::PENDING;

        $permission_active = Permission::whereDate('start_date', Carbon::parse($request->start_date))
            ->where('user_id', $request->user()->id)
            ->whereIn('permission_status_id', [Permission::APPROVED, Permission::PENDING])
            ->get()->first();

        if ($permission_active){
            return resp(
                false,
                'Gagal',
                [],
                400,
                0,
                [
                    'message' => 'Izin sudah diajukan tertanggal ' . now()->translatedFormat('l, d F Y')
                ]
            );
        }
        
        $permission = Permission::create($fields);

        return resp(
            true,
            'Berhasil record Izin.',
            $permission,
            201,
            ""
        );

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
            'Berhasil mengambil data izin' . $id,
            Permission::find($id),
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
        $permission = Permission::find($id);
        if (!$permission){
            return resp(
                false,
                'Tidak menemukan data Izin.',
                '',
                404
            );
        };

        return resp(
            true,
            'Berhasil mengubah Izin.',
            $permission,
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
        $permission = Permission::find($id);
        $permission->delete();

        return resp(
            true,
            'Berhasil menghapus Izin.',
            $permission,
            200
        );
    }
}
