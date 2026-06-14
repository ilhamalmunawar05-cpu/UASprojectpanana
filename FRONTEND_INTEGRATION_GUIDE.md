# Frontend Integration Documentation - SIPERPUS

## Overview
Dokumentasi ini menjelaskan integrasi template Book Master ke dalam struktur Laravel SIPERPUS. Project menggunakan Bootstrap 4 dengan responsive design yang terintegrasi penuh dengan backend Laravel.

## Project Structure

### Frontend Files
```
resources/views/
├── layouts/
│   ├── bookmaster.blade.php          # Main layout template
│   └── app.blade.php                 # Admin layout (existing)
├── bookmaster/
│   ├── index.blade.php               # Home page
│   ├── generic.blade.php             # Information page
│   └── elements.blade.php            # UI components reference
├── admin/                            # Admin views (existing)
├── auth/                             # Authentication views (existing)
└── ...other views
```

### Static Assets
```
public/bookmaster/
├── css/
│   ├── bootstrap.css
│   ├── main.css
│   ├── magnific-popup.css
│   ├── owl.carousel.css
│   ├── nice-select.css
│   ├── animate.min.css
│   ├── font-awesome.min.css
│   └── linearicons.css
├── js/
│   ├── main.js
│   ├── vendor/
│   │   ├── jquery-2.2.4.min.js
│   │   ├── bootstrap.min.js
│   │   └── popper.min.js
│   ├── jquery.ajaxchimp.min.js
│   ├── jquery.magnific-popup.min.js
│   ├── jquery.nice-select.min.js
│   ├── jquery.sticky.js
│   ├── owl.carousel.min.js
│   ├── parallax.min.js
│   └── ...other plugins
├── img/
│   ├── logo.png
│   ├── header-img.png
│   ├── about-img.jpg
│   ├── elements/
│   └── ...product images
└── fonts/
    └── ...font files
```

### Routes
```
/                    → Home page (bookmaster.index)
/pages/generic       → Information page (bookmaster.generic)
/pages/elements      → UI components (bookmaster.elements)
/login               → Login page
/register            → Register page
/admin/dashboard     → Admin dashboard
/artwork, /artists, /exhibitions, etc. → Public pages (existing)
```

## Key Features

### Main Layout (layouts/bookmaster.blade.php)
- Responsive Bootstrap 4 framework
- Navigation header dengan user auth check
- Footer dengan link dan newsletter signup
- Dynamic title dan meta description
- CSS dan JS assets properly linked dengan `asset()` helper
- `@yield` untuk content area

### Home Page (bookmaster/index.blade.php)
- Banner section dengan call-to-action
- About section dengan gallery
- Features/modules showcase
- Counter statistics
- Testimonials carousel
- Call-to-action button

### Asset Loading
Semua asset menggunakan Laravel `asset()` helper:
```blade
<link rel="stylesheet" href="{{ asset('bookmaster/css/main.css') }}">
<script src="{{ asset('bookmaster/js/main.js') }}"></script>
<img src="{{ asset('bookmaster/img/logo.png') }}" alt="">
```

## Development Workflow

### Creating New Feature Branch
```bash
# Create branch untuk fitur baru
git checkout -b feature/nama-fitur

# Contoh:
git checkout -b feature/user-profile
git checkout -b feature/exhibition-management
```

### Branch Naming Convention
- `feature/` - Fitur baru
- `bugfix/` - Bug fixes
- `hotfix/` - Urgent fixes
- `refactor/` - Code refactoring

### Integrating with Controller
```php
// Dalam controller
public function index() {
    return view('bookmaster.index');
}

// With data
public function show($id) {
    $item = Item::find($id);
    return view('bookmaster.show', compact('item'));
}
```

### Using Layout
```blade
@extends('layouts.bookmaster')

@section('title', 'Page Title - SIPERPUS')
@section('meta_description', 'Meta description for SEO')

@section('content')
    <!-- Your content here -->
@endsection

@section('extra_css')
    <!-- Additional CSS if needed -->
@endsection

@section('extra_js')
    <!-- Additional JavaScript if needed -->
@endsection
```

## CSS & JavaScript

### Bootstrap Classes
- `.container` - Fixed width container
- `.row` - Bootstrap grid row
- `.col-lg-X` - Large screen columns (12 columns system)
- `.d-flex` - Flexbox utilities
- `.mt-30` - Margin top utilities
- `.text-center` - Text alignment
- `.btn`, `.primary-btn`, `.genric-btn` - Button styles

