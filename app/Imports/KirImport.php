<?php

namespace App\Imports;

use App\Models\Kir;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Database\Eloquent\Model;

class KirImport implements ToModel, WithStartRow
{
    /**
     * Mulai membaca data dari baris ke-10 (mengabaikan header judul)
     */
    public function startRow(): int
    {
        return 10;
    }

    public function model(array $row): ?Model
    {
        // Abaikan jika kolom nama barang (indeks 2) kosong
        if (empty($row[2])) {
            return null;
        }

        return new Kir([
            'ruangan'          => 'Sekretariat',
            'jenis_barang'     => $row[2] ?? null,  // Kolom C
            'merk_model'       => $row[8] ?? null,  // Kolom I
            'no_seri'          => $row[10] ?? null, // Kolom K
            'ukuran'           => $row[11] ?? null, // Kolom L
            'bahan'            => $row[12] ?? null, // Kolom M
            'tahun_pembuatan'  => $row[14] ?? null, // Kolom O
            'no_kode_barang'   => $row[15] ?? null, // Kolom P
            'jumlah_register'  => $row[17] ?? null, // Kolom R
            'keadaan_barang'   => $row[20] ?? 'Baik', // Kolom U
            'keterangan'       => $row[24] ?? null,   // Kolom Y
        ]);
    }
}