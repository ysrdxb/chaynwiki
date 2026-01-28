# AI Project Prompt: Premium Music Wiki Platform

## Project Context & Mission

You are building a **premium music-focused wiki platform** where users create and share comprehensive articles about music trends, genres, artists, songs, and playlists. This platform must **surpass existing competitors** in design, user experience, and functionality.

**Critical Understanding**: You are the **technical lead and creative director** for this project. Take full ownership. Make architectural decisions. Improve features. Optimize user experience. Guide the project direction with expertise and vision.

---

## Core Project Purpose

Create a collaborative music knowledge platform that rivals Wikipedia's depth but specializes exclusively in music content, featuring:
- Real-time streaming data integration
- Trend tracking and ranking algorithms
- Community-driven content creation
- Superior user experience to all competitors

**Competitors to surpass** (study but DO NOT copy):
- Wikipedia (wiki functionality)
- Reddit (community engagement)
- Fragrantica (detailed item pages)
- Fandom wikis (fan-driven content)

---

## Design Philosophy & Asset Management

### Design Foundation

**Figma Reference**: https://www.figma.com/design/AlyvuUxdKgC4TmLJiy7Vle/SOUNDBOOK

**Design Asset Structure**:
```
docs/
├── readme.md (this requirements doc)
└── figma/
    ├── homepage/
    │   ├── hero_section.png
    │   ├── about_section.png
    │   ├── what_can_you_find.png
    │   ├── core_features.png
    |   |__ the_beat_of_the_moment.png
    |   |__ footer.png 
    |   |__ home.png(this is the full homepage) 
    |   |__ home2.png(this is the second example of a full homepage)
    ├── searchresults/
    │   ├── search_results.png(this is the full search results page)
    ├── extrapages/
    │   ├── page_1.png
    │   ├── page_2.png
    │   ├── editing_system.png
    │   ├── notifications.png
    │   ├── rankings.png
    │   ├── watch_list.png
    │   ├── change_history.png
    ├── topics/
    │   ├── add_topic_song.png
    │   ├── add_topic_artist.png
    │   ├── add_topic_genre.png
    │   ├── add_topic_playlist.png
    ├── auth/
    │   ├── login.png
    │   ├── register.png

```

### Design Review Protocol

**Before implementing ANY UI component:**

1. **Check** `docs/figma/{relevant-folder}/` for reference screenshots
2. **Review** all images thoroughly - extract:
   - Color palette (hex codes)
   - Spacing patterns (margins, padding, gaps)
   - Typography hierarchy (sizes, weights, line-heights)
   - Border radius values
   - Shadow styles and depths
   - Layout structures (grids, flexbox patterns)
   - Component compositions

3. **Use as inspiration ONLY** - Do not replicate:
   - Improve spacing for better breathing room
   - Enhance interactions with smooth animations
   - Optimize for accessibility (WCAG AA compliance)
   - Consider edge cases and error states
   - Add thoughtful micro-interactions

4. **Document improvements**:
   ```
   "Increased card padding from 16px to 24px for premium feel"
   "Added 200ms ease-out transition for better interaction feedback"
   "Adjusted text contrast from #666 to #555 for accessibility"
   ```

5. **Maintain consistency**: Even when improvising missing components, follow the established design system

### Critical Design Requirements

**DO NOT COPY competitors** - Create completely original design
**Premium quality** - Every pixel should feel polished and intentional
**Consistency** - Unified design language across entire platform
**User-first** - Optimize every interaction for ease and delight

---

## Unified Design System

Build a **comprehensive design system** before feature development:

### Typography Scale
```
H1: [size]px, [weight], [line-height]
H2: [size]px, [weight], [line-height]
H3: [size]px, [weight], [line-height]
H4: [size]px, [weight], [line-height]
Body: [size]px, [weight], [line-height]
Small: [size]px, [weight], [line-height]
```

### Color Palette
```
Primary: #[hex]
Secondary: #[hex]
Accent: #[hex]
Background: #[hex]
Surface: #[hex]
Text Primary: #[hex]
Text Secondary: #[hex]
Text Muted: #[hex]
Border: #[hex]
Success: #[hex]
Error: #[hex]
Warning: #[hex]
Info: #[hex]
```

### Spacing System
```
xs: 4px
sm: 8px
md: 16px
lg: 24px
xl: 32px
2xl: 48px
3xl: 64px
```

