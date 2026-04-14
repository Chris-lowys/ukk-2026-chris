<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AspirasiExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function excel(){
        return Excel::download(new AspirasiExport, 'laporan-aspirasi.xlsx');
    }

    public function pdf(){
        $data = Aspirasi::with('kategori', 'siswa')->latest()->get();
        $pdf  = Pdf::loadView('admin.export.pdf', compact('data'))
                   ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-aspirasi.pdf');
    }
}