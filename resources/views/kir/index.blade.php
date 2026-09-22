@extends('layouts.app') {{-- Sesuaikan dengan nama layout utama Anda --}}

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Manajemen Document KIR & QR Code</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- 1. Form Import Data Excel (Sekretariat.xlsx) -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Import Data Barang Excel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kir.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Pilih File Excel Inventaris (.xlsx / .xls)</label>
                            <input type="file" name="file" id="excel_file" class="form-control" accept=".xlsx, .xls, .csv" required>
                            <small class="text-muted">Upload file seperti Sekretariat.xlsx untuk dimasukkan ke database.</small>
                        </div>
                        <button type="submit" class="btn btn-success">Import Excel ke Database</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2. Form Upload PDF KIR Manual -->
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-primary shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Upload File PDF KIR (Ber-TTD)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('kir.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul / Nama Ruangan KIR</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: KIR Ruang Rapat Kominfo" required>
                        </div>
                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">Pilih File PDF KIR</label>
                            <input type="file" name="pdf_file" id="pdf_file" class="form-control" accept="application/pdf" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Unggah PDF & Generate QR Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Tabel Daftar Dokumen KIR Manual -->
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Daftar Dokumen KIR Manual</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Ruangan</th>
                            <th>Nama File</th>
                            <th>Tanggal Unggah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kirList as $index => $kir)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kir->title }}</td>
                                <td>{{ $kir->file_name }}</td>
                                <td>{{ $kir->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('kir.show', $kir->id) }}" class="btn btn-sm btn-info text-white">Lihat QR Code</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-3">Belum ada file KIR yang diunggah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection