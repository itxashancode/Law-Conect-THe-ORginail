# 🎨 Law-Conect UI/UX Design Audit
## Storyboard-Based Analysis for Premium Legal Platform (NON-SaaS)

**Analyst:** Claude Code - UI/UX Specialist
**Date:** 2026-04-02
**Design Direction:** Luxury Editorial → Not SaaS
**Animation Framework:** AOS (Animate On Scroll) + Custom CSS

---

## 📋 Executive Summary

Law-Conect is a **high-end legal marketplace** that must **avoid SaaS aesthetics**. The current design uses excellent luxury elements (gold/onyx/linen palette, bespoke typography), but suffers from **inconsistent implementation** across dashboards and authentication flows which resemble B2B SaaS products.

**Critical Finding:** There are **three distinct design languages** in the codebase:
1. ✅ **Public Pages** - Bespoke luxury editorial (excellent)
2. ❌ **Auth Pages** - Generic Breeze SaaS template (mismatched)
3. ❌ **Dashboard Layouts** - Classic SaaS admin panel (wrong tone)

**Priority:** Unify all touchpoints under a **single luxury editorial identity** where every interaction feels like a premium legal service, not a productivity tool.

---

## 🎯 Brand Positioning: NON-SaaS

### What We Are
- **A premium legal concierge** - High-touch, exclusive, white-glove service
- **Editorial in spirit** - Think Vogue, not Asana
- **Storytelling platform** - Each page narrates excellence and trust
- **Gold-embossed experience** - Physical-world luxury translated digitally

### What We Are NOT
- ❌ Not a B2B SaaS dashboard
- ❌ Not a data-dense productivity app
- ❌ Not card-grid based
- ❌ Not "modern flat" design
- ❌ Not bright primary colors (no blue/red action buttons)
- ❌ Not sidebar-navigation-as-hero (dark sidebars kill editorial flow)

---

## 📊 Current State Analysis

### 1. PUBLIC FACING PAGES ✅ (Excellent Foundation)

**Pages:** Home, Search, Lawyer Profile

