<?php

namespace App\Cells;

use App\Models\ArtikelModel;

class ArtikelTerkini
{
    protected ?string $kategori = null;

    public function mount(string $kategori = null)
    {
        $this->kategori = $kategori;
    }

    public function show(array $params = []): string
{
    $this->kategori = $params['kategori'] ?? null;

    $model = new \App\Models\ArtikelModel();
    $artikel = $model->where('kategori', $this->kategori)
                     ->orderBy('created_at', 'DESC')
                     ->limit(5)
                     ->findAll();

    return view('Views/components/artikel_terkini', ['artikel' => $artikel]);
}

}
