# ChaynWiki Project Tasks

- [x] **Phase 1: Foundation & Setup**
    - [x] Initialize Laravel 12 project
    - [x] Configure environment (database, app settings)
    - [x] Install TALL stack (Tailwind, Alpine, Livewire, Laravel)
    - [x] Install Filament v3 for Admin Panel
    - [x] Set up front-end asset building (Vite)
    - [x] Define Design System (Color palette, Typography, Spacing variables)

- [x] **Phase 2: Database Modeling**
    - [x] Create `users` migration (extended profile fields)
    - [x] Create `articles` migration (polymorphic base for content)
    - [x] Create migrations for content types: `songs`, `artists`, `genres`, `playlists`
    - [x] Create auxiliary migrations: `comments`, `revisions`, `views`, `bookmarks`, `tags`
    - [x] Define Eloquent Models and Relationships
    - [x] Create Factories and Seeders

- [x] **Phase 3: Authentication & User Profiles**
    - [x] Install Laravel Breeze
    - [x] Implement Custom User Profile Page (`/user/{username}`)
    - [x] Implement Reputation Logic
    - [x] Implement Role-based Access (Admin/Mod/User)

- [x] **Phase 4: Public Pages & Homepage (High Fidelity)**
    - [x] Design Premium Homepage (Figma Match)
    - [x] Implement "Music Weather" Visualization
    - [x] Implement "Quick Action" Contribution Strip
    - [x] Implement "New Topics" Card Grid
    - [x] Implement "Discover" Tags Section
    - [x] Implement Footer & Navigation (ChaynWiki Branding)

- [x] **Phase 5: Core Wiki Functionality (The "Engine")**
    - [x] **Article Repository:** Build abstract service for handling article CRUD.
    - [x] **Create Flow:**
        - [x] Build Category Selection Modal/Page.
        - [x] Build Multi-step Creation Form (Livewire).
        - [x] Implement Rich Text Editor (TinyMCE/Tiptap).
    - [x] **View Pages:**
        - [x] Design/Build `Song` Detail Page (Lyrics, Credits, Stream Stats).
        - [x] Design/Build `Artist` Profile Page (Discography, Bio).
        - [x] Design/Build `Genre` History Page.
    - [ ] **Edit & Revision:**
        - [ ] specific "Edit Mode" for articles.
        - [ ] Revision history tracking (diff view).
    - [ ] **Search:** Implement full global search (Elastic/Meili or robust SQL).

- [x] **Phase 6: Engagement & Community**
    - [x] **Comments:** Threaded comment component for articles.
    - [x] **Reactions:** Like/Bookmark functionality (Votes implemented).
    - [ ] **Leaderboards:** "Top Contributors" page.
    - [ ] **Notifications:** User notification system (edits, replies).

- [x] **Phase 7: Integrations (Real-Time Data)**
    - [x] **Spotify Service:** Fetch track metadata and stream counts.
    - [x] **YouTube Service:** Fetch and embed official videos.
    - [ ] **Genius Service:** Lyrics fetching fallback.
    - [x] **Auto-Fill:** Button to "Populate from Spotify Link" in creation form.

- [ ] **Phase 8: Administration (Filament)**
    - [ ] **Dashboard:** Stats overview (Total Wikis, Active Users).
    - [ ] **Content Resource:** Manage/Delete/Feature articles.
    - [ ] **User Resource:** Ban/Promote users.
    - [ ] **Moderation:** Review queue for pending edits.

- [ ] **Phase 9: Polish & Launch**
    - [ ] **SEO:** Dynamic Meta Tags & OpenGraph images.
    - [ ] **Performance:** Redis caching for "Trending" queries.
    - [ ] **Mobile:** Ensure perfect responsiveness on mobile devices.
    - [ ] **Final Review:** Audit against `docs/figma` visuals.