<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Book;

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
    //   ketika dipinjam, jumlah buku nya berkurang 1  dan statusnya menjadi dipinjam, kemudian jika jumlah bukunya kurang dari 1, maka tidak bisa dipinjam
        $book = Book::findOrFail($request->book_id);
        // log data buku di terminal
        
        
        if ($book->jumlah_buku < 1) {
            return response()->json(['message' => 'Buku tidak tersedia'], 400);
        }
        // bagaiaman cara update data buku nya?
        // status buku merupakan enum yang salah satunya ada "Dipinjam" bagaimana cara membuatnya
      $book->jumlah_buku -= 1;

        $book->save();


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

  public function returnBook($id)
  {
      $peminjaman = Peminjaman::findOrFail($id);
      if ($peminjaman->status == 'dikembalikan') {
          return response()->json(['message' => 'Buku sudah dikembalikan'], 400);
        }

        $peminjaman->return_date = now();
        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();


        // saya ingin mengubah status buku nya menjadi dikembalikan, kemudian jumlah bukunya bertambah 1
        $peminjaman->book->jumlah_buku += 1;
        $peminjaman->book->save();

        return response()->json($peminjaman);
   
}
public function getAllUnreturned()
{
    // diruutkan dari yang paling baru dipinjam
    $peminjaman = Peminjaman::where('status', 'dipinjam')->orderBy('borrow_date', 'desc')->get();
    return response()->json($peminjaman);
}
public function getAllReturned()
{
    // diurutkan dari yang paling baru dikembalikan
    $peminjaman = Peminjaman::where('status', 'dikembalikan')->orderBy('return_date', 'desc')->get();
    return response()->json($peminjaman);

    
}
}