### JavaScript Plugins Available
- jQuery 2.2.4
- Bootstrap 4 components
- Owl Carousel - Product slider
- Magnific Popup - Lightbox
- jQuery Nice Select - Custom dropdowns
- jQuery Sticky - Sticky header/sidebar
- jQuery AjaxChimp - Newsletter integration

### Custom CSS Classes
- `.banner-area` - Full-width banner section
- `.section-gap` - Section spacing
- `.primary-btn` - Primary button style
- `.info-area` - Information content section
- `.counter-area` - Statistics counter section
- `.testomial-area` - Testimonials section

## Common Tasks

### Add New Page
1. Create blade file in `resources/views/bookmaster/`
2. Extend `layouts.bookmaster`
3. Add route in `routes/web.php`
4. Create controller action if needed

```blade
@extends('layouts.bookmaster')
@section('title', 'New Page - SIPERPUS')
@section('content')
    <!-- content -->
@endsection
```

### Update Navigation
Edit `resources/views/layouts/bookmaster.blade.php` navigation section:
```blade
<ul class="nav-menu">
    <li><a href="{{ route('home') }}">Home</a></li>
    <li><a href="{{ route('page.name') }}">Page Name</a></li>
</ul>
```

### Add Custom CSS
Option 1: Add to `@section('extra_css')` in view
```blade
@section('extra_css')
    <style>
        .custom-class { color: red; }
    </style>
@endsection
```

Option 2: Create new CSS file in `public/bookmaster/css/custom.css` and link in layout

### Add Custom JavaScript
```blade
@section('extra_js')
    <script>
        $(document).ready(function() {
            // Your code here
        });
    </script>
@endsection
```

## Testing Checklist

Before deploying, check:
- [ ] All routes working correctly
- [ ] Assets loading properly (no 404 errors)
- [ ] Responsive design on mobile (375px)
- [ ] Responsive design on tablet (768px)
- [ ] Responsive design on desktop (1200px+)
- [ ] Navigation menu responsive
- [ ] All links functional
- [ ] Forms working correctly
- [ ] Images displaying properly
- [ ] Console no JavaScript errors

## Performance Optimization

### CSS & JavaScript
- Minified assets already included
- Load critical CSS inline if needed
- Defer non-critical JavaScript

### Images
- Use `<img class="img-fluid" src="">` for responsive images
- Compress images before uploading
- Consider using WebP format for large images

### Caching
```php
// In layout or controller
Header('Cache-Control: public, max-age=3600');
```

## Troubleshooting

### Assets not loading
- Check `public/bookmaster/` folder exists
- Verify `asset()` helper paths
- Check browser console for 404 errors
- Run `php artisan storage:link` if symlink needed

### Styles not applying
- Clear browser cache (Ctrl+Shift+Delete)
- Check CSS file path in `<head>`
- Check CSS specificity/cascade issues
- Use browser DevTools to inspect

### JavaScript not working
- Check jQuery is loaded before plugins
- Check console for errors
- Verify script src paths
- Check for JavaScript conflicts

## Git Workflow

### Committing Frontend Changes
```bash
# Stage changes
git add resources/views/bookmaster/
git add public/bookmaster/
git add routes/web.php

# Commit with descriptive message
git commit -m "feat: Add new bookmaster feature

- Detailed description
- List of changes
- Reference issue if applicable"

# Push to branch
git push origin feature/nama-fitur
```

### Pull Request Checklist
- [ ] Branch up-to-date with main
- [ ] All changes committed and pushed
- [ ] No console errors
- [ ] Responsive design tested
- [ ] Code follows project style
- [ ] Commit messages are clear

## Resources

- [Bootstrap 4 Documentation](https://getbootstrap.com/docs/4.0/)
- [jQuery Documentation](https://jquery.com/)
- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Owl Carousel Documentation](https://owlcarousel2.github.io/OwlCarousel2/)
- [Magnific Popup Documentation](https://dimsemenov.com/plugins/magnific-popup/)

## Support

Untuk pertanyaan atau issue terkait frontend:
1. Check dokumentasi ini terlebih dahulu
2. Check existing code patterns
3. Ask di team chat/documentation
4. Create GitHub issue jika bug

---

**Last Updated**: 2026-06-11
**Status**: Ready for production
**Maintained By**: SIPERPUS Team
