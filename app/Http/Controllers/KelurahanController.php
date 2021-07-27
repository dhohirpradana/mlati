<?php

namespace App\Http\Controllers;

use App\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelurahan = Kelurahan::find(1);
        return view('kelurahan.index', compact('kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kelurahan  $kelurahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kelurahan $kelurahan)
    {
        if (request()->ajax()) {
            $validator = Validator::make($request->all(), [
                'logo'   => ['required', 'image', 'max:2048']
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error'     => true,
                    'message'   => $validator->errors()->all()
                ]);
            }

            if ($kelurahan->logo != 'logo.png') {
                File::delete(storage_path('app/' . $kelurahan->logo));
            }

            $kelurahan->logo = $request->file('logo')->store('public/logo');
            $kelurahan->save();

            return response()->json([
                'error'     => false,
                'data'      => ['logo'   => $kelurahan->logo]
            ]);
        } else {
            $data = $request->validate([
                'nama_keurahan'             => ['required', 'max:64', 'string'],
                'nama_kecamatan'        => ['required', 'max:64', 'string'],
                'nama_kabupaten'        => ['required', 'max:64', 'string'],
                'alamat'                => ['required', 'string'],
                'nama_lurah'      => ['required', 'max:64', 'string'],
                'alamat_lurah'    => ['required', 'string']
            ]);

            if ($request->nama_kelurahan != $kelurahan->nama_kelurahan  || $request->nama_kecamatan != $kelurahan->nama_kecamatan || $request->nama_kabupaten != $kelurahan->nama_kabupaten || $request->alamat != $kelurahan->alamat || $request->nama_lurah != $kelurahan->nama_lurah || $request->alamat_lurah != $kelurahan->alamat_lurah) {
                $kelurahan->update($data);
                return redirect()->back()->with('success', 'Profil kelurahan berhasil di perbarui');
            } else {
                return redirect()->back()->with('error', 'Tidak ada perubahan yang berhasil disimpan');
            }
        }
    }
}
