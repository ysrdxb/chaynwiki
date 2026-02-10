# ChaynWiki — Homepage Final Polish Guide (Zero-Tolerance)

> **Purpose**: This document is the single source of truth for the AI assistant when polishing the ChaynWiki homepage. Every section must be refined to professional, production-ready quality — matching or exceeding the Figma reference while maintaining our unique identity.

> **Client Mandate (from `docs/readme.md`)**: "Use the Figma design as a foundation. Do not copy it exactly. But improve it where needed." — Full creative control. Focus on user experience. Make it optimal.

---

## Global Design Tokens (Enforced Everywhere)

These values are the law. Every section, card, and element MUST use these tokens consistently.

| Token               | Value                         | Usage                              |
|----------------------|-------------------------------|--------------------------------------|
| `--bg-primary`       | `#0d1117`                     | Page background, section bg          |
| `--bg-surface`       | `#161b22`                     | Card backgrounds, elevated surfaces  |
| `--bg-elevated`      | `#1c2128`                     | Inputs, dropdowns, hover surfaces    |
| `--brand-primary`    | `#3b82f6`                     | CTAs, active states, accent dots     |
| `--border-subtle`    | `rgba(255,255,255,0.05)`      | Default card/section borders         |
| `--border-active`    | `rgba(255,255,255,0.10)`      | Hover borders, focus states          |
| `--text-primary`     | `#ffffff`                     | Headings                             |
| `--text-secondary`   | `rgba(255,255,255,0.50)`      | Body text, descriptions              |
| `--text-muted`       | `rgba(255,255,255,0.30)`      | Labels, metadata, timestamps         |
| `--text-ghost`       | `rgba(255,255,255,0.20)`      | Placeholders, disabled text          |
| `--radius-card`      | `20px`                        | All cards                            |
| `--radius-pill`      | `9999px`                      | Buttons, pills, badges               |
| `--radius-input`     | `9999px`                      | Search inputs                        |
| `--font-primary`     | `'Plus Jakarta Sans'`         | ALL text. No exceptions.             |
| `--max-width`        | `1400px`                      | Content container                    |
| `--px-container`     | `32px` (px-8)                 | Horizontal padding                   |

---

## Global Spacing Rules

| Context                    | Value         | Tailwind       |
|----------------------------|---------------|----------------|
| Section vertical padding   | `96px`        | `py-24`        |
| Section title → content    | `48px`        | `mb-12`        |
| Card internal padding      | `32px`        | `p-8`          |
| Card gap (grid)            | `24px`        | `gap-6`        |
| Card gap (slider)          | `24px`        | `gap-6`        |
| Slider card min-width      | `420px` (md+) | `md:min-w-[420px]` |
| Label → value spacing      | `24px`        | `mb-6`         |
| Button padding             | `12px 24px`   | `px-6 py-3`    |

---

## Global Hover & Interaction Rules

Every interactive element MUST have these states:

| Element       | Default                      | Hover                                   | Active/Focus                |
|---------------|------------------------------|------------------------------------------|-----------------------------|
| Card          | `border-white/5`             | `border-white/15`, `translateY(-4px)`, `box-shadow: 0 15px 30px rgba(0,0,0,0.4)` | — |
| Button (Primary) | `bg-white text-[#0d1117]` | `bg-gray-100`, `translateY(-2px)`       | `ring-2 ring-blue-500/50`  |
| Button (Secondary) | `bg-white/5 border-white/8` | `bg-white/10 border-white/15`       | —                           |
| Nav Link      | `text-white/50`              | `text-white`                             | `text-blue-400`            |
| Pill/Badge    | `bg-white/5 border-white/8`  | `bg-white/10 border-white/15`           | —                           |
| Image         | `grayscale-[0.2]`            | `grayscale-0 scale-105` (700ms)         | —                           |
| Icon Circle   | `bg-blue-500/10`             | `bg-blue-500` (with icon color → white) | —                           |

**Transition**: ALL hover effects must use `transition-all duration-300` minimum.

---

## Figma Reference Screenshots

Located at `docs/figma/homepage/`:
- `hero_section.png` — Hero layout, search bar, action buttons
- `home.png` / `home2.png` — Overall page composition
- `what_can_you_find.png` — Category cards
- `the_beat_of_the_moment.png` — Trending/featured section
- `core_features.png` — Feature cards
- `about_section.png` — About/info section
- `footer.png` — Footer layout

**Rule**: Before polishing any section, the AI MUST view the corresponding Figma screenshot to compare against the current implementation.

---

## Section-by-Section Polish Specifications

### 1. HEADER / NAVIGATION
**File**: `resources/views/components/navigation.blade.php`

