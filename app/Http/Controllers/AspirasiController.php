<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index()
    {
        $data = Aspirasi::with('kategori')->latest()->get();
        return view('pengaduan.index', compact('data'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        $siswa    = Siswa::all();
        return view('siswa.form', compact('kategori', 'siswa'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nis'         => 'nullable|exists:siswas,nis', 
        'id_kategori' => 'required|exists:kategoris,id_kategori',
        'lokasi'      => 'required|max:50',
        'ket'         => 'required|max:50',
        'lampiran'    => 'nullable|file|max:5120|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx'
    ]);

    $lampiranPath = null;
    if ($request->hasFile('lampiran')) {
        $lampiranPath = $request->file('lampiran')
            ->store('lampiran', 'public');
    }

    Aspirasi::create([
        'nis'         => $request->nis ?: null, 
        'id_kategori' => $request->id_kategori,
        'lokasi'      => strip_tags($request->lokasi),
        'ket'         => strip_tags($request->ket),
        'status'      => 'Menunggu',
        'lampiran'    => $lampiranPath
    ]);

    return back()->with('success', 'Aspirasi berhasil dikirim');
}
    public function cekForm()
    {
        $siswa = Siswa::all();
        return view('siswa.cek', compact('siswa'));
    }

    public function cekStatus(Request $request)
    {
        $request->validate([
            'nis' => 'required'
        ]);

        $siswa = Siswa::all();

        $data = Aspirasi::with('kategori')
                ->where('nis', $request->nis)
                ->latest()
                ->get();

        // ← View yang benar
        return view('siswa.cek', compact('data', 'siswa'));
    }
}