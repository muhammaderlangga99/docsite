<?php
namespace App\Http\Controllers;

use App\Models\Doc; // Penting
use App\Models\DocCategory;
use Illuminate\Http\Request;

class DocController extends Controller
{
    /**
     * Nampilin halaman index, bisa redirect ke doc pertama.
     */
    public function index()
    {
        // Ambil dokumen pertama yg 'category_id'-nya NULL

        $firstDoc = Doc::whereNull('category_id') 
                        ->orderBy('order', 'desc')
                        ->first();
        
        if ($firstDoc) {
            // Kalo ketemu, redirect ke halaman show
            return redirect()->route('docs.show', $firstDoc->id);
        }
        
        // Kalo GA KETEMU, emang bener 404
        abort(404, 'No documentation found.');
    }

    /**
     * Nampilin SATU dokumen.
     * Karena kita pake Route Model Binding {doc:slug} di rute,
     * Laravel auto nyariin Doc berdasarkan slug-nya. Ajaib.
     */
    public function show(Doc $doc)
    {
        return view('docs.show', [
            'doc' => $doc, // Dokumen yg lagi aktif
            'category' => null // Halaman kategori GAK aktif
        ]);
    }

    public function showCategory(DocCategory $category)
    {
        // Kita panggil view 'docs.show' juga, tapi logic-nya dibalik
        return view('docs.show', [
            'doc' => null, // Dokumen GAK aktif
            'category' => $category // Halaman kategori yg lagi aktif
        ]);
    }
    
    // Lo bisa hapus method create, store, edit, update, destroy
    // kalo lo ga butuh CRUD dari web (misal lo ngisinya lgsg ke DB)
}