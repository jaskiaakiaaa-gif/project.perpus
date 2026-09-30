<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $member = Member::latest()->get();
        return view('member.index', compact('member'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $buku = Buku::all();
        return view('member.create', compact('buku'));    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //
        $request->validate([
            'nama_member' => 'required|string|max:255',
            'foto_member'   =>'nullable|image|mimes:jpg,jpeg,png',
            'email'         =>'required|email|unique:member,email',
            'jenis_kelamin' =>'required|in:Pria,Wanita',
            'tanggal_lahir' =>'required|date',
            'no_telepon'    =>'required|string|max:20',
            'nama_buku'     =>'required|string|max:255',
        ]);

        $buku = Buku::where('nama_buku', $request->nama_buku)->first();

        if (!$buku || $buku->stok <= 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama_buku' => 'Stok buku ini sudah habis!']);
        }
    
        // 3. Simpan data foto jika ada
        $pathFoto = null;
        if ($request->hasFile('foto_member')) {
            $pathFoto = $request->file('foto_member')->store('member-foto', 'public');
        }
    
        // 4. Simpan data member
        Member::create([
            'nama_member'   => $request->nama_member,
            'foto_member'   => $pathFoto,
            'email'         => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telepon'    => $request->no_telepon,
            'nama_buku'     => $request->nama_buku,
            'status'        => 'Dipinjam',
        ]);
    
        // 5. Kurangi stok buku sebanyak 1
        $buku->decrement('stok', 1);
    
        return redirect()->route('member.index')->with('success', 'Data member berhasil ditambahkan dan stok buku berkurang!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
       
        return view('member.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        
        $member = Member::findOrFail($id);
        $buku = Buku::all();
        return view('member.edit', compact('member', 'buku'));    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = Member::findOrFail($id);

        // 1. Validasi input
        $validated = $request->validate([
            'nama_member'   => 'required|string|max:255',
            'foto_member'   => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048',
            'email'         => 'required|email|unique:member,email,' . $member->id,
            'jenis_kelamin' => 'required|in:Pria,Wanita',
            'tanggal_lahir' => 'required|date',
            'no_telepon'    => 'required|string|max:20',
            'nama_buku'     => 'required|string|max:255',
        ]);

        // 2. Logika Penyesuaian Stok Buku
        if ($member->nama_buku !== $request->nama_buku) {
            $bukuBaru = Buku::where('nama_buku', $request->nama_buku)->first();

            if (!$bukuBaru || $bukuBaru->stok <= 0) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['nama_buku' => 'Stok buku pilihan baru sudah habis!']);
            }

            // Kembalikan stok buku lama (+1)
            Buku::where('nama_buku', $member->nama_buku)->increment('stok', 1);

            // Kurangi stok buku baru (-1)
            $bukuBaru->decrement('stok', 1);
        }

        // 3. Update Foto jika ada file baru
        if ($request->hasFile('foto_member')) {
            if ($member->foto_member && Storage::disk('public')->exists($member->foto_member)) {
                Storage::disk('public')->delete($member->foto_member);
            }
            $validated['foto_member'] = $request->file('foto_member')->store('member-foto', 'public');
        }

        // 4. Simpan perubahan ke database
        $member->update($validated);

        return redirect()->route('member.index')->with('success', 'Data member dan stok buku berhasil diperbarui!');
    }

    public function kembalikan($id)
{
    $member = Member::findOrFail($id);
    
    if ($member->status === 'Dipinjam') {
        // Kembalikan stok buku +1
        Buku::where('nama_buku', $member->nama_buku)->increment('stok', 1);
        
        // Update status di tabel member
        $member->update(['status' => 'Dikembalikan']);
        
        return redirect()->back()->with('success', 'Buku berhasil dikembalikan!');
    }

    return redirect()->back()->with('error', 'Buku sudah dikembalikan sebelumnya.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = Member::findOrFail($id);
        
        if ($member->foto_member && Storage::disk('public')->exists($member->foto_member)) {
            Storage::disk('public')->delete($member->foto_member);
        }
        
        if ($member->status === 'Dipinjam') {
            Buku::where('nama_buku', $member->nama_buku)->increment('stok', 1);
        }
        
        $member->delete();
    
        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus!');
    }
}