### Component Specifications
- **Border Radius**: Consistent values (e.g., 8px for cards, 4px for inputs)
- **Shadows**: Defined elevation levels (sm, md, lg, xl)
- **Transitions**: Standard timing (150ms, 200ms, 300ms with ease-out)
- **Hover Effects**: Unified patterns (opacity, transform, shadow changes)
- **Focus States**: Visible, accessible focus indicators
- **Container Max-Width**: Consistent content boundaries (e.g., 1280px)

---

## Reusable Component Library

### Required UI Components

**Foundation Components**:
```
├── Loading States
│   ├── SkeletonCard
│   ├── SkeletonText
│   ├── Spinner
│   └── ProgressBar
│
├── Cards
│   ├── ArticleCard
│   ├── ArtistCard
│   ├── SongCard
│   ├── GenreCard
│   └── TrendingCard
│
├── Navigation
│   ├── Header
│   ├── Footer
│   ├── Sidebar
│   ├── Breadcrumbs
│   └── Pagination
│
├── Forms
│   ├── TextInput
│   ├── TextArea
│   ├── Select
│   ├── Checkbox
│   ├── Radio
│   ├── FileUpload
│   ├── SearchInput
│   └── FormError
│
├── Feedback
│   ├── Toast
│   ├── Alert
│   ├── InlineError
│   ├── SuccessMessage
│   └── ConfirmationDialog
│
├── Modals
│   ├── Modal (standard)
│   ├── ConfirmModal
│   ├── FullScreenModal
│   └── SlideOver
│
├── Data Display
│   ├── Table
│   ├── DataGrid
│   ├── Badge
│   ├── Tag
│   └── StatCard
│
├── Media
│   ├── ImageGallery
│   ├── AudioPlayer
│   ├── VideoEmbed
│   └── Avatar
│
├── User Elements
│   ├── UserCard
│   ├── ContributorBadge
│   ├── ReputationDisplay
│   └── UserAvatar
│
└── Buttons
    ├── Primary
    ├── Secondary
    ├── Outline
    ├── Ghost
    ├── Danger
    └── IconButton
```

**Each component must have**:
- Default state
- Hover state
- Active/pressed state
- Disabled state
- Loading state (where applicable)
- Error state (where applicable)
- Responsive behavior

---

## Technology Stack

### Backend
- **PHP**: 8.2+
- **Framework**: Laravel 11.x
- **Authentication**: Laravel Breeze (customized)
- **Admin Panel**: Filament v3 (custom themed)

### Frontend
- **Livewire**: 3.x (for dynamic components)
- **Alpine.js**: For lightweight interactions
- **Tailwind CSS**: Utility-first styling
- **Build Tool**: Vite

### Database
- **MySQL**: 8.0+
- **Caching**: Redis (recommended)
- **Search**: MySQL Full-Text or Scout with Meilisearch

### APIs & Integration
- Spotify API (track/artist data)
- YouTube API (video content)
- Genius API (lyrics)
- Optional: Apple Music, Last.fm

---

## File Structure

