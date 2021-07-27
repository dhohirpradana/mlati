<?php

namespace App\Http\Controllers;

use App\Kelurahan;
use App\PemerintahanKelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PemerintahanKelurahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pemerintahan_kelurahan = PemerintahanKelurahan::orderBy('id', 'desc')->paginate(12);

        if ($request->cari) {
            $pemerintahan_kelurahan = PemerintahanKelurahan::where('judul', 'like', "%{$request->cari}%")
                ->orWhere('konten', 'like', "%{$request->cari}%")
                ->orderBy('id', 'desc')->paginate(15);
        }

        $pemerintahan_kelurahan->appends($request->only('cari'));
        return view('pemerintahan-kelurahan.index', compact('pemerintahan_kelurahan'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pemerintahan_kelurahan(Request $request)
    {
        $pemerintahan_kelurahan = PemerintahanKelurahan::orderBy('id', 'desc')->paginate(12);
        $kelurahan = Kelurahan::find(1);

        if ($request->cari) {
            $pemerintahan_kelurahan = PemerintahanKelurahan::where('judul', 'like', "%{$request->cari}%")
                ->orWhere('konten', 'like', "%{$request->cari}%")
                ->orderBy('id', 'desc')->paginate(12);
        }

        $pemerintahan_kelurahan->appends($request->only('cari'));
        return view('pemerintahan-kelurahan.pemerintahan-kelurahan', compact('pemerintahan_kelurahan', 'kelurahan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pemerintahan-kelurahan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => ['required', 'string', 'max:191'],
            'konten'    => ['required'],
            'gambar'    => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->gambar) {
            $data['gambar'] = $request->gambar->store('public/gallery');
        }

        PemerintahanKelurahan::create($data);

        return redirect()->route('pemerintahan-kelurahan.index')->with('success', 'Informasi pemerintahan kelurahan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PemerintahanKelurahan  $pemerintahan_kelurahan
     * @return \Illuminate\Http\Response
     */
    public function show(PemerintahanKelurahan $pemerintahan_kelurahan, $slug)
    {
        $kelurahan = Kelurahan::find(1);
        $pemerintahan_kelurahans = PemerintahanKelurahan::where('id', '!=', $pemerintahan_kelurahan->id)->inRandomOrder()->limit(3)->get();
        if ($slug != Str::slug($pemerintahan_kelurahan->judul)) {
            return abort(404);
        }
        $pemerintahan_kelurahan->update(['dilihat' => $pemerintahan_kelurahan->dilihat + 1]);
        return view('pemerintahan-kelurahan.show', compact('pemerintahan_kelurahan', 'kelurahan', 'pemerintahan_kelurahans'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PemerintahanKelurahan  $pemerintahan_kelurahan
     * @return \Illuminate\Http\Response
     */
    public function edit(PemerintahanKelurahan $pemerintahan_kelurahan)
    {
        return view('pemerintahan-kelurahan.edit', compact('pemerintahan_kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PemerintahanKelurahan  $pemerintahan_kelurahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PemerintahanKelurahan $pemerintahan_kelurahan)
    {
        $data = $request->validate([
            'judul'     => ['required', 'string', 'max:191'],
            'konten'    => ['required'],
            'gambar'    => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->gambar) {
            if ($pemerintahan_kelurahan->gambar) {
                File::delete(storage_path('app/' . $pemerintahan_kelurahan->gambar));
            }
            $data['gambar'] = $request->gambar->store('public/gallery');
        }

        $pemerintahan_kelurahan->update($data);

        return back()->with('success', 'Informasi pemerintahan kelurahan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PemerintahanKelurahan  $pemerintahan_kelurahan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PemerintahanKelurahan $pemerintahan_kelurahan)
    {
        $pemerintahan_kelurahan->delete();
        return back()->with('success', 'Informasi pemerintahan kelurahan berhasil dihapus');
    }
}
