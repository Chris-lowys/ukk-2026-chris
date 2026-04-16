<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Aspirasi;
use App\Models\Kategori;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    // ==================== AUTH ====================

    public function login(){
        return view('admin.login');
    }

    public function cekLogin(Request $request){
        $admin = Admin::where('username', $request->username)->first();
        if($admin && Hash::check($request->password, $admin->password)){
            session(['admin' => $admin->id]);
            return redirect()->route('admin.dashboard');
        }
        return back()->with('error', 'Username atau password salah');
    }

    public function logout(){
        session()->flush();
        return redirect()->route('admin.login');
    }

    public function aksesRahasia(Request $request){
    // Kode akses rahasia — simpan di .env agar lebih aman
    $kodeBenar = env('ADMIN_ACCESS_CODE', 'smkn1buntok2025');

    if ($request->kode === $kodeBenar) {
        return response()->json(['status' => 'ok']);
    }

    return response()->json(['status' => 'gagal'], 403);
    }

    // ==================== DASHBOARD ====================

    public function dashboard(Request $request)
    {
    // ===== FILTER & PENCARIAN =====
    $query = Aspirasi::with('kategori', 'siswa')->latest();

    // Filter status
    if($request->filled('status')){
        $query->where('status', $request->status);
    }

    // Filter kategori
    if($request->filled('id_kategori')){
        $query->where('id_kategori', $request->id_kategori);
    }

    // Pencarian by NIS atau keterangan
    if($request->filled('search')){
        $search = $request->search;
        $query->where(function($q) use ($search){
            $q->where('nis', 'like', "%{$search}%")
              ->orWhere('lokasi', 'like', "%{$search}%")
              ->orWhere('ket', 'like', "%{$search}%");
        });
    }

    $data = $query->get();

    // ===== STATISTIK (selalu dari semua data, bukan hasil filter) =====
    $semua    = Aspirasi::all();
    $total    = $semua->count();
    $menunggu = $semua->where('status', 'Menunggu')->count();
    $proses   = $semua->where('status', 'Diproses')->count();
    $selesai  = $semua->where('status', 'Selesai')->count();

    // ===== DATA FILTER untuk dropdown =====
    $kategoriList = Kategori::all();

    // ===== GRAFIK =====
    $perBulan = Aspirasi::selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, COUNT(*) as total')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun')
        ->orderBy('bulan')
        ->get();

    $labelBulan = $perBulan->map(function($item){
        return \Carbon\Carbon::create($item->tahun, $item->bulan)->translatedFormat('M Y');
    });
    $dataBulan = $perBulan->pluck('total');

    $perKategori   = Aspirasi::selectRaw('id_kategori, COUNT(*) as total')
        ->with('kategori')
        ->groupBy('id_kategori')
        ->get();
    $labelKategori = $perKategori->map(fn($item) => $item->kategori->ket_kategori ?? 'Lainnya');
    $dataKategori  = $perKategori->pluck('total');

    return view('admin.dashboard', compact(
        'data', 'kategoriList',
        'total', 'menunggu', 'proses', 'selesai',
        'labelBulan', 'dataBulan',
        'labelKategori', 'dataKategori'
    ));
    }
    // ==================== ASPIRASI ====================

    public function showAspirasi($id){
        $aspirasi = Aspirasi::with('kategori', 'siswa')->findOrFail($id);
        return view('admin.aspirasi_detail', compact('aspirasi'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'status'   => 'required|in:Menunggu,Diproses,Selesai',
            'feedback' => 'nullable|max:255'
        ]);

        Aspirasi::where('id_aspirasi', $id)->update([
            'status'   => $request->status,
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Status aspirasi berhasil diperbarui');
    }

    public function destroyAspirasi($id){
    $aspirasi = Aspirasi::where('id_aspirasi', $id)->firstOrFail();
    
    // Hapus file lampiran jika ada
    if($aspirasi->lampiran){
        Storage::disk('public')->delete($aspirasi->lampiran);
    }
    
    // Hapus data dari database
    $aspirasi->delete();
    
    // Redirect ke dashboard, bukan back()
    return redirect()->route('admin.dashboard')
                     ->with('success', 'Aspirasi berhasil dihapus');
    }
    // ==================== KATEGORI ====================

    public function kategori(){
        $kategori = Kategori::all();
        return view('admin.kategori', compact('kategori'));
    }

    public function storeKategori(Request $request){
        $request->validate([
            'ket_kategori' => 'required|max:30|unique:kategoris,ket_kategori'
        ]);

        Kategori::create(['ket_kategori' => $request->ket_kategori]);
        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function updateKategori(Request $request, $id){
        $request->validate([
            'ket_kategori' => 'required|max:30|unique:kategoris,ket_kategori,' . $id . ',id_kategori'
        ]);

        Kategori::where('id_kategori', $id)->update([
            'ket_kategori' => $request->ket_kategori
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroyKategori($id){
        // Cek apakah kategori masih dipakai
        $used = Aspirasi::where('id_kategori', $id)->exists();
        if($used){
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan');
        }

        Kategori::where('id_kategori', $id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }

    // ==================== SISWA ====================

    public function siswa(){
        $siswa = Siswa::all();
        return view('admin.siswa', compact('siswa'));
    }

    public function storeSiswa(Request $request){
        $request->validate([
            'nis'   => 'required|unique:siswas,nis',
            'kelas' => 'required|max:10'
        ]);

        Siswa::create([
            'nis'   => $request->nis,
            'kelas' => $request->kelas
        ]);

        return back()->with('success', 'Siswa berhasil ditambahkan');
    }

    public function updateSiswa(Request $request, $nis){
        $request->validate([
            'kelas' => 'required|max:10'
        ]);

        Siswa::where('nis', $nis)->update([
            'kelas' => $request->kelas
        ]);

        return back()->with('success', 'Data siswa berhasil diperbarui');
    }

    public function destroySiswa($nis){
        // Cek apakah siswa masih punya aspirasi
        $used = Aspirasi::where('nis', $nis)->exists();
        if($used){
            return back()->with('error', 'Data siswa tidak bisa dihapus karena masih memiliki aspirasi');
        }

        Siswa::where('nis', $nis)->delete();
        return back()->with('success', 'Data siswa berhasil dihapus');
    }

    // ===== LAMPIRAN =====

public function uploadLampiran(Request $request, $id){
    $request->validate([
        'lampiran' => 'required|file|max:5120'
    ]);

    $aspirasi = Aspirasi::where('id_aspirasi', $id)->firstOrFail();

    // Hapus lampiran lama jika ada
    if($aspirasi->lampiran){
        Storage::disk('public')->delete($aspirasi->lampiran);
    }

    $path = $request->file('lampiran')->store('lampiran', 'public');

    $aspirasi->update(['lampiran' => $path]);

    return back()->with('success', 'Lampiran berhasil diupload');
}

public function hapusLampiran($id){
    $aspirasi = Aspirasi::where('id_aspirasi', $id)->firstOrFail();

    if($aspirasi->lampiran){
        Storage::disk('public')->delete($aspirasi->lampiran);
        $aspirasi->update(['lampiran' => null]);
    }

    return back()->with('success', 'Lampiran berhasil dihapus');
} 

}