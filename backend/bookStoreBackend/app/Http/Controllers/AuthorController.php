<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        // Self-seeding check: If authors table is completely empty, populate with default starter authors
        if (Author::count() === 0) {
            $defaultAuthors = [
                ['name' => 'Erin Morgenstern', 'img' => 'https://i.pravatar.cc/200?img=47', 'rating' => 4.7],
                ['name' => 'Paulo Coelho', 'img' => 'https://i.pravatar.cc/200?img=12', 'rating' => 4.8],
                ['name' => 'John Green', 'img' => 'https://i.pravatar.cc/200?img=15', 'rating' => 4.6],
                ['name' => 'Alex Michaelides', 'img' => 'https://i.pravatar.cc/200?img=33', 'rating' => 4.5],
                ['name' => 'E. Lockhart', 'img' => 'https://i.pravatar.cc/200?img=49', 'rating' => 4.4],
                ['name' => 'Timothy Snyder', 'img' => 'https://i.pravatar.cc/200?img=5', 'rating' => 4.7],
            ];
            foreach ($defaultAuthors as $authData) {
                Author::create($authData);
            }
        }

        return response()->json(Author::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:authors,name',
            'img' => 'nullable|string', // Support custom URLs (or local references)
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $author = Author::create($request->all());

        return response()->json([
            'message' => 'Author added successfully! ✍️',
            'author' => $author
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $author = Author::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:authors,name,' . $author->id,
            'img' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $author->update($request->all());

        return response()->json([
            'message' => 'Author updated successfully! ✏️',
            'author' => $author
        ]);
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return response()->json([
            'message' => 'Author deleted successfully! 🗑️'
        ]);
    }
}