**Requirements**:
- Height: `h-20` (80px) — fixed
- Logo: `text-2xl font-black uppercase tracking-tight` in white. No color accents on logo text.
- Nav links: `text-[14px] font-bold text-white/50`. Hover → `text-white`. Gap between links: `gap-1`, internal padding: `px-5 py-2`
- Search bar (center): Must be centered with `flex-1 max-w-sm mx-12`. Rounded (`rounded-full`), bg `#1c2128`, border `white/10`.
- Submit Topic button: `bg-blue-600 hover:bg-blue-500 text-white text-[13px] font-black uppercase tracking-widest rounded-full px-6 py-2.5 shadow-lg shadow-blue-600/20`. Must have `ml-4` gap from nav links.
- Avatar: `w-9 h-9 rounded-full ring-1 ring-white/10 hover:ring-white/30`.
- Dropdown: `bg-[#161b22] border border-white/5 rounded-2xl shadow-2xl w-56`.
- On scroll: `bg-[#0d1117]/95 backdrop-blur-xl`. Always show `border-b border-white/5`.
- Mobile menu: Full-width, `bg-[#0d1117]/98 backdrop-blur-xl`. Links should be `block px-4 py-3` with `uppercase tracking-widest`.

**Zero-Tolerance Checks**:
- [ ] Logo and nav links vertically centered
- [ ] No layout shift on scroll state change
- [ ] Dropdown animation: `ease-out 200ms` enter, `ease-in 150ms` leave
- [ ] Mobile hamburger icon toggles between menu/close SVGs

---

### 2. HERO SECTION
**File**: `resources/views/welcome.blade.php` (lines ~27–109)

**Requirements**:
- Padding: `pt-32 pb-16`. Background: `bg-[#0d1117]`.
- Headline: `text-[48px] md:text-[64px] font-black text-white uppercase leading-[1.1] tracking-tight`. Font must be `Plus Jakarta Sans`.
- Subtitle (disclaimer): `text-white/50 text-[14px] font-medium mb-10`.
- Search bar: `max-w-[800px]`, pill style. Input: `bg-transparent px-6 py-3 text-[15px] placeholder-white/20`. Button: `bg-white hover:bg-gray-100 text-[#0d1117] text-[14px] font-bold rounded-full px-6 py-3` with blue arrow circle (`w-5 h-5 bg-[#3b82f6]`).
- Action buttons: `flex-wrap gap-4 mb-16`. Primary: white bg, black text, pill shape. Secondary: transparent with `border-white/8`.
- Quick Action Strip: Label `text-white/30 text-[11px] font-bold uppercase tracking-widest`. Pills must use `.action-pill` class from `premium.css`.

**Zero-Tolerance Checks**:
- [ ] Hero headline is LEFT-ALIGNED (not centered)
- [ ] Search bar placeholder text is subtle (`white/20`) not bright
- [ ] No orphaned words on headline line break (use `<br>` strategically)
- [ ] Action buttons have arrow circles with hover scale `group-hover:scale-110`
- [ ] Quick action pills have the 6px blue dot indicator

---

### 3. NEW TOPICS SECTION (Horizontal Slider)
**File**: `resources/views/welcome.blade.php` (lines ~111–202)

**Requirements**:
- Section padding: `py-24`. Border top: `border-white/5`.
- Section title: Use `.section-title` class (`32px font-[800]`). Subtitle: `.section-subtitle`.
- Navigation arrows: `w-12 h-12 rounded-full border border-white/10`. Disabled state: `text-white/10 border-white/5 cursor-not-allowed`.
- Slider: `overflow-x-auto scrollbar-hide`. Cards min-width: `min-w-[340px] md:min-w-[420px]`. Gap: `gap-6`.
- Card structure:
  - Image: `aspect-video rounded-2xl overflow-hidden mb-6` with `grayscale-[0.2]` → hover `grayscale-0 scale-105 duration-700`.
  - Genre badge: `absolute top-4 left-4` — `text-blue-400 text-[10px] font-black uppercase tracking-[0.2em] bg-black/40 backdrop-blur-md px-3 py-1 rounded`.
  - Title: `text-[24px] font-bold tracking-tight` → hover `text-blue-400`.
  - Description: `text-white/40 text-[14px] font-medium leading-relaxed line-clamp-2`.
  - Metadata row: User avatar (6px circle with initial), view count with star icon, edit count.
- Image fallback: `onerror` handler must be present on every `<img>`.
- User attribution: Must show uploader initials + name on every card.

**Zero-Tolerance Checks**:
- [ ] Slider has NO visible scrollbar (native or custom)
- [ ] Navigation arrows correctly enable/disable based on scroll position
- [ ] Cards have consistent height — `line-clamp-2` prevents overflow
- [ ] Metadata row uses `gap-4` and `text-[12px] font-bold text-white/30`
- [ ] Image fallback works silently (no broken icon flash)

---

### 4. REAL-TIME MUSIC WEATHER (Radar)
**File**: `resources/views/welcome.blade.php` (lines ~206–439)

