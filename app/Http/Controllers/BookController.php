<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;



use App\Http\Requests\BookPostRequest;
use App\Models\Book;
use Illuminate\Support\Facades\Validator;



class BookController extends Controller
{
     // Tampilkan semua buku
     public function index()
     {
         return response()->json(Book::all());
     }
 
     // Tambah buku baru
     public function store(Request $request)
     {
        $validData = Validator::make($request->all(), [
            'title' => 'required|string',
            'author' => ['required', 'string'],
            'year' => ['required', 'integer']
        ],
        [
            'title.required' => 'Judul buku harus diisi',
            'author.required' => 'Penulis buku harus diisi',
            'year.required' => 'Tahun terbit buku harus diisi',
            'year.integer' => 'Tahun terbit buku harus berupa angka',
        ]
        );
        if ($validData->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validData->errors()
            ], 422);
        }
            $book = Book::create($validData->validated());
            return response()->json([
                "message" => "Book created",
                "data" => $book
            ], 201);
    }
    
     // Tampilkan buku berdasarkan ID
     public function show($id)
     {
         $book = Book::findOrFail($id);
         return response()->json($book);
     }
 
     // Update buku
     public function update(Request $request, $id)
     {
         $book = Book::findOrFail($id);
         $validData =  Validator::make($request->all(), [
             'title' => 'string',
             'author' => 'string',
             'year' => 'integer',
         ], 
            [
                'title.string' => 'Judul buku harus string',
                'author.string' => 'Penulis buku harus string',
                'year.integer' => 'Tahun terbit buku harus berupa angka',
            ]
        );

            if ($validData->fails()) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors' => $validData->errors()
                ], 422);
            }



 
       
         $book->update($validData->validated());
 
         return response()->json($book);
     }
 
     // Hapus buku
     public function destroy($id)
     {
         Book::destroy($id);
         return response()->json(['message' => 'Book deleted successfully']);
     }
}
