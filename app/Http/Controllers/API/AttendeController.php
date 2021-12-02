<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attende;
use Illuminate\Http\Request;

class AttendeController extends Controller
{

    const ON_TIME = 1;
    const LATE = 2;
    const ABSENT = 3;

    const MASUK = 1;
    const KELUAR = 2;
    const NOT_VALID = 3;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return resp(
            true,
            'Berhasil mengambil seluruh data kehadiran',
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

        $fields['attend_time'] = now();

        if ($masuk['start'] <= $fields['attend_time'] && $fields['attend_time'] <= $masuk['end']){
            $fields['attende_type_id'] = self::MASUK;
            $fields['attende_status_id'] = self::ON_TIME;
        }
        else if ($fields['attend_time'] >= $masuk['end']){
            $fields['attende_type_id'] = self::MASUK;
            $fields['attende_status_id'] = self::LATE;
        }
        else if ($keluar['start'] <= $fields['attend_time'] && $fields['attend_time'] <= $keluar['end']){
            $fields['attende_type_id'] = self::KELUAR;
            $fields['attende_status_id'] = self::ON_TIME;
        }
        else if ($fields['attend_time'] >= $keluar['end']){
            $fields['attende_type_id'] = self::KELUAR;
            $fields['attende_status_id'] = self::LATE;
        }
        else{
            $fields['attende_type_id'] = self::NOT_VALID;
            $errors = [
                'message' => 'Tidak dapat absen dil uar waktu.'
            ];
        }

        $attende = Attende::create([
            'user_id' => $request->user()->id,
            'attende_type_id' => $fields['attende_type_id'],
            'attende_status_id' => $fields['attende_status_id'],
            'attend_time' => $fields['attend_time'],
            'latitude' => $fields['latitude'],
            'longitude' => $fields['longitude'],
            'photo' => $fields['photo'],
        ]);

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