**Requirements**:
- Two-column layout: `lg:flex gap-16`. Left: SVG radar (50%). Right: Info cards (50%).
- Radar: 400x400 SVG with diamond shape. 3 concentric guide diamonds at 33%, 66%, 100% opacity `white/3`, `white/5`, `white/8`.
- Data polygon: `fill="rgba(59,130,246,0.15)"` with `stroke="#3b82f6" stroke-width="2"`.
- Interactive points: Circles that expand on hover (`r=6` → `r=12`) with distinct colors per metric.
- Labels: `text-[11px] font-black uppercase tracking-widest`. Default `opacity-20`, active → full opacity with metric color.
- Info cards: `bg-[#161b22]/60 border border-white/5 rounded-[20px] p-6`. Each has icon circle (`w-10 h-10 rounded-full`), title (`text-[18px] font-bold`), description (`text-white/40 text-[13px]`).
- Metrics must be: Submission Velocity, Edit Activity, Community Consensus, Trend Intensity.
- Card active state: `bg-[#1c2128]` when corresponding radar point is selected.
- Alpine.js `x-data` with `active` and `hovered` states.

**Zero-Tolerance Checks**:
- [ ] Radar polygon updates correctly from `$musicWeather` data
- [ ] Labels use correct colors (pink, cyan, pink-300, blue-500)
- [ ] Card hover sets `active` state and highlights corresponding radar point
- [ ] SVG is responsive and centered in its container
- [ ] No PHP errors if `$musicWeather` is missing keys (use `array_merge` defaults)

---

### 5. BROWSE BY CATEGORY (Card Grid)
**File**: `resources/views/welcome.blade.php` (lines ~442–523)

**Requirements**:
- Grid: `grid-cols-1 md:grid-cols-3 gap-8`. Only first 3 categories shown.
- Card: `.card-premium-unified p-8 bg-[#161b22]/60 border border-white/5`.
- Icon circle: `w-12 h-12 rounded-full bg-blue-500 text-white shadow-lg shadow-blue-500/10 mb-8`.
- Title: `text-[24px] font-bold tracking-tight mb-4`.
- Description: `text-white/40 text-[15px] font-medium leading-relaxed mb-10`.
- Footer: `flex justify-between mt-auto`. Count label: `text-white/20 text-[12px] font-bold uppercase tracking-widest`. Explore button: `px-6 py-2 bg-white/5 border border-white/5 rounded-full text-[13px] font-bold` → hover `bg-blue-500 border-blue-500`.
- Each category icon must be unique (music note for genre, person for artist, play for song).

**Zero-Tolerance Checks**:
- [ ] All 3 cards same height (flexbox stretch)
- [ ] Explore button hover turns fully blue with white text
- [ ] Count shows real data from `$categoryCounts`
- [ ] Icon inside circle uses `stroke-width="2.5"` for consistency

---

### 6. TRENDING ARTICLES (Grid)
**File**: `resources/views/welcome.blade.php` (lines ~525–575)

**Requirements**:
- Grid: `grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6`.
- Card: `rounded-[24px] border border-white/5 bg-[#161b22]/40 backdrop-blur-sm p-8`. Hover: `border-blue-500/30 bg-[#161b22]/60 shadow-lg shadow-blue-500/10 duration-300`.
- Icon circle: `w-12 h-12 rounded-full bg-blue-500/10` → hover `bg-blue-500`. Icon color: `text-blue-500` → hover `text-white`.
- Trending badge: `px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest`.
- Title: `text-[24px] font-black uppercase tracking-tighter` → hover `text-blue-400`.
- User attribution: Avatar circle with initial + username, same pattern as New Topics.

**Zero-Tolerance Checks**:
- [ ] Badge shows correct `#N Trending` rank
- [ ] Category-specific icons (artist, song, genre, default)
- [ ] Cards have `backdrop-blur-sm` for glassmorphic effect
- [ ] View count formatted with `number_format()`

---

### 7. RANKED ARTICLES (Horizontal Slider)
**File**: `resources/views/welcome.blade.php` (lines ~578–652)

**Requirements**:
- Same slider pattern as New Topics (arrows, scroll, min-width).
- Card: Same structure as New Topics but with:
  - Rank overlay: `absolute top-4 left-4` — `text-[24px] font-black opacity-30`.
  - Genre label: `absolute top-4 right-4`.
  - View count pill: `bg-white/5 px-3 py-1 rounded-full border border-white/5` with star icon.
  - Ranking label: `text-white/20 uppercase tracking-widest text-[10px]` with `text-blue-400 font-bold` value.

**Zero-Tolerance Checks**:
- [ ] Ranking shows `#` prefix (e.g., `#95`)
- [ ] Rank overlay number is zero-padded (e.g., `01`, `02`)
- [ ] Image fallback handler present
- [ ] Slider arrows match New Topics in style and behavior