```
project-root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── ContentController.php
│   │   │   │   └── AnalyticsController.php
│   │   │   ├── Api/
│   │   │   │   ├── SpotifyController.php
│   │   │   │   └── StreamingDataController.php
│   │   │   └── Web/
│   │   │       ├── HomeController.php
│   │   │       ├── ArticleController.php
│   │   │       └── ProfileController.php
│   │   ├── Livewire/
│   │   │   ├── Components/
│   │   │   │   ├── ArticleCard.php
│   │   │   │   ├── SearchBar.php
│   │   │   │   └── TrendingSection.php
│   │   │   ├── Pages/
│   │   │   │   ├── Homepage.php
│   │   │   │   ├── SongDetail.php
│   │   │   │   └── ArtistProfile.php
│   │   │   └── Forms/
│   │   │       ├── ArticleForm.php
│   │   │       └── CommentForm.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       └── TrackViewsMiddleware.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   ├── Article.php
│   │   ├── Song.php
│   │   ├── Artist.php
│   │   ├── Genre.php
│   │   ├── Playlist.php
│   │   ├── Comment.php
│   │   ├── Revision.php
│   │   └── View.php
│   │
│   ├── Services/
│   │   ├── SpotifyService.php
│   │   ├── TrendingService.php
│   │   ├── SEOService.php
│   │   └── StreamingDataService.php
│   │
│   ├── Repositories/
│   │   ├── ArticleRepository.php
│   │   └── UserRepository.php
│   │
│   └── Filament/
│       ├── Resources/
│       └── Pages/
│
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_articles_table.php
│   │   ├── 2024_01_01_000003_create_songs_table.php
│   │   ├── 2024_01_01_000004_create_artists_table.php
│   │   ├── 2024_01_01_000005_create_genres_table.php
│   │   ├── 2024_01_01_000006_create_playlists_table.php
│   │   ├── 2024_01_01_000007_create_comments_table.php
│   │   ├── 2024_01_01_000008_create_revisions_table.php
│   │   ├── 2024_01_01_000009_create_views_table.php
│   │   └── 2024_01_01_000010_create_ai_tasks_table.php
│   ├── seeders/
│   └── factories/
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── admin.blade.php
│   │   │   └── auth.blade.php
│   │   ├── components/
│   │   │   ├── ui/
│   │   │   │   ├── button.blade.php
│   │   │   │   ├── card.blade.php
│   │   │   │   ├── input.blade.php
│   │   │   │   ├── modal.blade.php
│   │   │   │   ├── toast.blade.php
│   │   │   │   └── skeleton.blade.php
│   │   │   └── features/
│   │   │       ├── article-card.blade.php
│   │   │       ├── trending-item.blade.php
│   │   │       └── user-badge.blade.php
│   │   ├── livewire/
│   │   │   ├── homepage.blade.php
│   │   │   ├── song-detail.blade.php
│   │   │   └── artist-profile.blade.php
│   │   ├── pages/
│   │   │   ├── about.blade.php
│   │   │   └── contact.blade.php
│   │   └── auth/
│   │       ├── login.blade.php
│   │       ├── register.blade.php
│   │       └── forgot-password.blade.php
│   │
│   ├── css/
│   │   └── app.css
│   │
│   └── js/
│       ├── app.js
│       └── alpine-components.js
│
├── routes/
│   ├── web.php
│   ├── api.php
│   └── admin.php
│
├── public/
│   ├── css/
│   ├── js/
│   └── images/
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
└── docs/
    ├── readme.md
    └── figma/
```

---

## Database Schema Design

### Core Tables

#### users
```
id, name, email, password, role (user/admin/moderator),
reputation_score, avatar, bio, location, website,
email_verified_at, remember_token, created_at, updated_at, deleted_at
```

#### articles
```
id, user_id, category (song/artist/genre/playlist/term),
title, slug, content, excerpt, featured_image,
view_count, trending_score, seo_score, status (draft/published/review),
published_at, created_at, updated_at, deleted_at
```

#### songs
```
id, article_id, title, artist_id, album, release_date,
duration, genre_id, lyrics, spotify_id, youtube_id,
stream_count, last_stream_update, producer, songwriter,
record_label, created_at, updated_at
```

#### artists
```
id, article_id, name, biography, active_from, active_to,
birth_date, origin_location, spotify_id, website,
social_links (json), created_at, updated_at
```

#### genres
```
id, article_id, name, description, origin_story,
creator, origin_date, parent_genre_id,
created_at, updated_at
```

#### playlists
```
id, article_id, title, description, curator,
platform_link, track_count, created_at, updated_at
```

#### playlist_tracks
```
id, playlist_id, song_id, position, created_at
```

#### comments
```
id, user_id, article_id, parent_id (for replies),
content, upvotes, downvotes, status (active/hidden/deleted),
created_at, updated_at, deleted_at
```

#### revisions
```
id, article_id, user_id, content_snapshot (json),
change_summary, created_at
```

#### views
```
id, article_id, user_id (nullable), ip_address,
user_agent, created_at
```

#### bookmarks
```
id, user_id, article_id, created_at
```

#### tags
```
id, name, slug, type, created_at, updated_at
```

#### article_tag
```
id, article_id, tag_id
```

#### ai_tasks
```
id, task_name, description, category,
status (pending/in_progress/review/completed),
assigned_ai_id, priority, dependencies (json),
started_at, completed_at, notes, created_at, updated_at
```

**Indexes Required**:
- articles: (slug), (category), (status), (trending_score), (view_count)
- songs: (spotify_id), (artist_id), (genre_id)
- views: (article_id, created_at), (ip_address)
- comments: (article_id), (user_id)
- users: (email), (role)

---

## Content Categories & Field Requirements

