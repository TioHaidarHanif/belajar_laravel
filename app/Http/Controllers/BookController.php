<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BookPostRequest;
use App\Models\Book;

class BookController extends Controller
{
     // Tampilkan semua buku
     public function index()
     {
         return response()->json(Book::all());
     }
 
     // Tambah buku baru
     public function store(BookPostRequest $request)
     {

        //  $request->validate([
        //      'title' => 'required|string',
        //      'author' => 'required|string',
        //      'year' => 'required|integer',
        //  ]);

        try{

            $validatedData = $request->validated();
            foreach($validatedData as $key => $value){
                print($key);
                print($value);
            }
            
         $book = Book::create($validatedData);
 
         return response()->json([
            "message" => "Book created",
            "data" => $book
        ], 201);
    }catch(\Exception $e){
        print("hao");

        return response()->json([
            "message" => "Book not created"], 400);
     }
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
 
         $request->validate([
             'title' => 'string',
             'author' => 'string',
             'year' => 'integer',
         ]);
 
         $book->update($request->all());
 
         return response()->json($book);
     }
 
     // Hapus buku
     public function destroy($id)
     {
         Book::destroy($id);
         return response()->json(['message' => 'Book deleted successfully']);
     }
}
