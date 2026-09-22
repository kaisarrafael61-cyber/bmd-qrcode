<?php

namespace App\Http\Controllers;

use App\Models\Kir;
use App\Models\KirPdf;
use App\Imports\KirImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Throwable;

class KirController extends Controller
{
    // -------------------------------------------------------------
    // FITUR: Upload & Tampil Manual PDF KIR
    // -------------------------------------------------------------

    // Menampilkan halaman daftar & form upload
    public function index()
    {
        $kirList = KirPdf::latest()->get();

        // Mengambil data KIR dengan aman (mencegah error jika tabel kirs belum ada)
        try {
            $kirs = Kir::all();
        } catch (Throwable $e) {
            $kirs = collect(); // Mengembalikan koleksi kosong jika tabel kirs belum ada
        }
        
        return view('kir.index', compact('kirList', 'kirs'));
    }

    // Memproses upload file PDF KIR secara manual
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'required|mimes:pdf|max:10240', // Maksimal 10MB
        ]);

        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $originalName = $file->getClientOriginalName();
            
            // Simpan file ke storage/app/public/kir_pdf/
            $filePath = $file->storeAs('kir_pdf', time() . '_' . $originalName, 'public');

            // Simpan data metadata ke MySQL
            KirPdf::create([
                'title' => $request->title,
                'file_path' => $filePath,
                'file_name' => $originalName,
            ]);

            return redirect()->route('kir.index')->with('success', 'File PDF KIR berhasil diunggah!');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    // Menampilkan detail KIR beserta QR Code-nya
    public function show($id)
    {
        $kir = KirPdf::findOrFail($id);

        // Ambil URL file PDF
        $publicPdfUrl = asset('storage/' . $kir->file_path);
        
        if (config('app.url_lan')) {
            $publicPdfUrl = rtrim(config('app.url_lan'), '/') . '/storage/' . $kir->file_path;
        }

        // Generate QR Code SVG berbasis String URL
        $qrCode = QrCode::size(250)->margin(1)->generate($publicPdfUrl);

        return view('kir.show', compact('kir', 'qrCode', 'publicPdfUrl'));
    }

    // -------------------------------------------------------------
    // FITUR: Import Excel Data Barang & Generate PDF
    // -------------------------------------------------------------

    // Memproses import file Excel (Sekretariat.xlsx)
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240'
        ]);

        Excel::import(new KirImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data Excel KIR berhasil di-import!');
    }

    // Menampilkan / Stream PDF otomatis dari data database hasil import Excel
    public function streamPdf($ruangan)
    {
        $data_aset = Kir::where('ruangan', $ruangan)->get();

        $pdf = Pdf::loadView('kir.pdf', compact('data_aset', 'ruangan'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream("KIR-$ruangan.pdf");
    }
}