### 1. **Genres**
**Required Fields**:
- Name, slug, description
- Origin story (rich text)
- Creator(s)/pioneers (text or artist links)
- Original release date/era
- Defining characteristics
- Parent genre (for sub-genres)
- Related genres (many-to-many)

**Metadata**:
- Popular artists (relationship)
- Notable songs/albums (relationship)
- View count, trending score
- SEO fields (meta title, description)

### 2. **Songs**
**Required Fields**:
- Title, slug
- Artist(s) (relationship - can be multiple)
- Album name
- Release date
- Duration (minutes:seconds)
- Genre classification (relationship)
- Lyrics (full text, rich formatting)
- Producer(s), songwriter(s)
- Record label

**Integration Fields**:
- Spotify ID
- YouTube video ID
- Apple Music ID
- Stream count (cached, updates periodically)
- Last stream count update timestamp

**Auto-population**:
When user provides Spotify/YouTube link:
- Extract track data via API
- Pre-fill: title, artist, album, duration, release date
- Fetch album artwork
- Get streaming stats

**Metadata**:
- View count, trending score
- User rating (optional feature)
- SEO fields

### 3. **Artists**
**Required Fields**:
- Name, slug
- Biography (rich text)
- Active years (from/to)
- Birth date (optional)
- Origin location
- Associated acts (relationships)
- Genres (many-to-many)

**Integration Fields**:
- Spotify artist ID
- Social media links (JSON: instagram, twitter, facebook, website)
- Streaming platform profiles

**Relationships**:
- Discography (songs)
- Related artists
- Contributed genres

**Metadata**:
- Notable achievements (rich text)
- Awards (optional structure)
- View count, trending score
- SEO fields

### 4. **Playlists**
**Required Fields**:
- Title, slug
- Description (rich text)
- Curator (user or external)
- Creation date
- Platform (Spotify/Apple Music/YouTube)
- Platform link

**Relationships**:
- Track listing (ordered songs)
- Genre/mood tags

**Metadata**:
- Track count
- Total duration (calculated)
- View count
- Last updated timestamp

### 5. **Music Terminology**
**Required Fields**:
- Term name, slug
- Definition (rich text)
- Origin/etymology
- Usage examples (text or audio clips)
- Category (production/theory/culture/slang)

**Relationships**:
- Related terms
- Category tags

**Metadata**:
- View count
- SEO fields

---

## Homepage Requirements

### Layout Sections

**1. Hero Section**
- Prominent search bar with autocomplete
- Tagline explaining platform purpose
- Clear disclaimer: "Not affiliated with SoundCloud, Spotify, or any streaming platform"
- CTA buttons: "Explore Trending" / "Start Contributing"

**2. Trending Now** (Real-time)
- Algorithm based on:
  - Views in last 24/48 hours
  - Recent edit activity
  - User engagement (comments, bookmarks)
  - External traffic
- Update frequency: Every 15-30 minutes
- Display: Cards with thumbnail, title, category, trend indicator

**3. Categories Navigation**
- Quick access tiles/cards:
  - Genres
  - Artists
  - Songs
  - Playlists
  - Terminology
- Each with icon, count, recent activity indicator

**4. Featured Content**
- Editor picks or community highlights
- Curated weekly/monthly spotlights
- Diverse content types

**5. Recent Updates**
- Latest edited/created articles
- Shows contributor, timestamp, change summary
- Real-time feed using Livewire

**6. Platform Stats**
- Total articles
- Total contributors
- Articles this week
- Most active genre/category

**7. Top Contributors**
- Leaderboard based on:
  - Contribution count
  - Quality score
  - Community votes
- Displays: Avatar, name, reputation, contribution count

**8. Search Functionality**
- Prominent placement (header + hero)
- Autocomplete with category indicators
- Filters: Category, date range, trending
- Search suggestions based on popular queries

### Ranking Algorithm

**Trending Score Calculation**:
```php
trending_score = (
    (recent_views * 0.4) +
    (edit_frequency * 0.2) +
    (comment_activity * 0.2) +
    (bookmark_rate * 0.1) +
    (external_traffic * 0.1)
) * recency_multiplier
```

**SEO Ranking Integration**:
- Track organic search impressions
- Monitor click-through rate
- Factor in backlink quality
- Page authority score

---

## User Features

### User Registration & Profiles

**Registration Flow**:
- Email/password or social login options
- Email verification required
- Welcome onboarding (optional tour)
- Initial profile setup

