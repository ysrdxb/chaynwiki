ChainWiki Implementation Plan
Goal Description
Build "ChainWiki" (project name subject to change, referenced as "SoundBook" in designs), a premium, community-driven music encyclopedia. The goal is to create a "Wikipedia for Music" that is visually stunning, user-friendly, and rich with data integrations.

User Review Required
IMPORTANT

Design Assets: We are using the provided Figma screenshots as a foundation but have creative license to improve and optimize. Tech Stack: Confirming usage of Laravel 11, Livewire 3, Tailwind CSS, Alpine.js, and Filament v3 for the admin panel. Database: MySQL 8.0+ is assumed.

Proposed Architecture
1. Technology Stack
Backend: Laravel 11.x
Frontend: Blade + Livewire 3 (Interactivity) + Alpine.js (Micro-interactions)
Styling: Tailwind CSS (Utility-first, configured with "SoundBook" aesthetics)
Admin: Filament v3 (TALL stack based admin panel)
Database: MySQL 8.0
Assets: Vite for bundling
2. Design System (Derived from Visuals)
Theme: Dark Mode base.
Typography: likely 'Inter' or 'Syne' (wide headers) for headings, sans-serif for body.
Colors:
Background: Deep almost-black (#050505 or similar)
Primary Accent: Vivid Blue/Purple gradients
Text: White (Primary), Grey (Secondary)
Components:
Glassmorphism: Translucent cards with subtle borders.
Rounded Corners: rounded-xl or rounded-2xl for cards.
Gradients: Text gradients for major headers.
3. Database Schema Strategy
We will use a Polymorphic or Entity-Attribute approach for the core content to keep the "Wiki" nature flexible, but given the structured nature of music data (Songs have BPM, Artists do not), a Class Table Inheritance style or separate tables linked by a registry might be better.

Chosen Approach: Dedicated Tables with Unified 'Article' Wrapper

articles table: Common metadata (title, slug, author_id, status, views, trending_score, polymorphic_type, polymorphic_id).
songs table: Specifics (lyrics, duration, spotify_id).
artists table: Specifics (bio, social_links).
genres table: Specifics (origin).
playlists table: Specifics.
This allows us to query "All Articles" easily for search/trending, while maintaining strict schema for specific data types.

4. Implementation Phases
Phase 1: Setup & Design System
Initialize Laravel.
Setup Tailwind with custom font families and color palette.
Create basic layout (Navbar, Footer) matching designs.
Phase 2: Core Data Structure
Migrations for users, articles, songs, artists, genres.
Seeders to populate "Trending" section for UI development.
Phase 3: Public UI Development
Homepage: Hero, Search, Trending Grid.
Article Page: High detailed view with separate layouts for Song/Artist.
Search: Integrated search with auto-complete.
## Phase 4: Contribution System (Current Focus)
### 1. Backend Service Layer (`ArticleService`)
- **Responsibility**: Handle database transactions, proper polymorphic relationship creation (`Song`, `Artist`, etc.), and revision history.
- **Methods**: `createArticle($data, $metaData)`, `updateArticle($article, $data)`.

### 2. Frontend Wizard (`Livewire\Article\Create`)
- **Steps**:
  1. **Category Selection**: Grid of cards (Song, Artist, Genre, etc.).
  2. **Data Entry**: Dynamic form based on category.
     - *Song*: Title, Artist (Search/Create), Album, Lyrics, Spotify Link.
     - *Artist*: Name, Bio, Origin.
  3. **Review & Submit**: Final check before committing.
- **Rich Text**: Use Tiptap or simple Markdown editor for bio/lyrics.

### 3. Routing
- `/wiki/create` -> `App\Livewire\Article\Create`
- `/wiki/{category}/{slug}` -> `App\Livewire\Article\Show`

### 4. Search & Autocomplete
- Use simple SQL `LIKE` queries for now, upgrade to Scout later.
Phase 5: Admin & Moderation
Filament resource setup.
Moderation queue for user submissions.
Verification Plan
Automated Tests
php artisan test: Run Unit and Feature tests.
Browser testing with Laravel Dusk (optional, mostly manual verification for UI).
Manual Verification
Visual Check: Compare implemented UI against Figma screenshots (taking liberties to improve).
Flow Check: Can a new user register, create a song page, auto-fill from Spotify (mocked if API key missing), and view it?