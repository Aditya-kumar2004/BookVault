<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'The Starless Sea',
                'author' => 'Erin Morgenstern',
                'isbn' => '9780525559474',
                'price' => 18.99,
                'original_price' => 26.0,
                'rating' => 4.6,
                'genre' => 'Fantasy',
                'stock' => 42,
                'pages' => 512,
                'publisher' => 'Doubleday',
                'is_featured' => true,
                'is_deal' => false,
                'cover_image' => '/covers/midnight_library.png',
            ],
            [
                'title' => 'We Were Liars',
                'author' => 'E. Lockhart',
                'isbn' => '9780385737951',
                'price' => 12.50,
                'original_price' => 17.99,
                'rating' => 4.3,
                'genre' => 'Thriller',
                'stock' => 18,
                'pages' => 240,
                'publisher' => 'Delacorte',
                'is_featured' => false,
                'is_deal' => true,
                'cover_image' => '/covers/maze_runner.png',
            ],
            [
                'title' => 'The Silent Patient',
                'author' => 'Alex Michaelides',
                'isbn' => '9781250301697',
                'price' => 14.95,
                'original_price' => 21.0,
                'rating' => 4.5,
                'genre' => 'Thriller',
                'stock' => 64,
                'pages' => 336,
                'publisher' => 'Celadon Books',
                'is_featured' => true,
                'is_deal' => false,
                'cover_image' => '/covers/silent_patient.png',
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman',
                'isbn' => '9780374533557',
                'price' => 14.99,
                'original_price' => 19.99,
                'rating' => 4.6,
                'genre' => 'Nonfiction',
                'stock' => 120,
                'pages' => 499,
                'publisher' => 'Farrar Straus',
                'is_featured' => false,
                'is_deal' => false,
                'cover_image' => '/covers/thinking_fast.png',
            ],
            [
                'title' => 'The Alchemist',
                'author' => 'Paulo Coelho',
                'isbn' => '9780062315007',
                'price' => 10.99,
                'original_price' => 16.99,
                'rating' => 4.7,
                'genre' => 'Fiction',
                'stock' => 230,
                'pages' => 208,
                'publisher' => 'HarperOne',
                'is_featured' => true,
                'is_deal' => false,
                'cover_image' => '/covers/the_alchemist.png',
            ],
            [
                'title' => 'The Fault in Our Stars',
                'author' => 'John Green',
                'isbn' => '9780525478812',
                'price' => 11.50,
                'original_price' => 15.99,
                'rating' => 4.6,
                'genre' => 'Romance',
                'stock' => 56,
                'pages' => 313,
                'publisher' => 'Dutton Books',
                'is_featured' => false,
                'is_deal' => false,
                'cover_image' => '/covers/fault_stars.png',
            ],
            [
                'title' => 'The Midnight Library',
                'author' => 'Matt Haig',
                'isbn' => '9780525559473', // Adjust to be unique if needed
                'price' => 15.99,
                'original_price' => 22.99,
                'rating' => 4.4,
                'genre' => 'Fiction',
                'stock' => 88,
                'pages' => 304,
                'publisher' => 'Canongate',
                'is_featured' => true,
                'is_deal' => false,
                'cover_image' => '/covers/midnight_library.png',
            ],
        ];

        foreach ($books as $bookData) {
            Book::updateOrCreate(
                ['isbn' => $bookData['isbn']],
                $bookData
            );
        }
    }
}
