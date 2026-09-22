@extends('layouts.app')

@section('content')
<div class="container py-4">
    <a href="{{ route('kir.index') }}" class="btn btn-secondary mb-3 d-print-none">&larr; Kembali ke Daftar</a>

    <div class="card mx-auto text-center p-4 border border-2 border-dark rounded shadow-sm" style="max-width: 400px; background-color: #ffffff;" id="printable-area">
        <!-- Teks Header Stiker Fisik -->
        <h4 class="fw-bold text-uppercase mb-1" style="letter-spacing: 1px;">DATA {{ $kir->title }}</h4>
        <p class="fw-bold text-uppercase mb-3 text-secondary" style="font-size: 0.95rem;">SCAN QR-CODE</p>

        <!-- Display QR Code -->
        <div class="my-2 d-flex justify-content-center">
            <div class="p-2 border rounded bg-light d-inline-block">
                {!! $qrCode !!}
            </div>
        </div>

        <p class="small text-muted my-2">Scan QR Code di atas menggunakan Smartphone untuk membuka PDF KIR Ber-TTD.</p>
        
        <div class="d-print-none mt-3">
            <a href="{{ $publicPdfUrl }}" target="_blank" class="btn btn-outline-primary btn-sm mb-2">Buka PDF Langsung</a>
            <br>
            <button onclick="window.print()" class="btn btn-success">
                <i class="bi bi-printer"></i> Cetak / Print QR Code
            </button>
        </div>
    </div>
</div>

<style>
/* CSS Khusus untuk halaman Cetak */
@media print {
    body * {
        visibility: hidden;
    }
    #printable-area, #printable-area * {
        visibility: visible;
    }
    #printable-area {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        max-width: 350px !important;
        border: 2px solid #000 !important;
        box-shadow: none !important;
    }
    .d-print-none {
        display: none !important;
    }
}
</style>
@endsection