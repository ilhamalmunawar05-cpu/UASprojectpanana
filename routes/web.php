<?php

use Illuminate\Support\Facades\Route;

// ============================================================================
// IMPORT CONTROLLERS - AUTH
// ============================================================================
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ============================================================================
// IMPORT CONTROLLERS - PUBLIC
// ============================================================================
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\ArtworkController;
use App\Http\Controllers\Public\ArtistController;
use App\Http\Controllers\Public\ExhibitionController;
use App\Http\Controllers\Public\AuctionController;
use App\Http\Controllers\Public\ArticleController;
use App\Http\Controllers\Public\GuestbookController;
use App\Http\Controllers\Public\MuseumController;
use App\Http\Controllers\Public\OpacController;
use App\Http\Controllers\Public\EResourceController;
use App\Http\Controllers\Public\HelpController;

// ============================================================================
// IMPORT CONTROLLERS - ADMIN
// ============================================================================
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ArtworkController as AdminArtworkController;
use App\Http\Controllers\Admin\ArtistController as AdminArtistController;
use App\Http\Controllers\Admin\ExhibitionController as AdminExhibitionController;
use App\Http\Controllers\Admin\AuctionController as AdminAuctionController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\EResourceController as AdminEResourceController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIC (Tanpa Autentikasi)
|--------------------------------------------------------------------------
| Route untuk halaman publik yang dapat diakses tanpa login
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// OPAC - Public Catalog Search
Route::get('/opac', [OpacController::class, 'index'])->name('opac.index');

// OPAC detail
Route::get('/opac/{book}', [OpacController::class, 'show'])->name('opac.show');

// Public E-Resources
Route::get('/eresources', [EResourceController::class, 'index'])->name('eresources.public');

// Public Help / FAQ
Route::get('/help/faq', [HelpController::class, 'faq'])->name('help.faq');

// Static Bookmaster Pages
Route::view('/pages/generic', 'bookmaster.generic')->name('pages.generic');
Route::view('/pages/elements', 'bookmaster.elements')->name('pages.elements');

// Modul A: Galeri Virtual (Katalog Karya Seni)
Route::get('/artwork', [ArtworkController::class, 'index'])->name('gallery.index');
Route::get('/artwork/{id}', [ArtworkController::class, 'show'])->name('gallery.show');

// Modul B: Profil Seniman & Kurator
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.public');
Route::get('/artists/{id}', [ArtistController::class, 'show'])->name('artists.show');

// Modul C: Jadwal Pameran
Route::get('/exhibitions', [ExhibitionController::class, 'index'])->name('exhibitions.public');
Route::get('/exhibitions/{id}', [ExhibitionController::class, 'show'])->name('exhibitions.show');

// Modul D: Lelang Karya
Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.public');
Route::get('/auctions/{id}', [AuctionController::class, 'show'])->name('auctions.show');
Route::post('/auctions/{auction}/bid', [AuctionController::class, 'bid'])->name('public.auctions.bid')->middleware('auth');

// Modul E: Artikel Kritik & Ulasan Seni
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.public');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// MODUL F: Buku Tamu & Komentar Pengunjung
Route::get('/guestbook', [GuestbookController::class, 'index'])->name('guestbook.public');
Route::post('/guestbook', [GuestbookController::class, 'store'])->name('guestbook.store');

// Modul G: Koleksi Museum / Arsip
Route::get('/museum', [MuseumController::class, 'index'])->name('museum.public');
Route::get('/museum/{id}', [MuseumController::class, 'show'])->name('museum.show');

/*
|--------------------------------------------------------------------------
| ROUTE AUTH
|--------------------------------------------------------------------------
| Route untuk login, register, dan logout
*/
// Load authentication routes (login/register/logout, password reset, etc.)
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| ROUTE KHUSUS UNTUK BIDDING (Memerlukan Autentikasi)
|--------------------------------------------------------------------------
| User harus login untuk dapat melakukan bidding
*/

