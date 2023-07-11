<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Paskas extends Model
{
    use HasFactory;
    protected $table = 'paskas';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%');
        });

        $query->when($filters['jenis'] ?? false, function ($query, $jenis) {
            if (empty($jenis)) {
                $query->where('paskas.fungsi', TRUE);
            } else {
                $query->where('paskas.fungsi', $jenis);
            }
        });
        $query->when($filters['kondisi'] ?? false, function ($query, $jenis) {
            if (empty($jenis)) {
                $query->where('paskas.kondisi', TRUE);
            } else {
                $query->where('paskas.kondisi', $jenis);
            }
        });
    }

    public function getPaskasFromStatus($status_publikasi) {
        $barang = DB::table('paskas')->where("wp_id", auth()->user()->id)
            ->where('paskas.hapus', '!=', '1')
            ->where('status_publikasi', $status_publikasi)
            ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', 'paskas.kondisi')
            ->join('barkas_jenis', 'barkas_jenis.id', 'paskas.fungsi')
            ->select(
                'uns_barkas_kondisi.kondisi',
                'barkas_jenis.jenis AS fungsi',
                'paskas.kondisi AS id_kondisi',
                'paskas.deskripsi',
                'paskas.judul',
                'paskas.harga',
                'paskas.foto',
                'paskas.status_publikasi',
                'paskas.id'
            );
        return $barang;
    }
}
