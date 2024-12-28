<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
class PeminjamanController extends Controller
{
  // Tampilkan semua peminjaman
  public function index()
  {
      return response()->json(Peminjaman::with('book')->get());
  }

  // Tambah peminjaman baru
  public function store(Request $request)
  {
      $request->validate([
          'book_id' => 'required|exists:books,id',
          'borrower_name' => 'required|string',
          'borrow_date' => 'required|date',
          'return_date' => 'nullable|date',
      ]);

      $peminjaman = Peminjaman::create($request->all());

      return response()->json($peminjaman, 201);
  }

  // Tampilkan peminjaman berdasarkan ID
  public function show($id)
  {
      $peminjaman = Peminjaman::with('book')->findOrFail($id);
      return response()->json($peminjaman);
  }

  // Update peminjaman
  public function update(Request $request, $id)
  {
      $peminjaman = Peminjaman::findOrFail($id);

      $request->validate([
          'borrower_name' => 'string',
          'borrow_date' => 'date',
          'return_date' => 'nullable|date',
      ]);

      $peminjaman->update($request->all());

      return response()->json($peminjaman);
  }

  // Hapus peminjaman
  public function destroy($id)
  {
      Peminjaman::destroy($id);
      return response()->json(['message' => 'Peminjaman deleted successfully']);
  }
}