Route::middleware(['auth'])->group(function () {
    // Bid di Auction
    Route::post('/auctions/{auction}/bid', [AuctionController::class, 'bid'])->name('public.auctions.bid');
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN (dengan middleware auth dan role)
|--------------------------------------------------------------------------
| Route untuk panel admin yang hanya bisa diakses oleh:
| - Super Admin (akses penuh)
| - Staff Admin (akses terbatas)
*/

Route::middleware(['auth', 'role:super-admin|staff-admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Resource Routes - CRUD Lengkap untuk Setiap Modul

    // Modul A: Manajemen Karya Seni (Artworks)
    Route::resource('artworks', AdminArtworkController::class)
        ->middleware('permission:manage artworks');

    // Modul B: Manajemen Seniman & Kurator (Artists)
    Route::resource('artists', AdminArtistController::class)
        ->middleware('permission:manage artists');

    // Modul C: Manajemen Pameran (Exhibitions)
    Route::resource('exhibitions', AdminExhibitionController::class)
        ->middleware('permission:manage exhibitions');

    // Modul D: Manajemen Lelang (Auctions)
    Route::resource('auctions', AdminAuctionController::class)
        ->middleware('permission:manage auctions');

    // Modul E: Manajemen Artikel (Articles)
    Route::resource('articles', AdminArticleController::class)
        ->middleware('permission:manage articles');

    // Modul F: Manajemen Komentar (Comments) - Hanya index, show, destroy
    Route::resource('comments', AdminCommentController::class)
        ->only(['index', 'show', 'destroy'])
        ->middleware('permission:manage comments');

    // Modul G: Manajemen Koleksi Museum (Collections)
    Route::resource('collections', AdminCollectionController::class)
        ->middleware('permission:manage collections');

    // Modul H: Manajemen Kategori Buku
    Route::resource('categories', AdminCategoryController::class);

    // Modul I: Manajemen Buku Perpustakaan
    Route::resource('books', AdminBookController::class);

    // Modul J: Manajemen Anggota Perpustakaan
    Route::resource('members', AdminMemberController::class);

    // Modul K: Manajemen Sirkulasi (Peminjaman & Pengembalian)
    Route::resource('loans', AdminLoanController::class);
    Route::get('loans/{loan}/return', [AdminLoanController::class, 'returnBook'])->name('loans.return');
    Route::post('loans/{loan}/process-return', [AdminLoanController::class, 'processReturn'])->name('loans.processReturn');

    // Modul L: Manajemen E-Resources
    Route::resource('eresources', AdminEResourceController::class);

    // Modul M: Manajemen User (Hanya Super Admin)
    Route::resource('users', AdminUserController::class)
        ->middleware('permission:manage users');

    // Optional: Route tambahan untuk approve/reject comment
    Route::post('comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::post('comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
});

/*
|--------------------------------------------------------------------------
| ROUTE REDIRECT (Helper)
|--------------------------------------------------------------------------
*/

// Redirect /admin ke /admin/dashboard
Route::redirect('/admin', '/admin/dashboard');

// Dashboard route - redirect based on user role
Route::get('/dashboard', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user && $user->hasRole(['super-admin', 'staff-admin'])) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->middleware('auth')->name('dashboard');

// Redirect /home ke dashboard jika admin, atau ke home jika public
Route::get('/home', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user && $user->hasRole(['super-admin', 'staff-admin'])) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('home');
})->name('home.redirect');

// User dashboard (authenticated users)
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\LoanController as UserLoanController;
use App\Http\Controllers\User\MemberController as UserMemberController;

Route::middleware('auth')->get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
Route::middleware('auth')->get('/user/loans', [UserLoanController::class, 'index'])->name('user.loans');
Route::middleware('auth')->post('/user/loans', [UserLoanController::class, 'store'])->name('user.loans.store');
Route::middleware('auth')->get('/user/member', [UserMemberController::class, 'edit'])->name('user.member.edit');
Route::middleware('auth')->patch('/user/member', [UserMemberController::class, 'update'])->name('user.member.update');

// Profile routes (used by feature tests)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
