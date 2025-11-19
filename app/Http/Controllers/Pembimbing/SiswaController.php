<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kegiatan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::where('id_pembimbing', Auth::user()->id)->get();
        return view('pembimbing.lihatsiswa.index', compact('siswa'));
    }

    public function siswakegiatan($id){
        $siswaId = Siswa::where('id', $id)->where('id_pembimbing', Auth::user()->id)->firstOrFail();
        $siswa = Siswa::findOrFail($id);
        $kegiatans = Kegiatan::where('id_siswa', $id)->orderByDesc('tanggal_kegiatan')->get();
        return view('pembimbing.lihatsiswa.kegiatan', compact('kegiatans', 'siswa'));
    }

    public function siswaabsensi($id){
        $siswaId = Siswa::where('id', $id)->where('id_pembimbing', Auth::user()->id)->firstOrFail();
        $siswa = Siswa::findOrFail($id);
        $absensis = Absensi::where('id_siswa', $id)->orderByDesc('tanggal_absen')->get();
        return view('pembimbing.lihatsiswa.absensi', compact('absensis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
