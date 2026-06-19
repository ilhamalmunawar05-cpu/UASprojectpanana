<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Book;
use App\Models\Category;
use App\Models\Member;
use App\Models\User;
use App\Models\Loan;
use App\Models\EResource;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Novel dan buku cerita fiksi.'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku pengetahuan dan fakta.'],
            ['name' => 'Referensi', 'description' => 'Buku-buku rujukan dan referensi.'],
            ['name' => 'Sains & Teknologi', 'description' => 'Buku tentang ilmu pengetahuan dan teknologi.'],
            ['name' => 'Bisnis & Ekonomi', 'description' => 'Buku tentang bisnis dan ekonomi.'],
        ];

        $categoryMap = [];
        foreach ($categories as $category) {
            $model = Category::firstOrCreate(['name' => $category['name']], ['description' => $category['description']]);
            $categoryMap[$category['name']] = $model->id;
        }

        $books = [
            [
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => 'J.K. Rowling',
                'publisher' => 'Bloomsbury',
                'year' => 1997,
                'isbn' => '9780747532699',
                'category_id' => $categoryMap['Fiksi'],
                'rack' => 'A1',
                'stock' => 5,
                'image' => 'bookmaster/img/b1.jpg',
            ],
            [
                'title' => 'The Lord of the Rings',
                'author' => 'J.R.R. Tolkien',
                'publisher' => 'Allen & Unwin',
                'year' => 1954,
                'isbn' => '9780544003415',
                'category_id' => $categoryMap['Fiksi'],
                'rack' => 'A2',
                'stock' => 3,
                'image' => 'bookmaster/img/b2.jpg',
            ],
            [
                'title' => 'Sapiens: A Brief History of Humankind',
                'author' => 'Yuval Noah Harari',
                'publisher' => 'Harper',
                'year' => 2011,
                'isbn' => '9780062316097',
                'category_id' => $categoryMap['Non-Fiksi'],
                'rack' => 'B1',
                'stock' => 4,
                'image' => 'bookmaster/img/b3.jpg',
            ],
            [
                'title' => 'Good to Great',
                'author' => 'Jim Collins',
                'publisher' => 'HarperBusiness',
                'year' => 2001,
                'isbn' => '9780066620992',
                'category_id' => $categoryMap['Bisnis & Ekonomi'],
                'rack' => 'C1',
                'stock' => 6,
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'publisher' => 'Bantam',
                'year' => 1988,
                'isbn' => '9780553380163',
                'category_id' => $categoryMap['Sains & Teknologi'],
                'rack' => 'D1',
                'stock' => 2,
            ],
            [
                'title' => 'The Hobbit',
                'author' => 'J.R.R. Tolkien',
                'publisher' => 'Allen & Unwin',
                'year' => 1937,
                'isbn' => '9780547928227',
                'category_id' => $categoryMap['Fiksi'],
                'rack' => 'A3',
                'stock' => 7,
            ],
            [
                'title' => 'Thinking, Fast and Slow',
                'author' => 'Daniel Kahneman',
                'publisher' => 'Farrar, Straus and Giroux',
                'year' => 2011,
                'isbn' => '9780374275631',
                'category_id' => $categoryMap['Non-Fiksi'],
                'rack' => 'B2',
                'stock' => 3,
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(['isbn' => $book['isbn']], $book);
        }

        $publicRole = Role::firstOrCreate(['name' => 'public']);
        $membersData = [
            ['name' => 'Andi Pratama', 'email' => 'andi@example.com', 'department' => 'Sistem Informasi'],
            ['name' => 'Budi Santoso', 'email' => 'budi@example.com', 'department' => 'Teknik Informatika'],
            ['name' => 'Citra Dewi', 'email' => 'citra@example.com', 'department' => 'Manajemen'],
            ['name' => 'Dewi Anggraeni', 'email' => 'dewi@example.com', 'department' => 'Akuntansi'],
            ['name' => 'Eko Prasetyo', 'email' => 'eko@example.com', 'department' => 'Komunikasi'],
        ];

        foreach ($membersData as $index => $memberData) {
            $user = User::firstOrCreate(
                ['email' => $memberData['email']],
                [
                    'name' => $memberData['name'],
                    'password' => Hash::make('password123'),
                ]
            );
            $user->assignRole($publicRole);

            Member::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nim_nidn' => '2024' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                    'full_name' => $user->name,
                    'phone' => '0850' . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT),
                    'address' => 'Jl. Kampus No. ' . ($index + 1),
                    'department' => $memberData['department'],
                    'status' => 'active',
                    'joined_date' => now()->subMonths($index + 1),
                ]
            );
        }

        $members = Member::with('user')->limit(3)->get();
        $availableBooks = Book::where('stock', '>', 0)->get();

        foreach ($members as $member) {
            if ($availableBooks->isEmpty()) {
                break;
            }

            $book = $availableBooks->random();
            if ($book->stock > 0) {
                Loan::firstOrCreate(
                    [
                        'member_id' => $member->id,
                        'book_id' => $book->id,
                        'loan_date' => now()->subDays(15),
                    ],
                    [
                        'due_date' => now()->addDays(7),
                        'status' => 'active',
                    ]
                );
                $book->decrement('stock');
            }
        }

        $eresources = [
            [
                'title' => 'Introduction to Computer Science',
                'type' => 'ebook',
                'category' => 'Ilmu Komputer',
                'description' => 'E-book pengenalan ilmu komputer untuk pemula.',
                'url' => 'https://example.com/cs-intro.pdf',
                'uploaded_by' => 1,
            ],
            [
                'title' => 'Jurnal Fisika Modern Vol. 5',
                'type' => 'journal',
                'category' => 'Fisika',
                'description' => 'Jurnal ilmiah tentang perkembangan fisika modern.',
                'url' => 'https://example.com/physics-journal.pdf',
                'uploaded_by' => 1,
            ],
            [
                'title' => 'Penelitian Pemasaran Digital 2024',
                'type' => 'research_paper',
                'category' => 'Pemasaran Digital',
                'description' => 'Makalah penelitian terbaru tentang pemasaran digital.',
                'url' => 'https://example.com/marketing-research.pdf',
                'uploaded_by' => 1,
            ],
        ];

        foreach ($eresources as $resource) {
            EResource::firstOrCreate(['title' => $resource['title']], $resource);
        }

        $this->command->info('Library seeder completed successfully!');
    }
}
