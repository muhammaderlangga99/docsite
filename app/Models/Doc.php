<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doc extends Model
{
    use HasFactory;
    protected $table = 'posts';

    public function category()
    {
        return $this->belongsTo(DocCategory::class, 'category_id');
    }

    public function getFirstH2ContentAttribute(): ?string
    {
        if (empty($this->content)) {
            return null;
        }
        
        // Regex ini akan mencari <h2 ...> (termasuk jika ada atribut)
        // dan mengambil teks di dalamnya sampai ketemu </h2>
        if (preg_match('~<h2.*?>(.*?)</h2>~si', $this->content, $matches)) {
            // $matches[1] berisi konten di dalam <h2>
            // strip_tags() untuk membersihkan jika ada HTML lain di dalam <h2>
            return strip_tags($matches[1]);
        }

        return null; // Kembalikan null jika tidak ketemu <h2>
    }
}
