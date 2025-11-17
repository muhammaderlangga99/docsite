<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocCategory extends Model
{
    use HasFactory;
    protected $table = 'category';

    public function posts()
    {
        // Eloquent pinter, tapi kita perjelas:
        // Model 'Doc' (tabel posts) di-link oleh 'category_id'
        return $this->hasMany(Doc::class, 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
