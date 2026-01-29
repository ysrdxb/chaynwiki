# ChaynWiki Master Work Plan
## AI Agent Collaboration Document

**Last Updated**: 2026-01-29
**Version**: 1.0

---

## 🚨 CRITICAL RULES FOR ALL AI AGENTS

1. **Check task status BEFORE starting** - Do not work on tasks marked `IN_PROGRESS` by another agent
2. **Update status immediately** when starting a task
3. **Mark completion** with timestamp when done
4. **Follow design guidelines** - NOT 100% Figma, make it MORE advanced
5. **Test your work** before marking complete
6. **Document changes** in the task notes

---

## 📋 TASK STATUS LEGEND

| Status | Meaning |
|--------|---------|
| `PENDING` | Not started, available for any agent |
| `IN_PROGRESS` | Being worked on - DO NOT TOUCH |
| `REVIEW` | Completed, needs review |
| `DONE` | Completed and verified |
| `BLOCKED` | Cannot proceed, dependency issue |

---

## 🎨 DESIGN REQUIREMENTS

### DO NOT Follow Figma 100%
- Use Figma as **inspiration only**
- Create **more advanced, premium** designs
- Add **micro-interactions and animations**
- Implement **dark mode excellence** (deep blacks, subtle gradients)
- Use **glassmorphism** where appropriate
- Add **hover states** on all interactive elements
- Ensure **mobile-first** responsive design

### Design System Standards
```css
/* Colors */
--bg-primary: #050511;
--bg-card: #0A0A14;
--border-subtle: rgba(255, 255, 255, 0.1);
--text-primary: #FFFFFF;
--text-muted: #6B7280;
--accent-brand: #3B82F6;

/* Spacing */
--section-padding: 96px (py-24);
--card-padding: 32px;
--gap-standard: 32px;

/* Borders */
--radius-card: 24px;
--radius-button: 9999px (full);
--border-section: 1px solid rgba(255, 255, 255, 0.1);
```

---

## 📁 PROJECT STRUCTURE

```
chaynWiki/
├── docs/
│   ├── work_plan.md (THIS FILE)
│   ├── tasks.md (Task tracking)
│   ├── advanced_features_proposal.md (Feature specs)
│   └── prompt.md (Original requirements)
├── app/
│   ├── Services/
│   │   └── OllamaService.php (AI integration)
│   ├── Livewire/
│   │   └── [Feature components]
│   └── Models/
├── resources/views/
│   ├── components/ (Reusable UI)
│   ├── livewire/ (Livewire views)
│   └── welcome.blade.php (Homepage)
└── public/
    └── images/
```

---

## 🔧 TECH STACK

| Technology | Version | Purpose |
|------------|---------|---------|
| Laravel | 11.x | Backend framework |
| Livewire | 3.x | Dynamic components |
| Alpine.js | 3.x | JS interactions |
| Tailwind CSS | 3.x | Styling |
| MySQL | 8.x | Database |
| Ollama | Latest | Free local AI |
| Chart.js | 4.x | Visualizations |
| Vis.js | Latest | Network graphs |

---

## 📊 PHASE OVERVIEW

### Phase 1: Foundation (Current)
- [x] Basic homepage design
- [x] Navigation component
- [x] Footer component
- [x] Section standardization
- [ ] Ollama service integration
- [ ] Database schema for AI features

### Phase 2: AI Core
- [ ] AI Content Generator
- [ ] AI Chat Assistant
- [ ] AI Lyric Analysis

### Phase 3: Advanced Features
- [ ] Smart Search
- [ ] Gamification System
- [ ] Visual Knowledge Explorer

### Phase 4: Polish
- [ ] Design enhancements
- [ ] Performance optimization
- [ ] Mobile responsiveness

---

## 🤖 AI AGENT INSTRUCTIONS

### When Taking a Task:
1. Read this document fully
2. Check `docs/tasks.md` for available tasks
3. Update task status to `IN_PROGRESS`
4. Add your agent ID and start time
5. Work on the task
6. Update status to `REVIEW` or `DONE`
7. Add completion notes

### Code Standards:
- Use PHP 8.2+ features
- Type hint everything
- Follow PSR-12
- Use Livewire 3 conventions
- No inline styles (use Tailwind)
- Comment complex logic only

### Commit Messages:
```
[FEATURE] Add AI content generator
[FIX] Resolve search pagination
[DESIGN] Enhance card hover states
[REFACTOR] Extract article service
```

---

## 🔗 KEY FILES TO KNOW

| File | Purpose |
|------|---------|
| `welcome.blade.php` | Homepage layout |
| `components/navigation.blade.php` | Header nav |
| `components/footer.blade.php` | Footer |
| `app/Services/OllamaService.php` | AI integration |
| `docs/tasks.md` | Task tracking |

---

## ⚡ QUICK START FOR NEW AGENTS

1. Read `docs/prompt.md` for project vision
2. Read `docs/advanced_features_proposal.md` for feature specs
3. Check `docs/tasks.md` for available work
4. Pick a `PENDING` task
5. Update status and begin work

---

*This document is the source of truth for all AI agents working on ChaynWiki.*
