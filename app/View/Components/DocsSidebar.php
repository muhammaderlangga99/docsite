<?php

namespace App\View\Components;

use App\Models\Doc;
use App\Models\DocCategory;
use Illuminate\View\Component;

class DocsSidebar extends Component
{
    public $categories;
    public $rootDocs;
    public $activeDoc;
    public $activeCategory;

    public function __construct($activeDoc = null, $activeCategory = null) 
    {
        $this->activeDoc = $activeDoc;
        $this->activeCategory = $activeCategory;
        
        // INI YANG DI-FIX:
        // Query buat Kategori
        $this->categories = DocCategory::with([
                                'posts' => function ($query) {
                                    // 1. Urutin postingan ANAK (di dalem accordion)
                                    $query->orderBy('order', 'asc'); 
                                }
                            ])
                            // 2. Urutin KATEGORI-nya (accordion-nya)
                            ->orderBy('order', 'asc')
                            ->where('deleted_at', null) 
                            ->get();
        
        // Query buat postingan Induk (di luar accordion)
        $this->rootDocs = Doc::whereNull('category_id')
                            // 3. Urutin postingan INDUK
                            ->orderBy('order', 'asc')
                            ->where('is_published', 1)
                            ->where('deleted_at', null)
                            ->get();
    }

    public function render()
    {
        return view('components.docs-sidebar');
    }
}