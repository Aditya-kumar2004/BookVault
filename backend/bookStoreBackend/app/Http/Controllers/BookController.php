<?php
namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller {
    public function index(Request $request) {
        $query = Book::query();
        if ($request->filled('genre')) $query->where('genre', $request->genre);
        if ($request->filled('search')) $query->where(fn($q) => $q->where('title','like',"%{$request->search}%")->orWhere('author','like',"%{$request->search}%"));
        if ($request->boolean('featured')) $query->where('is_featured', true);
        if ($request->boolean('deals')) $query->where('is_deal', true);
        return response()->json($query->paginate(12));
    }
    public function show($id) {
        return response()->json(Book::findOrFail($id));
    }
    public function store(Request $request) {
        $book = Book::create($request->validate(['title'=>'required','author'=>'required','price'=>'required|numeric','genre'=>'required','stock'=>'nullable|integer','cover_image'=>'nullable|string','description'=>'nullable|string','is_featured'=>'nullable|boolean','is_deal'=>'nullable|boolean']));
        return response()->json($book, 201);
    }
    public function update(Request $request, $id) {
        $book = Book::findOrFail($id);
        $book->update($request->all());
        return response()->json($book);
    }
    public function destroy($id) {
        Book::findOrFail($id)->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
