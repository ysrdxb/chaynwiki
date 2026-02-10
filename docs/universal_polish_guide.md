# ChaynWiki — Universal Design & Polishing Guide (Zero-Tolerance)

> **Purpose**: This is the master blueprint for the site's design system. Every page (Home, Wiki, Artist, Genre, Song, Search, Profile, Auth) must adhere to these global patterns to achieve an "Ultra-Premium" aesthetic that matches the Figma source of truth.

> **Figma Source**: `docs/figma/chaynwiki/`
> - Homepage Reference: `Home-1.png` (for section components) and `Home.png` (for branding/spirit).
> - **Note**: We keep our *current layout* of sections as seen in `welcome.blade.php`, but use the Figma design for the *styling* within those sections.

---

## 1. Global Design Language (The "System")

Every component on any page MUST follow these rules.

### A. Color Palette & Surroundings
- **Background**: Deep Ocean Black (`#0d1117`).
- **Surfaces/Cards**: Glassmorphic Dark (`#161b22` at 60% opacity with backdrop blur).
- **Accents**: 
  - Brand Blue: `#3b82f6` (for CTAs and active states).
  - Subtle Borders: `white/5` (default), `white/15` (hover).
- **Glassmorphism**: Use `backdrop-blur-xl` on all overlays, navbars, and cards.

### B. Universal Card System (`.card-premium-unified`)
Every card on the site (Article cards, Topic cards, Stat cards) must share these traits:
- **Radius**: `20px` to `24px` (consistent rounding).
- **Border**: `1px solid rgba(255,255,255,0.05)`.
- **Hover State**:
  - Border: Increase to `white/15` or `blue-500/30`.
  - Transform: `translateY(-4px)` with smooth `duration-300`.
  - Shadow: Deep glow `shadow-lg shadow-blue-500/10`.
  - Gradient: Subtle radial glow from bottom-left (optional for high-tier cards).

### C. Input Fields & Forms
- **Style**: "Pill" shape (`rounded-full`) or very soft squares (`rounded-2xl`).
- **Background**: Elevated surface (`#1c2128`).
- **Border**: Default `white/8`. Focus `white/20` or `blue-500`.
- **Placeholder**: Subtle `white/20`.
- **Icons**: Always colored (blue-400 or similar) inside inputs.

### D. Buttons & CTAs
- **Primary (Action)**: White background, Black text (`#0d1117`), Pill shape, Extra Bold.
- **Secondary (Ghost)**: `bg-white/5` with `border-white/10`. Text `white`.
- **Tertiary (Transparent)**: `text-white/50`, hover `text-white`.
- **Micro-interactions**: Every button should have a scale effect on hover (e.g., `group-hover:scale-110` for an icon circle inside).

---

## 2. Homepage Specifics (Structure Maintenance)

We are keeping the 10 sections from `welcome.blade.php`. Use `Home-1.png` as the styling guide for components.

| Section | Styling Guide | Key Polish Point |
|---------|---------------|------------------|
| **Header** | `Home-1.png` | Sticky glassmorphism, black logo, center search. |
| **Hero** | `Home-1.png` | Left-aligned bold text, Pill-style search. |
| **New Topics** | `Home-1.png` (slider) | Cards with initials/uploader name, no scrollbar. |
| **Music Weather** | Custom (Radar) | Match SVG colors to metrics (Pink, Cyan, etc). |
| **Browse by Category** | `Home-1.png` | Unique icons for Genre vs Artist vs Song. |
| **Trending Articles** | `Home-1.png` | Ranking badges (#1, #2). |
| **Ranked Slider** | `Home.png` / `Home-1.png` | Top overlay rank numbers (01, 02). |
| **Community Insights**| `Home-1.png` | Bold numbers, real dynamic data. |
| **CTA / Footer** | `Home.png` | Massive text `CHAYNWIKI` or `SOUNDBOOK` branding. |

---

## 3. Interior Pages (Global Consistency)

### A. Topic Detail (Artist/Genre/Song)
- **Reference**: `Artist Detail.png`, `Genre .png`, `Song Detail.png`.
- **Layout**: Large header image with "Glassy Overlay" info block.
- **Content**: Use "Cards" for Discography/Gallery sections — exact same `.card-premium-unified` as homepage.
- **Typography**: Header text should be massive and uppercase.

### B. Contributor & Profile
- **Reference**: `Contributor.png`, `Change History.png`.
- **Layout**: Clean list-style or card-style activities.
- **Buttons**: Every action (Edit, Follow) must match the Global Button style.

---

## 4. Execution Ritual

1. **Check Global CSS**: Ensure `master-layout.blade.php` or `premium.css` has the root variables defined.
2. **Apply Universal Class**: Ensure all cards use the same class.
3. **Verify Every Hover**: Go through every link and card; if it doesn't move or glow, it's not polished.
4. **Consistency Audit**: Check the "Submit" button on the Header vs the "Submit" on the CTA — they must be identical.