**User Profile Pages** (`/users/{username}`):
- Avatar, bio, location, website
- Contribution history (articles created/edited)
- Reputation score and badges
- Bookmarked articles
- Activity timeline
- Statistics (total edits, views generated)

**Reputation System**:
- Points for: Creating article (+10), editing (+5), verified edit (+15)
- Penalties for: Rejected edits (-5), spam reports (-20)
- Badges/Achievements:
  - "First Contribution"
  - "Editor" (10 edits)
  - "Expert" (50 quality edits)
  - "Genre Specialist" (20 edits in one genre)
  - Custom admin-awarded badges

### Article Creation & Editing

**Article Workflow**:
1. User clicks "Create Article"
2. Select category (song/artist/genre/playlist/term)
3. Category-specific form with relevant fields
4. Rich text editor (TinyMCE or Tiptap)
5. Image upload for featured image
6. Tag selection
7. Preview before publish
8. Submit for review or publish (based on user reputation)

**Editing System**:
- Anyone can suggest edits
- Changes tracked in revision history
- Edit summary required
- Side-by-side diff view
- Moderators approve/reject suggestions
- High-reputation users can edit directly

**Revision History**:
- All changes tracked with timestamp
- User attribution for each revision
- Restore previous version capability
- Compare revisions functionality
- Change summary for each edit

### Engagement Features

**Bookmarking**:
- Save articles for later
- Personal bookmark collection on profile
- Optional: Organize into custom lists

**Comments & Discussions**:
- Threaded comment system
- Reply to comments
- Upvote/downvote comments
- Report inappropriate content
- Moderation tools (admin/moderators)

**Voting System** (Optional Enhancement):
- Upvote/downvote articles for quality
- Impacts contributor reputation
- Impacts article visibility in feeds

### Gamification Elements

**Achievements**:
- Track milestones
- Display on profile
- Unlock privileges (e.g., direct editing after 50 approved edits)

**Leaderboards**:
- Top contributors this week/month/all-time
- Most viewed articles
- Most active categories
- Rising stars (new users with quality contributions)

---

## Admin Panel

### URL Structure
- `/admin/login` - Admin-only login
- `/admin/dashboard` - Overview
- `/admin/users` - User management
- `/admin/content` - Content moderation
- `/admin/analytics` - Platform analytics
- `/admin/settings` - Configuration

### Admin Features (Filament v3)

**Dashboard**:
- Key metrics (users, articles, views, edits today/week/month)
- Activity timeline
- Flagged content queue
- Quick actions

**User Management**:
- List all users with filters (role, reputation, status)
- View user details and activity
- Edit user roles (user/moderator/admin)
- Ban/suspend users
- Merge duplicate accounts
- Export user data

**Content Moderation**:
- Review pending articles
- Approve/reject suggested edits
- Edit published articles
- Delete spam/inappropriate content
- Restore deleted content
- Feature content on homepage
- Manage categories and tags

**Analytics Dashboard**:
- Traffic overview (page views, unique visitors)
- Most popular content
- User engagement metrics
- Search query analytics
- Trending topics
- Traffic sources
- User growth charts

**Settings**:
- Site configuration (name, tagline, logo)
- SEO settings (default meta tags, sitemap settings)
- API keys (Spotify, YouTube, etc.)
- Email settings
- Feature toggles (comments, voting, auto-publish)
- Reputation system thresholds
- Moderation rules

**Reports Management**:
- Review reported content
- Review reported users
- Action log (who did what, when)
- Ban appeal system

**Category/Taxonomy Management**:
- Create/edit/delete categories
- Manage genre hierarchies
- Tag management
- Featured content curation

**Filament Customization**:
- Custom theme matching main site aesthetic
- Brand colors, typography
- Custom widgets for music-specific data
- Navigation tailored to platform needs

---

## Authentication System

### Laravel Breeze Customization

**URL Routes**:
- `/login` - User login
- `/register` - User registration
- `/forgot-password` - Password reset request
- `/reset-password/{token}` - Password reset form
- `/verify-email` - Email verification
- `/admin/login` - Separate admin login (different guard)

### Auth Pages Design

**All auth pages must**:
- Follow main design system completely
- Use consistent layout component
- Include loading states during submission
- Show inline validation errors
- Display success confirmations
- Have smooth transitions between states
- Be fully responsive

**Login Page**:
- Email/password fields
- "Remember me" checkbox
- "Forgot password?" link
- Social login options (optional)
- Link to registration
- Loading state on submit
- Error handling (invalid credentials, unverified email)

