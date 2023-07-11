<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
 
class Sebar extends Model
{
    use HasFactory;
    protected $table = 'sebar';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('judul', 'like', '%' . $search . '%');
        });

        $query->when($filters['jenis'] ?? false, function ($query, $jenis) {
            if (empty($jenis)) {
                $query->where('sebar.fungsi', TRUE);
            } else {
                $query->where('sebar.fungsi', $jenis);
            }
        });
        $query->when($filters['kondisi'] ?? false, function ($query, $jenis) {
            if (empty($jenis)) {
                $query->where('sebar.kondisi', TRUE);
            } else {
                $query->where('sebar.kondisi', $jenis);
            }
        });
    }

    public function getSebarFromStatus($status_publikasi) {
        $barang = DB::table('sebar')->where("wp_id", auth()->user()->id)
            ->where('sebar.hapus', '!=', '1')
            ->where('status_publikasi', $status_publikasi)
            ->join('uns_barkas_kondisi', 'uns_barkas_kondisi.id', 'sebar.kondisi')
            ->join('barkas_jenis', 'barkas_jenis.id', 'sebar.fungsi')
            ->select(
                'uns_barkas_kondisi.kondisi',
                'barkas_jenis.jenis AS fungsi',
                'sebar.kondisi AS id_kondisi',
                'sebar.deskripsi',
                'sebar.judul',
                'sebar.foto',
                'sebar.status_publikasi',
                'sebar.id'
            )
            ->get();
        return $barang;
    }

}