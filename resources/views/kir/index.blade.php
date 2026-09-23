@extends('layouts.app') {{-- Sesuaikan dengan nama file layout utama proyek Anda --}}

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manajemen Kartu Inventaris Ruangan (KIR)</h2>
        <a href="{{ route('kir.export-pdf', 'Sekretariat') }}" class="btn btn-danger" target="_blank">
            <i class="bi bi-file-earmark-pdf"></i> Download PDF Inventaris
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Panel Kiri: Form Upload File Excel KIR -->
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Import Data Inventaris Excel</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Unggah file Excel (seperti <code>Sekretariat.xlsx</code>) untuk memasukkan atau memperbarui data barang inventaris ruangan ke database.</p>
                    
                    <form action="{{ route('kir.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Excel (.xlsx / .xls / .csv)</label>
                            <input type="file" name="file" id="file" class="form-control" required accept=".xlsx, .xls, .csv">
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload"></i> Unggah File Excel
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Panel Kanan: Kartu QR Code Utama Ruangan (Siap Cetak & Ditempel di Pintu/Dinding) -->
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm text-center p-3 border-primary">
                <div class="card-body">
                    <h5 class="card-title text-uppercase fw-bold mb-1">KIR - RUANG SEKRETARIAT</h5>
                    <p class="text-muted small mb-3">Scan QR Code di bawah untuk melihat PDF Daftar Barang</p>
                    
                    <!-- QR Code Otomatis Mengarah ke Route Stream PDF -->
                    <div class="p-3 bg-light d-inline-block rounded border mb-3">
                        {!! QrCode::format('svg')->size(180)->margin(1)->generate(route('kir.pdf', 'Sekretariat')) !!}
                    </div>

                    <div>
                        <a href="{{ route('kir.stream-pdf', 'Sekretariat') }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i> Pratinjau Tampilan PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Pratinjau Data Barang di Sistem -->
    <div class="card shadow-sm mt-2">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Daftar Barang Ruang Sekretariat</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Jenis / Nama Barang</th>
                            <th>Merk / Model</th>
                            <th>No. Seri</th>
                            <th>Bahan</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kirs as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><code>{{ $item->no_kode_barang ?? '-' }}</code></td>
                            <td>{{ $item->jenis_barang ?? '-' }}</td>
                            <td>{{ $item->merk_model ?? '-' }}</td>
                            <td>{{ $item->no_seri ?? '-' }}</td>
                            <td>{{ $item->bahan ?? '-' }}</td>
                            <td>{{ $item->tahun_pembuatan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data barang. Silakan unggah file Excel terlebih dahulu.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection