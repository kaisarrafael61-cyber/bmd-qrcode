<?php

namespace App\Imports;

use App\Models\Kir;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class KirImport implements ToModel, WithStartRow
{
    /**
     * Mulai membaca data dari baris ke-10 (mengabaikan header judul)
     */
    public function startRow(): int
    {
        return 10;
    }

    public function model(array $row)
    {
        // Abaikan jika kolom nama barang (indeks 2) kosong
        if (empty($row[2])) {
            return null;
        }

        return new Kir([
            'ruangan'          => 'Sekretariat',
            'jenis_barang'     => $row[2],  // Kolom C
            'merk_model'       => $row[8],  // Kolom I
            'no_seri'          => $row[10], // Kolom K
            'ukuran'           => $row[11], // Kolom L
            'bahan'            => $row[12], // Kolom M
            'tahun_pembuatan'  => $row[14], // Kolom O
            'no_kode_barang'   => $row[15], // Kolom P
            'jumlah_register'  => $row[17], // Kolom R
            'keadaan_barang'   => $row[20] ?? 'Baik', // Kolom U
            'keterangan'       => $row[24] ?? null,   // Kolom Y
        ]);
    }
}