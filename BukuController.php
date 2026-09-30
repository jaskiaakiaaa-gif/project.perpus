<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $buku = Buku::with('kategori')->latest()->get();
        return view('buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //
        $request->validate([
           'isbn'       =>'required|unique:buku,isbn',
           'foto_buku'  =>'nullable|image|mimes:jpg,jpeg,png',
           'nama_buku'  =>'required|string|max:255',
           'stok'       =>'required|integer|min:0',
           'kategori_id'       => 'required|exists:kategori,id',
        ]);

        $fotoPath = null;
    if ($request->hasFile('foto_buku')) {
        $fotoPath = $request->file('foto_buku')->store('buku', 'public');
    }

    // 3. Simpan Ke Database
    Buku::create([
        'isbn'        => $request->isbn,
        'foto_buku'   => $fotoPath,
        'nama_buku'   => $request->nama_buku,
        'stok'        => $request->stok,
        'kategori_id' => $request->kategori_id,
        
    ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil disimpan!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
      
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();
        return view('buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $buku = Buku::findOrFail($id);

        $request->validate([
            'isbn'       =>'required|unique:buku,isbn',
            'foto_buku'  =>'nullable|image|mimes:jpg,jpeg,png',
            'nama_buku'  =>'required|string|max:255',
            'stok'       =>'required|integer|min:0',
            'kategori_id'       => 'required|exists:kategori,id',
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
    
        // Cek apakah ada member yang sedang meminjam buku ini
        $sedangDipinjam = \App\Models\Member::where('nama_buku', $buku->nama_buku)
            ->where('status', 'Dipinjam')
            ->exists();
    
        if ($sedangDipinjam) {
            return redirect()->route('buku.index')
                ->with('error', 'Buku tidak dapat dihapus karena sedang dipinjam oleh member!');
        }
    
        // Hapus foto jika ada
        if ($buku->foto_buku && Storage::disk('public')->exists($buku->foto_buku)) {
            Storage::disk('public')->delete($buku->foto_buku);
        }
    
        $buku->delete();
    
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