#### Strengths:
- **Color Palettes:** Onyx (#0D0D0D) + Gold (#D4AF37) + Linen (#F9F7F2) - Perfect luxury combo
- **Typography:** Instrument Serif + Cormorant Garamond + Outfit - editorial hierarchy works
- **Negative Space:** Generous padding (pt-60, py-40) creates breathing room
- **Animations Present:**
  - `animate-reveal` with staggered delays (0.2s, 0.4s, 0.6s)
  - Hover reveals on cards (scale-105, translate-y effects)
  - Smooth scroll via Lenis
  - Gold pulse on nav logo
- **Micro-interactions:**
  - Nav links: underline expansion on hover (width 0 → 100%)
  - Cards: bespoke-card with gold top border on hover
  - Buttons: btn-lux with hover transparency effects
- **Footer:** Stylish dark background with newsletter form, good col-span layout, gold accents

#### Opportunities:
- Missing scroll-triggered animations on lawyer cards in home.blade.php
- No parallax effects on hero background blobs
- Logo pulse could be slower (3s instead of default)
- Footer social links lack hover micro-animations

---

### 2. AUTHENTICATION FLOWS ❌ (SaaS Template - Mismatched)

**Pages:** Login, Register, Forgot Password

#### Current State (Laravel Breeze - Guest Layout):
```blade
<body class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
  <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
```

#### Problems:
1. **Centered Card Layout** - Classic SaaS signup pattern. Luxury sites use **edge-aligned or full-bleed** forms
2. **Gray 100 Background** - Should be Linen (#F9F7F2) with noise texture
3. **White Card + Drop Shadow** - Looks like Bootstrap admin template. Should be **transparent with subtle border**
4. **Figtree Font** - Too neutral. Should use **Outfit** for consistency
5. **No Animations** - Elements just appear, no entrance choreography
6. **Logo Small + Centered** - Should be **large, aligned left**, with gold accent mark
7. **Input Styling:** Uses default Tailwind forms, not custom `lux-input` with gold focus
8. **"Remember Me" Checkbox** - Very SaaSy. Replace with elegant toggle or remove
9. **"Forgot Password?" Link** - Too functional. Should be minimalized

#### Recommended Luxury Auth Pattern:
```
Desktop: Full-width hero with split layout (brand on left, form on right with glass effect)
Mobile: Full-screen with animated logo + staggered form inputs
```

---

### 3. DASHBOARD EXPERIENCES ❌ (SaaS Admin Panels - Wrong Tone)

**Layouts:** `layouts/admin.blade.php`, `layouts/lawyer.blade.php`, `layouts/customer.blade.php`

#### Current Structure (All Three):
```blade
<div class="flex h-screen overflow-hidden">
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-ink transform...">
  <!-- Sidebar with icons + text -->
  <div class="flex-1 overflow-auto">
    <main class="p-6 lg:p-10">
      @yield('content')
    </main>
  </div>
</div>
```

#### Dashboard-Specific Anti-Patterns:

**1. Fixed Sidebar on All Dashboards**
- **Problem:** Classic SaaS pattern breaks editorial flow. Dashboards become "tools" not "experiences"
- **Impact:** Feels like admin panel, not premium service
- **Solution:** Use **top navigation** (like public pages) OR **fullscreen overlay menu** activated by hamburger

**2. Color Scheme Mismatch**
- Admin/Customer/Lawyer dashboards use: `bg-parchment` + `text-ink-mid` + `border-warm-border`
- Public pages use: `bg-linen` + `text-onyx` + gold accents
- **Result:** Feels like you've entered a different product

**3. Data Tables as Primary Component**
```blade
<table class="w-full text-sm text-left">
  <thead class="bg-ink text-white">
  <tbody>
    <tr class="border-b border-warm-border">
```
- **Problem:** Tables are the ultimate SaaS trope. Feels like database admin tool
- **Solution:** Convert to **card-based lists** with bespoke styling
  - Each appointment = bespoke card with date badge, status pill, lawyer photo (if applicable)
  - Use vertical stack, not grid
  - Add subtle hover: card lifts, border gold accent

**4. Statistics Cards**
```blade
<div class="bg-warm-surface border border-warm-border p-6">
  <p class="text-ink-muted text-xs tracking-widest uppercase mb-2">Total Lawyers</p>
  <p class="font-serif text-3xl text-ink">{{ $totalLawyers }}</p>
```
- **Problem:** Grid of 4 cards at top - SaaS 101
- **Solution:** Hide these or make them extremely minimal. Users don't need "Total Lawyers" displayed like metrics.
- If kept: Use gold numbers, not `text-ink`, with subtle counting animation

**5. Status Badges Using Tailwind Conditional Colors**
```blade
<span class="inline-block px-3 py-1 text-xs border
  @if($status === 'approved') border-green-500 text-green-700
  @elseif($status === 'pending') border-yellow-500 text-yellow-700
  @else border-red-500 text-red-700
  @endif">
```
- **Problem:** Green/Yellow/Red = bureaucratic/admin tool
- **Solution:** Use **single gold border** with status text in onyx/gray. No color coding
- Alternative: Status as subtle icon (circle dot) with gold fill for "active only"

**6. Button Styles**
Auth/dashboards use `btn-primary` / `btn-ghost` which are not defined in app.css. Public uses `btn-lux`. **Inconsistency!**
- **Fix:** All buttons must be `btn-lux` or `btn-lux-gold` or `btn-lux-outline`

**7. Form Field Styling**
Forms use `search-field` class (not defined in app.css). Public uses `lux-input`.
- **Fix:** Standardize on `lux-input` across all forms

**8. Empty States**
```blade
<div class="text-center py-20 text-ink-muted">
  <p>You haven't booked any appointments yet.</p>
  <a href="{{ route('customer.search') }}" class="btn-primary mt-4 inline-block">Find a Lawyer</a>
```
- **Problem:** Basic text + button. No visual storytelling.
- **Solution:** Bespoke card with icon, editorial copy, animated CTA

---

## 🎬 Animation & Micro-interaction Audit

### Current Animation Stack:

**CSS Animations (app.css):**
- `@keyframes reveal-up` - Basic fade+translateY (1.2s ease-expo)
- `.animate-reveal` - Applies reveal-up with `forwards` fill
- `.animation-delay-{200,400,600}` - Stagger utilities
- `.animate-pulse` - CSS pulse (used on logo dot)
- `.animate-pulse-gold` - Referenced in customer create.blade.php but **not defined!**

**External Libraries:**
- Animate.css 4.1.1 (loaded globally in admin/lawyer/customer layouts)
- AOS (Animate On Scroll) 2.3.1 (loaded in admin/lawyer/customer layouts but **not used!** - just CSS included, no JS init)
- Lenis (smooth scroll) - initialized in public.blade.php

**Missing Animations to Add:**

1. **Parallax Hero Effect** - Background gradient blobs move slower than scroll
2. **Staggered Card Reveal** - Lawyer cards should cascade in home.blade.php using AOS `data-aos="fade-up" data-aos-delay="0, 100, 200..."`
3. **Magnetic Buttons** - Buttons should subtly follow cursor on hover (requires small JS)
4. **Gold Border Drawing** - On card hover, gold top border could animate `scale-x` from center outward (already good, but make smoother)
5. **Page Transition** - Fade/slide between page navigations (using Turbo or Alpine middleware)
6. **Form Field Focus** - Floating label animation on `lux-input` focus
7. **Image Reveal** - Lawyer photos could grayscale→color with scale on scroll into view
8. **Status Update Toast** - When appointment booked, floating toast with gold border appears
9. **Loader Animation** - Before page loads, show gold/onyx minimal spinner or pulsing logo
10. **Footer Links** - Underline extends from center on hover (already good in public footer)
11. **Sidebar Collapse** - Smooth width animation on mobile toggle (currently using `transition-transform`)
12. **Scroll Progress Indicator** - Thin gold line at top showing page progress (subtle)

---

## 📱 Responsiveness Storyboard

### Current Breakpoint Strategy:
- Uses Tailwind defaults: `sm` (640px), `md` (768px), `lg` (1024px), `xl` (1280px)
- Public pages: `lg:px-20` for generous side margins on desktop
- Dashboards: Fixed sidebar at `lg` breakpoint (`lg:translate-x-0`, `lg:static`)

#### Issues Found:

**1. Mobile Menu (Public)** - Good implementation
- Fixed full-screen overlay with `animate__fadeIn` (Animate.css)
- Large typography (`text-4xl`) for links
- But menu lacks backdrop blur intensity (`backdrop-blur-3xl` is good)

**2. Sidebar Responsiveness (Dashboards)**
- Mobile: Off-canvas with overlay - works
- BUT: Sidebar width is `w-64` on all devices. Too wide for small laptops (1366px)
- **Fix:** Use `w-72` on `xl`, `w-64` on `lg`, `w-56` on smaller

**3. Card Grid (Home Featured Lawyers)**
```blade
grid-cols-1 md:grid-cols-2 lg:grid-cols-3
```
- **Good:** Responsive
- **Missing:** Animation per card. Add `data-aos="fade-up"` with incremental delays

**4. Table Overflow (Dashboards)**
```blade
<div class="overflow-x-auto">
  <table class="w-full text-sm text-left">
```
- **Problem:** Tables force horizontal scroll on mobile
- **Solution:** Convert tables to **bespoke cards** stack for mobile:
  ```blade
  <div class="hidden md:table">...table for desktop...</div>
  <div class="md:hidden space-y-4">...card stack for mobile...</div>
  ```

**5. Typography Scaling**
Hero uses `text-7xl md:text-9xl lg:text-[10rem]` - aggressive scaling acceptable for editorial.

**6. Touch Targets**
Mobile buttons: `btn-lux` with `px-10 py-4` - sufficient (44x44px minimum met)

---

## 🦶 Footer Analysis

**Public Footer** (`public.blade.php` lines 72-127) - **Excellent**:

### Strengths:
1. **Dark background** (`bg-onyx`) for contrast after light sections
2. **Ambient glow element** - Gold gradient blob bottom-left for depth
3. **12-column grid** - 5 col span for brand, 7 col span for links
4. **Newsletter form** - Minimal: email input + JOIN button, gold-on-white on hover
5. **Link groups** - "Explore", "Support", "Social" with gold underlines
6. **Copyright bar** - Badge line "Designed for excellence" + "Built on Trust" with arrow icon
7. **Font sizes** - `text-[10px] tracking-ultra` for meta text = editorial touch

### Micro-animations Missing:
- Newsletter input: underline should expand on focus (currently just border color change)
- Social links: icons should `translate-x-1` on hover (arrow already does this)
- Footer brand logo? Missing - add small wordmark
- Add scroll-to-top button that appears after scrolling 50% down

---

## 🎭 Storyboard Recommendations (Frame-by-Frame)

### **Story 1: "Discover Your Counsel" User Journey**

**Frame 1: Landing Homepage (Desktop)**
- Viewport: Full-screen hero with `min-h-screen`
- Animation: Logo pulse (3s cycle), hero text staggers in (`animate-reveal` with 200/400/600ms delays)
- Background: Linen with noise texture + gold radial gradient blur (static but soft)
- CTA: "Find Counsel" button gold-filled, "Explore Services" outlined
- Scroll cue: Subtle chevron bounce at bottom of hero (missing - **add**)

**Frame 2: Scrolling to Services Section**
- Parallax: Hero gold blobs move at 0.5x scroll speed (needs implementation)
- Services cards animate in with AOS `fade-up` as they enter viewport
- Card hover: Background turns onyx, text turns white, gold triangle icon fades in
- Number "01 / 02 / 03" subtle in top corner

**Frame 3: Clicking "Criminal" Service**
- Page transition: Slide right + fade out (CSS transition on `body` wrapper)
- Search page loads with filtered results
- Results grid: Cards with lawyer photos (grayscale→color on hover)
- Each card: "Direct Interview" button reveals on hover from bottom

**Frame 4: Clicking Lawyer Card → Profile Page**
- Transition: Slide left + fade in
- Hero: Large lawyer photo (square aspect, slight rotate-1 transform, gold shadow)
- Info: Name (h1 9xl), specialization badge, location tag
- Stats grid: Experience YRS, Retention (Premium), Consultation fee ($XXX)
- Booking sidebar: Sticky card with available slots radio group
- Slot selection: Radio button hidden, full-width clickable row with gold border on select
- **Micro-interaction:** When slot selected, "Request Session" button pulses gold (animate-pulse-gold) - **needs definition**:
  ```css
  @keyframes pulse-gold {
    0%, 100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4); }
    50% { box-shadow: 0 0 0 8px rgba(212, 175, 55, 0); }
  }
  .animate-pulse-gold { animation: pulse-gold 2s infinite; }
  ```

**Frame 5: Booking Confirmation**
- Form submit → button shows loading state (spinner inside)
- Success: Toast notification slides in from top-right with gold left border
- Toast: "Appointment requested. Lawyer will confirm within 24 hours."
- Redirect to customer dashboard after 2s

---

### **Story 2: "Dashboard as Portfolio" (Not Admin Panel)**

**Current Problem:** Lawyer dashboard is a table of appointments. Feels like spreadsheet.

**Desired Experience:** Think **client portal** (like Nordstrom's member area), not CRUD interface.

**Frame 1: Lawyer Enters Dashboard**
- No sidebar! Replace with **top navigation bar** matching public layout (logo left, profile right)
- Welcome banner: "Hello, Sarah" with subtle gold underline
- Statistics: Three elegant cards (not grid) - **rearranged horizontally with space between**
  - Card 1: "This Month" - 12 Appointments (serif large, gold)
  - Card 2: "Availability" - 8 Open Slots
  - Card 3: "Earnings" - $4,200
- **Animation:** Numbers count up from 0 using JS (countUp.js) on page load

**Frame 2: Quick Actions**
- Not "Manage Availability" button (SaaSy)
- Instead: "Add Availability Slot" with `+` icon, "Edit Profile" link (text only, no button)
- Primary action: **"View My Calendar"** - takes to calendar view (new feature)

**Frame 3: Appointments List**
- **NOT a table!** Use bespoke-card list:
  ```blade
  @foreach($appointments as $appointment)
  <div class="bespoke-card p-6 flex items-center justify-between group hover:border-gold-500 transition-all">
    <div class="flex items-center gap-6">
      <div class="w-16 h-16 bg-onyx/5 rounded-full flex items-center justify-center text-gold-600 font-serif">
        {{ strtoupper(substr($appointment->customer->name,0,1)) }}
      </div>
      <div>
        <h4 class="font-serif text-xl">{{ $appointment->subject }}</h4>
        <p class="text-xs text-onyx/40">{{ $appointment->slot->available_date->format('l, F j, Y') }}</p>
        <p class="text-sm text-onyx/60">{{ $appointment->customer->name }}</p>
      </div>
    </div>
    <div class="text-right">
      <span class="inline-block px-4 py-2 text-xs border border-onyx/20">{{ $appointment->status }}</span>
    </div>
  </div>
  @endforeach
  ```

**Frame 4: Empty State**
- If no appointments: Bespoke card with centered content:
  - SVG: Calendar with line through it (onyx/20)
  - "No upcoming appointments"
  - "Your availability schedule appears empty" (font-light)
  - "Set Your Availability" (btn-lux-outline)

---

## 🎨 Design System Specification

### Color Palette Extension

```css
/* Existing */
--onyx: #0D0D0D
--gold-500: #D4AF37
--linen: #F9F7F2

/* Add for dashboards/auth (match public) */
--obsidian: #1A1A1A  /* slightly lighter than onyx for cards */
--ash: #4F4F4F       /* for muted text instead of generic gray */
--clay: #8E8E8E
--silver: #E0E0E0
```

### Typography Scales

| Element | Public Pages | Dashboards/Auth (Current) | Target |
|---------|--------------|--------------------------|--------|
| H1 | `text-7xl md:text-9xl` | `text-4xl` | `text-6xl md:text-8xl` |
| H2 | `text-6xl md:text-8xl` | `text-2xl` | `text-5xl md:text-7xl` |
| Body | `text-xl` | `text-sm` | `text-lg` |
| Meta | `text-[10px] tracking-ultra` | `text-xs` | `text-[10px] tracking-ultra` ✅ |

**Action:** Increase dashboard typography scale dramatically. Currently too small.

### Spacing System

**Public Pages:** `pt-60`, `py-40`, `gap-20` - generous ✅
**Dashboards:** `p-6 lg:p-10` - too cramped
**Target:** Increase to `p-10 lg:p-16` and `gap-8 → gap-12`

### Button System (Standardize)

All pages must use:

```blade
{{-- Primary gold (main CTAs) --}}
<a class="btn-lux btn-lux-gold shadow-premium">...</a>

{{-- Outline (secondary) --}}
<a class="btn-lux btn-lux-outline">...</a>

{{-- Ghost (tertiary, minimal) --}}
<a class="btn-lux btn-lux-ghost text-onyx/60 hover:text-onyx">...</a>
```

**CSS Missing:** `btn-lux-ghost` - create:
```css
.btn-lux-ghost {
  @apply bg-transparent border-transparent text-onyx/60 hover:border-onyx/10 hover:bg-onyx/5;
}
```

### Card System

** bespoke-card ** (public) is perfect. Use it everywhere:

```css
.bespoke-card {
  @apply relative overflow-hidden bg-white/40 backdrop-blur-sm border border-onyx/[0.03] p-10
         transition-all duration-700 ease-expo hover:shadow-premium hover:-translate-y-4;
  box-shadow: inset 0 0 0 1px rgba(255,255,255,0.4);
}
.bespoke-card::before {
  content: '';
  @apply absolute top-0 left-0 w-full h-1 bg-gold-500 scale-x-0 transition-transform duration-700 origin-left;
}
.bespoke-card:hover::before { @apply scale-x-100; }
```

**Apply to:**
- Dashboard "cards" (stat boxes, empty states)
- Appointment list items (card, not table)
- Profile edit form container
- Slot selection radio cards

---

## 🛠️ Immediate Action Plan

### Phase 1: Fix Critical Inconsistencies (1-2 hours)

1. **Replace Guest Layout** (auth pages)
   - Duplicate `layouts/public.blade.php` → `layouts/auth.blade.php`
   - Remove sidebar references
   - Add form container with bespoke styling
   - Use same nav as public
   - Update login/register to extend `layouts.auth` instead of `layouts.guest`

2. **Replace Dashboard Layouts** (3 layouts)
   - Delete sidebar from `admin.blade.php`, `lawyer.blade.php`, `customer.blade.php`
   - Replace with top nav matching `public.blade.php` nav
   - Add role-specific branding in nav subtitle
   - Keep mobile hamburger menu but make it full-screen like public
   - Change color scheme from `bg-parchment` to `bg-linen`

3. **Standardize Classes**
   - Search/replace `btn-primary` → `btn-lux btn-lux-gold`
   - Search/replace `search-field` → `lux-input`
   - Search/replace `bg-warm-surface` → `bg-white/40`
   - Search/replace `border-warm-border` → `border-onyx/[0.03]`
   - Search/replace `text-ink` → `text-onyx`
   - Search/replace `text-ink-muted` → `text-onyx/40`

4. **Convert Tables to Bespoke Cards** (3 files each)
   - `admin/lawyers/index.blade.php`
   - `admin/bookings/index.blade.php`
   - `admin/slots/index.blade.php`
   - `customer/dashboard.blade.php`
   - `lawyer/dashboard.blade.php`
   - `customer/appointments/index.blade.php`

5. **Fix Status Badges**
   - Replace color-coded badges with single gold border
   - All: `class="inline-block px-4 py-2 text-xs border border-onyx/20 text-onyx uppercase tracking-ultra"`
   - Only approved gets background: `bg-onyx text-white`

### Phase 2: Add Missing Animations (2-3 hours)

1. **Add `animate-pulse-gold` to app.css**
   ```css
   @keyframes pulse-gold {
     0%, 100% { box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4); }
     50% { box-shadow: 0 0 0 10px rgba(212, 175, 55, 0); }
   }
   .animate-pulse-gold { animation: pulse-gold 2s infinite; }
   ```

2. **Initialize AOS in public.blade.php**
   ```js
   import AOS from 'aos';
   import 'aos/dist/aos.css';
   AOS.init({ duration: 1000, easing: 'ease-out-expo', once: true, offset: 100 });
   ```

3. **Add AOS attributes to home.blade.php cards**
   ```blade
   <div class="group" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
   ```

4. **Parallax gold blobs** - Add simple parallax script in public.blade.php:
   ```js
   window.addEventListener('scroll', () => {
     const blobs = document.querySelectorAll('.parallax-blob');
     blobs.forEach(blob => {
       const speed = parseFloat(blob.dataset.speed);
       blob.style.transform = `translateY(${window.scrollY * speed}px)`;
     });
   });
   ```

5. **Number counting animation** - Add `countUp` for dashboard stats

6. **Form focus animations** - Add floating label CSS to `lux-input`

### Phase 3: Polish & Accessibility (1 hour)

1. **Skip links** - Already present in public, add to all layouts
2. **Focus states** - Ensure all interactive elements have `:focus-visible` rings (gold)
3. **Reduced motion** - Add `@prefers-reduced-motion` media query to disable animations
4. **Loading states** - Add skeleton loaders for async content (appointments list)

---

## 🎯 Success Metrics (Non-SaaS Validation)

The site achieves luxury non-SaaS status when users say:

> "This doesn't feel like a website, it feels like a **magazine**" ✅

> "I forgot I was booking a lawyer, it was just **beautiful to use**" ✅

> "The dashboard doesn't look like the rest of the internet" ✅

> "It's **quiet** but premium" (no screaming CTAs, no badges) ✅

---

## 📐 Appendix: Code Migrations

### A1. Auth Layout Creation

**File:** `resources/views/layouts/auth.blade.php`
```blade
@extends('layouts.public') {{-- Or extract common parts --}}
@section('content')
<div class="min-h-screen flex items-center justify-center py-20 px-4">
  <div class="max-w-md w-full mx-auto">
    <div class="text-center mb-12">
      <a href="{{ route('home') }}" class="font-serif text-4xl italic">Legal<span class="text-gold-500">Counsel</span></a>
    </div>
    <div class="bg-white/40 backdrop-blur-sm border border-onyx/5 p-12 bespoke-card">
      {{ $slot }}
    </div>
  </div>
</div>
@endsection
```

### A2. Dashboard Layout Refactor (Admin Example)

**Current:** Sidebar-based (SaaS pattern)
**Target:** Top-nav like public, but with user dropdown

```blade
@extends('layouts.public')
@section('content')
<div class="pt-32 pb-20 px-6 lg:px-20">
  <div class="flex justify-between items-center mb-12">
    <div>
      <h1 class="text-5xl italic mb-2">Admin Portal</h1>
      <p class="text-onyx/50">Platform oversight and management</p>
    </div>
    <div class="flex items-center gap-4">
      <a href="{{ route('home') }}" class="btn-lux btn-lux-outline">View Site</a>
      <div class="relative">
        <button class="flex items-center gap-2 p-3 border border-onyx/10 hover:bg-onyx/5">
          <span class="w-2 h-2 bg-gold-500 rounded-full"></span>
          <span class="text-sm font-bold tracking-ultra uppercase">{{ auth()->user()->name }}</span>
        </button>
      </div>
    </div>
  </div>

  @yield('dashboard-content')
</div>
@endsection
```

---

## ✅ Final Checklist

### Design Language Consistency
- [ ] All pages use `bg-linen` (not gray-100, parchment, warm-surface)
- [ ] All text primary uses `text-onyx` (not text-ink, gray-900)
- [ ] All headings use `font-serif` (not arbitrary sizes)
- [ ] All buttons use `btn-lux` variants only
- [ ] Gold color `#D4AF37` appears at least once per screen
- [ ] No green/yellow/red status badges (gold only)

### Animation Polish
- [ ] AOS initialized on all public pages
- [ ] All cards have entry animations (staggered)
- [ ] Parallax gold blobs on hero sections
- [ ] `animate-pulse-gold` defined and used on confirmation buttons
- [ ] Page transitions (optional but nice)

### Responsiveness
- [ ] No horizontal overflow on mobile (< 400px width)
- [ ] Tables converted to card stacks on mobile
- [ ] Touch targets min 44x44px
- [ ] Font sizes scale down to `text-sm` on mobile hero

### Editorial Elements
- [ ] Noise texture present on body (app.css line 17)
- [ ] Oversized typography on headings (min `text-6xl` desktop)
- [ ] Generous vertical rhythm (sections `py-32` to `py-60`)
- [ ] Decorative gold gradients or blobs in each section
- [ ] Bespoke card hover effects everywhere

---

**Document Status:** Complete
**Next Review:** After implementing Phase 1 changes
