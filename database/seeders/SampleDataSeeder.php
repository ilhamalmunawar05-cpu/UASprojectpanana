<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Exhibition;
use App\Models\Auction;
use App\Models\Article;
use App\Models\Collection;
use App\Models\User;

class SampleDataSeeder extends Seeder
{
  public function run(): void
  {
    $admin = User::where('email', 'admin@gallery.com')->first();

    // Artists
    $artistsData = [
      ['name' => 'Raden Saleh', 'specialization' => 'Romanticism', 'bio' => 'Pelukis romantisisme Indonesia.', 'email' => 'raden@example.com', 'phone' => '081234567890'],
      ['name' => 'Affandi', 'specialization' => 'Expressionism', 'bio' => 'Maestro ekspresionisme Indonesia.', 'email' => 'affandi@example.com', 'phone' => '081234567891'],
      ['name' => 'Basuki Abdullah', 'specialization' => 'Realism', 'bio' => 'Pelukis realis Indonesia.', 'email' => 'basuki@example.com', 'phone' => '081234567892'],
    ];

    foreach ($artistsData as $data) {
      Artist::firstOrCreate(['email' => $data['email']], $data);
    }

    $artists = Artist::all();

    // Artworks
    $artworksData = [
      ['title' => 'Penangkapan Diponegoro', 'description' => 'Lukisan sejarah penting.', 'medium' => 'Oil on canvas', 'year' => 1957, 'dimensions' => '112x179cm', 'price' => 500000000, 'status' => 'on_display', 'image' => 'artworks/default.svg'],
      ['title' => 'Potret Diri', 'description' => 'Self portrait ekspresionisme.', 'medium' => 'Oil on canvas', 'year' => 1977, 'dimensions' => '100x80cm', 'price' => 150000000, 'status' => 'available', 'image' => 'artworks/default.svg'],
      ['title' => 'Pemandangan Merapi', 'description' => 'Lukisan pemandangan alam.', 'medium' => 'Oil on canvas', 'year' => 1965, 'dimensions' => '90x120cm', 'price' => 250000000, 'status' => 'available', 'image' => 'artworks/default.svg'],
    ];

    foreach ($artworksData as $i => $data) {
      $data['artist_id'] = $artists[$i % $artists->count()]->id;
      Artwork::firstOrCreate(['title' => $data['title']], $data);
    }

    $artworks = Artwork::all();

    // Exhibitions
    $exhibitionsData = [
      ['title' => 'Pameran Seni Nasional 2025', 'description' => 'Pameran tahunan seniman Indonesia.', 'location' => 'Galeri Nasional Jakarta', 'start_date' => now()->addDays(7), 'end_date' => now()->addDays(37), 'status' => 'upcoming'],
      ['title' => 'Retrospeksi Seni Indonesia', 'description' => 'Perjalanan seni rupa Indonesia.', 'location' => 'Museum Seni Rupa Jakarta', 'start_date' => now()->subDays(10), 'end_date' => now()->addDays(20), 'status' => 'ongoing'],
    ];

    foreach ($exhibitionsData as $data) {
      Exhibition::firstOrCreate(['title' => $data['title']], $data);
    }

    // Auctions
    $availableArtwork = $artworks->where('status', 'available')->first();
    if ($availableArtwork) {
      Auction::firstOrCreate(
        ['artwork_id' => $availableArtwork->id],
        [
          'artwork_id' => $availableArtwork->id,
          'starting_bid' => 100000000,
          'current_bid' => 150000000,
          'start_date' => now()->subDays(5),
          'end_date' => now()->addDays(5),
          'status' => 'active'
        ]
      );
    }

    // Articles
    if ($admin) {
      $articlesData = [
        ['title' => 'Seni Digital Indonesia', 'slug' => 'seni-digital-indonesia', 'content' => 'Perkembangan seni digital di Indonesia sangat pesat.', 'excerpt' => 'Perkembangan seni digital Indonesia.', 'author_id' => $admin->id, 'category' => 'review', 'is_published' => true, 'published_at' => now()],
        ['title' => 'Mengenal Affandi', 'slug' => 'mengenal-affandi', 'content' => 'Affandi adalah maestro lukis Indonesia.', 'excerpt' => 'Mengenal maestro Affandi.', 'author_id' => $admin->id, 'category' => 'article', 'is_published' => true, 'published_at' => now()->subDays(3)],
      ];

      foreach ($articlesData as $data) {
        Article::firstOrCreate(['slug' => $data['slug']], $data);
      }
    }

    // Collections
    $collectionsData = [
      ['title' => 'Keris Majapahit', 'collection_number' => 'KRS-001', 'description' => 'Keris bersejarah dari Majapahit.', 'category' => 'lainnya', 'year' => 1950, 'origin' => 'Majapahit', 'material' => 'Besi', 'dimensions' => '40x5cm', 'image' => 'collections/default.svg'],
      ['title' => 'Lukisan Pertempuran Surabaya', 'collection_number' => 'LKS-001', 'description' => 'Lukisan dokumenter pertempuran.', 'category' => 'lukisan', 'year' => 1946, 'origin' => 'Museum Nasional', 'material' => 'Cat minyak', 'dimensions' => '200x300cm', 'image' => 'collections/default.svg'],
    ];

    foreach ($collectionsData as $data) {
      Collection::firstOrCreate(['collection_number' => $data['collection_number']], $data);
    }

    $this->command->info('Sample data seeded successfully!');
  }
}
