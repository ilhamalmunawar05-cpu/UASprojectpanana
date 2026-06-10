<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Book;
use App\Models\Member;
use App\Models\User;
use App\Models\Loan;
use App\Models\EResource;
use Carbon\Carbon;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Novel dan buku cerita fiksi'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku pengetahuan dan fakta'],
            ['name' => 'Referensi', 'description' => 'Buku-buku rujukan dan referensi'],
            ['name' => 'Sains & Teknologi', 'description' => 'Buku tentang ilmu pengetahuan dan teknologi'],
            ['name' => 'Bisnis & Ekonomi', 'description' => 'Buku tentang bisnis dan ekonomi'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }

        // Create Books
        $books = [
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'publisher' => 'Bloomsbury',
                'year' => 1997,
                'isbn' => '978-0747532699',
                'category_id' => 1,
                'rack' => 'A1',
                'stock' => 5,
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'publisher' => 'Allen & Unwin',
                'year' => 1954,
                'isbn' => '978-0544003415',
                'category_id' => 1,
                'rack' => 'A2',
                'stock' => 3,
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'Harper',
                'year' => 2011,
                'isbn' => '978-0062316097',
                'category_id' => 2,
                'rack' => 'B1',
                'stock' => 4,
            ],
            [
                'title' => 'Good to Great',
                'author' => 'Jim Collins',
                'publisher' => 'HarperBusiness',
                'year' => 2001,
                'isbn' => '978-0066620992',
                'category_id' => 5,
                'rack' => 'C1',
                'stock' => 6,
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'publisher' => 'Bantam',
                'year' => 1988,
                'isbn' => '978-0553380163',
                'category_id' => 4,
                'rack' => 'D1',
                'stock' => 2,
            ],
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'publisher' => 'Allen & Unwin',
                'year' => 1937,
                'isbn' => '978-0547928227',
                'category_id' => 1,
                'rack' => 'A3',
                'stock' => 7,
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman',
                'publisher' => 'Farrar, Straus and Giroux',
                'year' => 2011,
                'isbn' => '978-0374275631',
                'category_id' => 2,
                'rack' => 'B2',
                'stock' => 3,
            ],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(
                ['isbn' => $book['isbn']],
                $book
            );
        }

        // Create Members (based on existing users)
        $users = User::where('email', '!=', 'admin@gallery.com')->limit(5)->get();
        
        $departments = ['Sistem Informasi', 'Teknik Informatika', 'Manajemen', 'Akuntansi', 'Komunikasi'];
        $counter = 1;

        foreach ($users as $user) {
            Member::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nim_nidn' => '2024' . str_pad($counter, 5, '0', STR_PAD_LEFT),
                    'full_name' => $user->name,
                    'phone' => '08' . str_pad(rand(100000000, 999999999), 9, '0', STR_PAD_LEFT),
                    'address' => 'Jl. Kampus No. ' . $counter,
                    'department' => $departments[$counter % 5],
                    'status' => 'active',
                    'joined_date' => now()->subMonths(rand(1, 12)),
                ]
            );
            $counter++;
        }

        // Create Sample Loans
        $members = Member::limit(3)->get();
        $books = Book::where('stock', '>', 0)->limit(5)->get();

        foreach ($members as $member) {
            if ($books->count() > 0) {
                $book = $books->random();
                if ($book->stock > 0) {
                    Loan::create([
                        'member_id' => $member->id,
                        'book_id' => $book->id,
                        'loan_date' => now()->subDays(30),
                        'due_date' => now()->subDays(10),
                        'status' => 'active',
                    ]);
                    $book->decrement('stock');
                }
            }
        }

        // Create E-Resources
        $eresources = [
            [
                'title' => 'Introduction to Computer Science',
                'type' => 'ebook',
                'category' => 'Ilmu Komputer',
                'description' => 'E-book pengenalan ilmu komputer untuk pemula',
                'url' => 'https://example.com/cs-intro.pdf',
                'uploaded_by' => 1,
            ],
            [
                'title' => 'Journal of Modern Physics Vol. 5',
                'type' => 'journal',
                'category' => 'Fisika',
                'description' => 'Jurnal ilmiah tentang perkembangan fisika modern',
                'url' => 'https://example.com/physics-journal.pdf',
                'uploaded_by' => 1,
            ],
            [
                'title' => 'Digital Marketing Research Paper 2024',
                'type' => 'research_paper',
                'category' => 'Pemasaran Digital',
                'description' => 'Makalah penelitian terbaru tentang pemasaran digital',
                'url' => 'https://example.com/marketing-research.pdf',
                'uploaded_by' => 1,
            ],
        ];

        foreach ($eresources as $resource) {
            EResource::firstOrCreate(
                ['title' => $resource['title']],
                $resource
            );
        }

        $this->command->info('Library seeder completed successfully!');
    }
}
