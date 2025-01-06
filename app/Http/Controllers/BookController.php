<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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
            'year' => ['required', 'integer'],
            'cover' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
        ],
        [
            'title.required' => 'Judul buku harus diisi',
            'author.required' => 'Penulis buku harus diisi',
            'year.required' => 'Tahun terbit buku harus diisi',
            'year.integer' => 'Tahun terbit buku harus berupa angka',
            'cover.mime' => 'Cover buku harus berupa file gambar (jpg, jpeg, png)',
            'cover.max' => 'Ukuran file cover buku maksimal 2MB'
        ]
        );
        if ($validData->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validData->errors()
            ], 422);
        }

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover');
            $coverName = time().'_'.$cover->getClientOriginalName();
            // Simpan file ke storage, tetapi nama file nya lagnsung link

            $coverPath = $cover->storeAs('uploads', $coverName, 'public');
        }
        $result = $request->all();
        $result['cover'] = Storage::url($coverPath);;
        

            $book = Book::create($result);
            return response()->json([
                "message" => "Book created",
                "data" => $book
            ], 201);
    }
    
     // Tampilkan buku berdasarkan ID
     public function show($id)
     {
        try {
            
         $book = Book::findOrFail($id);
         return response()->json($book);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }
     }
 
     // Update buku
     public function update(Request $request, $id)
     {
        try{

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
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }
     }
 
     // Hapus buku
     public function destroy($id)
     {
        

            $result =  Book::destroy($id);
            if ($result == 0) {
                return response()->json([
                    'message' => 'Book not found'
                ], 404);
            }
            return response()->json(['message' => 'Book deleted successfully']);
        
     }
}
