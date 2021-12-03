<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attende;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendeController extends Controller
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
        $attende = Attende::where([
            'user_id' => $request->user()->id,
        ])->with(['user'])->get();
        return resp(
            true,
            'Berhasil mengambil seluruh data kehadiran.',
            $attende,
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
        if (User::with('department')
        ->find($request->user()->id)->department->slug === 'employee') {
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
            Attende::all(),
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
        $errors = [];
        $fields = $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'photo' => 'required',
        ]);

        $distance = getDistance($fields['latitude'], $fields['longitude']);
        if ($distance > 0.5) {
            return resp(
                false,
                'Lokasi tidak sesuai',
                [],
                400,
                "",
                [
                    'message' => "Sistem mendeteksi anda berada $distance km dari kantor"
                ]
            );
        }

        $masuk = format_batas(6, 9);
        $keluar = format_batas(17, 20);

        $fields['attend_time'] = Carbon::now();
        
        if ($masuk['start'] <= $fields['attend_time'] && $fields['attend_time'] <= $masuk['end']){
            $fields['attende_type_id'] = Attende::MASUK;
            $fields['attende_status_id'] = Attende::ON_TIME;
        }
        else if ($fields['attend_time'] >= $masuk['end'] && $fields['attend_time']  <= $keluar['start'] && $fields['attend_time']->toDateString() === $masuk['end']->toDateString()){
            $fields['attende_type_id'] = Attende::MASUK;
            $fields['attende_status_id'] = Attende::LATE;
        }
        else if ($keluar['start'] <= $fields['attend_time'] && $fields['attend_time'] <= $keluar['end']){
            $fields['attende_type_id'] = Attende::KELUAR;
            $fields['attende_status_id'] = Attende::ON_TIME;
        }
        else if ($fields['attend_time'] >= $keluar['end'] && $fields['attend_time']->toDateString() === $keluar['end']->toDateString()){
            $fields['attende_type_id'] = Attende::KELUAR;
            $fields['attende_status_id'] = Attende::LATE;
        }
        else{
            $fields['attende_status_id'] = Attende::STATUS_NOT_VALID;
            $fields['attende_type_id'] = Attende::TYPE_NOT_VALID;
            $errors = [
                'message' => 'Tidak dapat absen dil uar waktu.'
            ];
        }

        $fields['user_id'] = $request->user()->id;

        $attende = Attende::create($fields);

        return resp(
            true,
            'Berhasil record kehadiran.',
            $attende,
            201,
            "",
            $errors
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
            'Berhasil mengambil data kehadiran' . $id,
            Attende::find($id),
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
        $attende = Attende::find($id);
        if (!$attende){
            return resp(
                false,
                'Tidak menemukan data kehadiran.',
                '',
                404
            );
        };

        return resp(
            true,
            'Berhasil mengubah kehadiran.',
            $attende,
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
        $attende = Attende::find($id);
        $attende->delete();

        return resp(
            true,
            'Berhasil menghapus kehadiran.',
            $attende,
            200
        );
    }
}
