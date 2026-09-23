<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Inventaris Ruangan (KIR)</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 10pt; 
            margin: 10px;
        }
        h2 { 
            text-align: center; 
            margin-bottom: 5px; 
            text-transform: uppercase;
        }
        p.subtitle {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: bold;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 6px; 
            text-align: center; 
            vertical-align: middle;
            font-size: 9pt;
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>Daftar Inventaris Ruangan (KIR)</h2>
    @if(isset($kirs) && count($kirs) > 0)
        <p class="subtitle">Ruangan: {{ $kirs->first()->ruangan ?? 'Semua Ruangan' }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">Ruangan</th>
                <th width="22%">Nama / Jenis Barang</th>
                <th width="23%">Merk / Model</th>
                <th width="15%">No. Seri</th>
                <th width="8%">Bahan</th>
                <th width="5%">Tahun</th>
                <th width="10%">Kode Barang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kirs as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->ruangan ?? '-' }}</td>
                <td>{{ $item->jenis_barang ?? '-' }}</td>
                <td>{{ $item->merk_model ?? '-' }}</td>
                <td>{{ $item->no_seri ?? '-' }}</td>
                <td>{{ $item->bahan ?? '-' }}</td>
                <td>{{ $item->tahun_pembuatan ?? '-' }}</td>
                <td>{{ $item->no_kode_barang ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Data inventaris tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>