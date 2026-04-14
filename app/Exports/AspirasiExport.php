<?php

namespace App\Exports;

use App\Models\Aspirasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class AspirasiExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    public function collection()
    {
        return Aspirasi::with('kategori', 'siswa')->latest()->get();
    }

    public function title(): string
    {
        return 'Laporan Aspirasi';
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Kelas',
            'Kategori',
            'Lokasi',
            'Keterangan',
            'Status',
            'Feedback',
            'Tanggal Masuk'
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $row->nis,
            $row->siswa->kelas            ?? '-',
            $row->kategori->ket_kategori  ?? '-',
            $row->lokasi,
            $row->ket,
            $row->status,
            $row->feedback                ?? '-',
            $row->created_at->format('d/m/Y H:i')
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 10,
            'D' => 20,
            'E' => 20,
            'F' => 30,
            'G' => 12,
            'H' => 35,
            'I' => 18,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header (baris 1)
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1A1A2E'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Wrap text semua kolom
        $sheet->getStyle('A1:I1000')->applyFromArray([
            'alignment' => [
                'wrapText' => true,
                'vertical' => Alignment::VERTICAL_TOP,
            ],
        ]);

        // Tinggi baris header
        $sheet->getRowDimension(1)->setRowHeight(25);

        return [];
    }
}