---

### 8. COMMUNITY INSIGHTS (Stat Grid)
**File**: `resources/views/welcome.blade.php` (lines ~654–710)

**Requirements**:
- Grid: `grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6`.
- Card: `.card-premium-unified bg-[#161b22]/60 border border-white/5 p-8 flex flex-col min-h-[200px]`.
- Label: `text-white/40 text-[12px] font-bold uppercase tracking-widest mb-6`.
- Value: `text-[48px] font-black text-white leading-none tracking-tighter mb-auto`.
- Arrow circle: `w-10 h-10 rounded-full bg-blue-500/10 border border-white/10` at bottom-right.
- Stats MUST use real dynamic data from `$heroStats` and `$musicPulse`, NOT hardcoded strings like "25,000+".

**Zero-Tolerance Checks**:
- [ ] Values use real database counts, not placeholders
- [ ] All 4 cards same height via `min-h-[200px]` + flexbox
- [ ] Arrow icon transitions on card hover
- [ ] Number formatting uses `number_format()`

---

### 9. CTA SECTION
**File**: `resources/views/welcome.blade.php` (lines ~712–738)

**Requirements**:
- Padding: `py-32`. Background glow: `bg-blue-500/5 blur-[120px]` centered blob.
- Headline: `text-[40px] md:text-[64px] font-black text-white tracking-tighter leading-[1.0] max-w-4xl mx-auto text-center`.
- CTA button: `bg-white hover:bg-gray-100 px-10 py-5 rounded-full shadow-2xl shadow-black/40`. Text: `text-[18px] font-black uppercase tracking-tighter`. Arrow circle: `w-10 h-10 bg-blue-500 rounded-full group-hover:scale-110`.

**Zero-Tolerance Checks**:
- [ ] Background blob is centered and doesn't cause horizontal scroll
- [ ] Button shadow is visible and adds depth
- [ ] Text is not too wide — constrained to `max-w-4xl`

---

### 10. FOOTER
**File**: `resources/views/components/footer.blade.php`

**Requirements**:
- Padding: `pt-32 pb-24`. Border top: `border-white/5`.
- Giant brand name: `text-[100px] sm:[140px] md:[180px] lg:[220px] font-black text-white uppercase select-none text-center tracking-[-0.05em]`.
- Nav links: `flex flex-wrap justify-center gap-x-12 gap-y-4 mb-16`. Style: `text-white/40 hover:text-white text-[14px] font-bold uppercase tracking-widest`.
- Copyright: `text-white/20 text-[13px] font-medium text-center`.

**Zero-Tolerance Checks**:
- [ ] Giant text doesn't overflow on mobile (uses responsive sizing)
- [ ] Links include: Home, Wiki, Artists, Genres, Log in
- [ ] No unnecessary decorations or gradients — keep it clean

---

## Execution Rules for the AI

1. **Before editing any section**: View the matching Figma screenshot from `docs/figma/homepage/` and compare. Note every discrepancy.
2. **One section at a time**: Complete one section fully, verify it loads without errors, then move to the next.
3. **No inline styles**: Use Tailwind classes or `premium.css` classes. Only use `style=""` for `font-family` where Tailwind doesn't cover it.
4. **Test after every edit**: The homepage MUST load at `http://localhost/chaynwiki/public` without PHP errors after each change.
5. **Dynamic data only**: Replace ALL hardcoded stat numbers with real data from the controller (`$heroStats`, `$musicPulse`, `$categoryCounts`).
6. **Preserve functionality**: All Alpine.js interactions (sliders, radar hover, dropdowns) must continue working.
7. **Image reliability**: Every `<img>` must have an `onerror` fallback handler.
8. **Responsive**: Every section must look correct on mobile (375px), tablet (768px), and desktop (1440px).
9. **Performance**: No unnecessary DOM elements. Keep SVGs inline. Lazy-load images below the fold.
10. **Copy clarity**: No jargon. No metaphors. Clear professional English only.

---

## Section Processing Order

```
1. Header / Navigation (navigation.blade.php)
2. Hero Section (welcome.blade.php)
3. New Topics Slider
4. Music Weather Radar
5. Browse by Category
6. Trending Articles
7. Ranked Articles Slider
8. Community Insights
9. CTA Section
10. Footer (footer.blade.php)
```

For each section, follow this checklist:
- [ ] View Figma reference screenshot
- [ ] Compare current implementation vs Figma
- [ ] Fix spacing (margins, padding)
- [ ] Fix typography (size, weight, tracking, color)
- [ ] Fix borders and border-radius
- [ ] Fix hover states and transitions
- [ ] Fix responsive behavior
- [ ] Verify: no PHP errors, no console errors
- [ ] Mark section as complete
