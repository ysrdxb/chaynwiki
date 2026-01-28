# ChaynWiki: Project Vision

## Core Identity
**ChaynWiki** is a premium, community-driven music encyclopedia. It is designed to be the definitive source for music knowledge, surpassing existing wiki platforms by offering a superior, high-fidelity user experience and deep, structured data.

**Tagline:** "Your Community-Driven Music Encyclopedia"

## Design Ethos
We are building a "Figma-Fidelity" application. The design is **not** a generic Bootstrap/Tailwind template. It is a bespoke, high-end experience characterized by:

*   **Theme:** Deep Dark Mode (`bg-[#050511]`), Cyberpunk accents (Neon Blue, Purple, Magenta).
*   **Visual Language:** Glassmorphism, blurred overlays, distinct gradients, and smooth animations.
*   **Typography:** Modern, bold headings (Display fonts) paired with clean sans-serif body text.
*   **Visualizations:** Rich data visualization (e.g., "Music Weather" radar charts) and high-quality imagery (artist cards, hero backgrounds).
*   **Asset Management:** Custom assets are generated or sourced to match the *exact* vibe of the Figma references.

**Reference Material:**
*   See `docs/figma/` for source designs.
*   We aim to *exceed* the quality of these mocks, not just match them.

## Functional Goals
1.  **Wiki Core:** A robust system for users to Create, Edit, and Curate content.
    *   **Content Types:** Artists, Songs, Genres, Playlists, Music Terminology.
    *   **Versioning:** Full revision history and moderation tools.
2.  **Real-Time Data:** Integration with external APIs (Spotify, YouTube) to provide live data (stream counts, trending status).
3.  **Community Engine:** Reputation systems, leaderboards, and "Quick Action" contribution workflows.
4.  **Discovery:** Advanced search, "Music Weather" trends, and serendipitous browsing paths.

## Implementation Principals
*   **Tech Stack:** Laravel 11, Livewire 3, Tailwind CSS, Alpine.js, Filament v3 (Admin).
*   **Architecture:** Modular Service/Repository pattern for core logic.
*   **User Experience:** "Don't Make Me Think" - intuitive flows for contribution and discovery.
*   **Performance:** Fast load times despite rich visuals (optimization is key).