**Registration Page**:
- Name, email, password, password confirmation
- Terms of service checkbox
- Real-time password strength indicator
- Inline validation (email format, password requirements)
- Success message + email verification notice
- Alternative: Multi-step registration for better UX

**Password Reset Flow**:
1. Request reset: Enter email
2. Check email notice
3. Email sent confirmation
4. Reset form: New password + confirmation
5. Success + redirect to login

**Email Verification**:
- Notice on login if unverified
- Resend verification email option
- Verified success page

### Security Features
- CSRF protection (Laravel default)
- Rate limiting on login/registration
- Password strength requirements
- Email verification required
- Session timeout handling
- Brute force protection

---

## Code Quality Standards

### PHP/Laravel Best Practices

**Code Style**:
- Follow PSR-12 coding standards
- Use PHP 8.2+ features (typed properties, enums, readonly)
- Type hint everything (parameters, return types, properties)
- Use strict types: `declare(strict_types=1);`

**Laravel Conventions**:
- Fat models, skinny controllers
- Use service classes for complex business logic
- Repository pattern for data access
- Form requests for validation
- Resource classes for API responses
- Jobs for asynchronous tasks
- Events and listeners for decoupled actions

**Code Organization**:
```php
// BAD - Controller doing too much
public function store(Request $request)
{
    $validated = $request->validate([...]);
    $song = Song::create($validated);
    $spotify = Http::get("spotify.com/api/track/{$request->spotify_id}");
    $song->stream_count = $spotify['popularity'];
    $song->save();
    Cache::forget('trending_songs');
    event(new SongCreated($song));
    return redirect()->route('songs.show', $song);
}

// GOOD - Delegated responsibilities
public function store(StoreSongRequest $request)
{
    $song = $this->songService->createFromSpotify(
        $request->validated()
    );
    
    return redirect()->route('songs.show', $song);
}
```

**No AI-Looking Comments**:
```php
// BAD
// Initialize the variable to store the user's name
$userName = $request->input('name');

// Loop through each song in the database
foreach ($songs as $song) {
    // Display the song title
    echo $song->title;
}

// GOOD - Self-documenting code, minimal comments
$userName = $request->input('name');

foreach ($songs as $song) {
    echo $song->title;
}

// ACCEPTABLE - Complex logic explanation
// Calculate trending score using weighted algorithm:
// recent views (40%) + edits (20%) + engagement (40%)
$trendingScore = $this->calculateTrendingScore($article);
```

**Naming Conventions**:
- Descriptive variable names: `$publishedArticles` not `$data`
- Action-based method names: `getUserContributions()` not `get()`
- Consistent naming patterns
- Avoid abbreviations unless universally understood

**Database Best Practices**:
- Use migrations for all schema changes
- Proper indexing on frequently queried columns
- Soft deletes for user-generated content
- Timestamps on all tables
- Foreign key constraints with cascade rules
- Avoid N+1 queries (use eager loading)

**Security**:
- Never trust user input
- Use Laravel's built-in protection (SQL injection, XSS, CSRF)
- Validate and sanitize all inputs
- Use policies for authorization
- Hash sensitive data
- Rate limit API endpoints
- Secure API keys in environment variables

**Error Handling**:
```php
// Graceful error handling
try {
    $spotifyData = $this->spotifyService->getTrack($spotifyId);
} catch (SpotifyApiException $e) {
    Log::error("Spotify API error: {$e->getMessage()}");
    return back()->with('error', 'Unable to fetch track data. Please enter details manually.');
}
```

### Frontend Best Practices

**Livewire Components**:
- Keep components focused and single-purpose
- Use computed properties for derived data
- Debounce search inputs to reduce server calls
- Lazy load heavy components
- Use wire:loading for better UX

**Alpine.js**:
- Use for simple interactions (dropdowns, modals, tabs)
- Don't replicate Livewire functionality
- Keep Alpine logic minimal and readable

**Tailwind CSS**:
- Use design system classes consistently
- Create custom components for repeated patterns
- Use @apply sparingly (prefer utility classes)
- Maintain responsive design (mobile-first)
- Use Tailwind's built-in dark mode support

**JavaScript**:
- Use modern ES6+ syntax
- Minimal custom JavaScript (let Livewire/Alpine handle most)
- When needed, organize into modules
- Handle errors gracefully
- Progressive enhancement approach