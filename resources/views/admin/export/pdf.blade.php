<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aspirasi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #1a1a2e;
        }

        .header h2 {
            font-size: 16px;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .header p {
            color: #666;
            font-size: 10px;
        }

        .info-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 10px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        thead th {
            background-color: #1a1a2e;
            color: #ffffff;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
        }

        tbody td {
            padding: 6px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 10px;
            vertical-align: top;
        }

        tbody tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .badge-menunggu {
            background-color: #ffc107;
            color: #000;
        }

        .badge-diproses {
            background-color: #0dcaf0;
            color: #000;
        }

        .badge-selesai {
            background-color: #198754;
            color: #fff;
        }

        .footer {
            margin-top: 16px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #888;
        }

        .summary {
            margin-top: 12px;
            padding: 8px 12px;
            background: #f0f4ff;
            border-left: 4px solid #1a1a2e;
            font-size: 10px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h2>Laporan Pengaduan Sarana Sekolah</h2>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    {{-- Ringkasan --}}
    <div class="summary">
        Total: {{ $data->count() }} pengaduan &nbsp;|&nbsp;
        Menunggu: {{ $data->where('status', 'Menunggu')->count() }} &nbsp;|&nbsp;
        Diproses: {{ $data->where('status', 'Diproses')->count() }} &nbsp;|&nbsp;
        Selesai: {{ $data->where('status', 'Selesai')->count() }}
    </div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="10%">NIS</th>
                <th width="7%">Kelas</th>
                <th width="12%">Kategori</th>
                <th width="12%">Lokasi</th>
                <th width="18%">Keterangan</th>
                <th width="9%">Status</th>
                <th width="18%">Feedback</th>
                <th width="10%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $d)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $d->nis }}</td>
                <td>{{ $d->siswa->kelas ?? '-' }}</td>
                <td>{{ $d->kategori->ket_kategori ?? '-' }}</td>
                <td>{{ $d->lokasi }}</td>
                <td>{{ $d->ket }}</td>
                <td>
                    @if($d->status == 'Menunggu')
                        <span class="badge badge-menunggu">Menunggu</span>
                    @elseif($d->status == 'Diproses')
                        <span class="badge badge-diproses">Diproses</span>
                    @else
                        <span class="badge badge-selesai">Selesai</span>
                    @endif
                </td>
                <td>{{ $d->feedback ?? '-' }}</td>
                <td>{{ $d->created_at->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center; padding: 20px; color: #888;">
                    Belum ada data pengaduan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        <span>Sistem Pengaduan Sarana Sekolah</span>
        <span>Total {{ $data->count() }} data</span>
    </div>

</body>
</html>