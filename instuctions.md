# Law-Conect — Claude Code Instructions & Project Specification

> **For Claude Code:** Read this entire file before touching any code. This is your primary source of truth for what needs to be built, what already exists, and how to work on this project.

---

## 1. Project Overview

**Law-Conect** is a Laravel 10 legal services marketplace. It connects customers with lawyers. The codebase already exists and was scaffolded by Claude Code via `/init`. Your job is to **analyze the existing code**, **identify gaps**, and **implement missing features** according to the specification below.

**Live stack:**
- Backend: Laravel 10, PHP 8.1+, MySQL
- Frontend: Tailwind CSS, Alpine.js, Vite, GSAP, AOS, Lenis
- Auth: Laravel Breeze + Sanctum
- Roles: Spatie Laravel Permission (`admin`, `lawyer`, `customer`)

---

## 2. Project Specification (Source of Truth)

This is what the client wants. Every feature listed here must exist and work correctly.

### 2.1 User Types

| Role | Responsibilities |
|------|-----------------|
| **Admin** | Manage homepage content, approve/reject lawyer profiles, manage schedules and appointment slots |
| **Lawyer** | Register with full profile, create availability slots, manage appointments |
| **Customer** | Register, search for lawyers by location/specialization, view profiles, book appointments |

### 2.2 Required Features Checklist

- [ ] Customer registration (name, email, password, phone, city)
- [ ] Lawyer registration (name, email, password, phone, city, bar license, specialization, photo)
- [ ] Lawyer profile panel visible to customers
- [ ] Search by **lawyer location** (city)
- [ ] Search by **lawyer specialization**: Criminal, Divorce, Affidavit, Civil
- [ ] Search results show **minimal lawyer info** (name, specialization, city, photo)
- [ ] Clicking a result opens **full lawyer profile**
- [ ] Customer can **schedule a meeting** from the lawyer profile page
- [ ] Customer can **book a slot** from available slots
- [ ] Admin can **approve or reject** lawyer registrations
- [ ] Admin can **manage appointment booking slots**
- [ ] Admin can **manage homepage content**
- [ ] Login page shared for all roles (email + password)
- [ ] Lawyer registration requires a separate form at `/lawyer/register`
- [ ] Showcase lawyers one by one in search results
- [ ] Role-based dashboard redirect after login

### 2.3 Lawyer Specializations (Exact Values)

Only these values are valid in the `specialization` column and search filters:
- Criminal
- Divorce
- Affidavit
- Civil

---

## 3. What To Analyze First

Before making any changes, run this audit:

### 3.1 Database Audit
```bash
# Check if database.sql covers all required tables
grep -i "CREATE TABLE" database/database.sql

# Verify lawyers table has all needed columns
# Required: user_id, bar_license, specialization, status, city, photo, bio, experience_years
```

### 3.2 Routes Audit
```bash
php artisan route:list
```
Verify these routes exist and are protected correctly:
- `GET /` — public homepage
- `GET /search` — public search (with `?specialization=` and `?city=` query params)
- `GET /lawyer/{id}` — public lawyer profile
- `GET /lawyer/register` — lawyer registration form
- `POST /lawyer/register` — lawyer registration submit
- `GET /register` — customer registration form
- `GET /login` — shared login
- `GET /customer/appointments/book/{lawyerId}` — booking form
- `POST /customer/appointments` — submit booking
- `GET /admin/lawyers` — admin lawyer management
- `POST /admin/lawyers/{id}/approve` — approve lawyer
- `POST /admin/lawyers/{id}/reject` — reject lawyer
- `GET /admin/slots` — admin slot management
- `GET /admin/homepage` — homepage content management

### 3.3 Views Audit
Check these views exist and are complete:
```
resources/views/
├── public/
│   ├── home.blade.php        ← Homepage with search bar
│   ├── search.blade.php      ← Search results list
│   └── lawyer-profile.blade.php  ← Full lawyer profile + booking CTA
├── auth/
│   ├── login.blade.php
│   ├── register.blade.php    ← Customer registration
│   └── lawyer/register.blade.php ← Lawyer-specific registration
├── customer/
│   ├── dashboard.blade.php
│   └── appointments/
│       ├── index.blade.php   ← Customer's bookings list
│       ├── create.blade.php  ← Booking form
│       └── show.blade.php
├── lawyer/
│   ├── dashboard.blade.php
│   ├── slots/index.blade.php ← Lawyer's slots management
│   └── appointments/index.blade.php
└── admin/
    ├── dashboard.blade.php
    ├── lawyers/index.blade.php  ← Approve/reject lawyers
    ├── slots/index.blade.php
    └── homepage/edit.blade.php
```

### 3.4 Controller Audit
Verify these controllers exist with the correct methods:
- `PublicController` → `index()`, `search()`, `lawyerProfile()`
- `CustomerAppointmentController` → `index()`, `create()`, `store()`, `show()`, `cancel()`
- `LawyerSlotController` → `index()`, `create()`, `store()`, `destroy()`
- `AdminLawyerController` → `index()`, `approve()`, `reject()`
- `AdminSlotController` → `index()`, `destroy()`
- `AdminHomepageController` → `edit()`, `update()`

---

## 4. Implementation Priorities

Fix and build in this order:

### Priority 1 — Core Auth & Registration
1. Customer registration at `/register` must capture: name, email, password, phone, city
2. Lawyer registration at `/lawyer/register` must capture: name, email, password, phone, city, bar_license, specialization (dropdown: Criminal/Divorce/Affidavit/Civil), photo (file upload), bio
3. Both registrations auto-login after submit
4. Lawyer defaults to `status = 'pending'` — show a "pending approval" message on their dashboard

### Priority 2 — Public Search
1. Homepage (`/`) must have a visible search form with two fields: **Specialization** (dropdown) and **City** (text input)
2. Search results at `/search` show lawyer cards: photo, name, specialization badge, city, "View Profile" button
3. Filter: only `status = 'approved'` lawyers appear in results
4. If no results, show friendly empty state

### Priority 3 — Lawyer Profile & Booking
1. `/lawyer/{id}` shows: photo, name, bar_license, specialization, bio, city
2. Shows available slots as a list/calendar (only unbooked slots)
3. Authenticated customers see a "Book This Slot" button per slot
4. Unauthenticated users see "Login to Book" button
5. Booking stores appointment with `status = 'pending'`

### Priority 4 — Admin Panel
1. `/admin/lawyers` lists all lawyers grouped by status (pending first)
2. Each pending lawyer has Approve and Reject buttons
3. Approving sets `status = 'approved'`; rejecting sets `status = 'rejected'`
4. `/admin/slots` shows all slots with ability to delete
5. `/admin/homepage` has a form to edit homepage text sections

### Priority 5 — Dashboards
1. **Customer dashboard**: List of their appointments with status badges
2. **Lawyer dashboard**: List of their slots and incoming appointments; ability to confirm/cancel
3. **Admin dashboard**: Count cards (total lawyers, pending approvals, total bookings)

---

## 5. Database Schema Requirements

If migrations are missing or out of sync with `database.sql`, create/fix them. Required columns:

### `users` table
```
id, name, email, password, phone, city, address, user_type, remember_token, timestamps
```

### `lawyers` table
```
id, user_id (FK→users), bar_license, specialization (enum: Criminal,Divorce,Affidavit,Civil),
status (enum: pending,approved,rejected, default: pending),
bio, experience_years, photo (nullable), timestamps
```

### `availability_slots` table
```
id, lawyer_id (FK→lawyers), date (date), start_time (time), end_time (time),
is_booked (boolean, default: false), timestamps
```

### `appointments` table
```
id, customer_id (FK→users), lawyer_id (FK→lawyers), slot_id (FK→availability_slots),
status (enum: pending,confirmed,cancelled,completed, default: pending),
notes (text, nullable), timestamps
```

### `homepage_contents` table
```
id, section_key (string, unique), title, content (text), timestamps
```

---

## 6. UI/UX Requirements

### 6.0 The Most Important Rule — This Is NOT a SaaS Product

**This site must never look or feel like a generic SaaS dashboard, template, or Bootstrap clone.**

It must feel like a human designer spent weeks on it in Figma — crafted, intentional, premium, and alive. Every interaction must have a physical, tactile quality. The user should feel something when they hover a button, scroll a section, or open a form. Think references like: Linear's website, Stripe's marketing pages, or high-end law firm branding.

If any page looks like it could have been generated by a free theme or a generic AI output, rebuild it.

---

### 6.1 Design System (Do Not Deviate)

**Color Palette:**
- `onyx`: `#0D0D0D` — primary dark, backgrounds, heavy text
- `gold`: `#D4AF37` — accent, CTAs, highlights, hover states
- `linen`: `#F9F7F2` — light backgrounds, card surfaces, breathing space
- Use semi-transparent tints for layering (e.g., `gold/10`, `onyx/80`)

**Typography:**
- `Instrument Serif` or `Playfair Display` — headings, hero text, lawyer names, all display text
- `Outfit` or `Inter` — body copy, UI labels, form fields, metadata
- Hero h1 must be at least `5xl` on desktop. Headlines are large and confident.
- Never use system-default font stacks for anything visible

**Spacing:** Use generous whitespace. Sections breathe. Nothing is cramped.

**Specialization Badges:**
- Criminal → deep red background, light text
- Divorce → deep blue background, light text
- Affidavit → forest green background, light text
- Civil → deep purple background, light text

---

### 6.2 Animations & Transitions — Required, Not Optional

**Every page must actively use the animation libraries already installed: GSAP, AOS, Alpine.js, Lenis smooth scroll.**

#### Scroll Animations (AOS / GSAP ScrollTrigger)
- Every section entering the viewport must animate in — fade up, slide in, or stagger
- Hero text: staggered word-by-word or line-by-line reveal using GSAP
- Lawyer cards on search results: stagger in with `0.08s` delay between each card
- Stats/numbers on the homepage: count up when they scroll into view using GSAP

#### Page Load Animations
- Homepage hero: text and CTA animate in on load with a GSAP sequence (not all at once)
- Navigation: subtle slide-down on initial load
- Use `gsap.timeline()` for sequenced intro animations

#### Smooth Scroll
- Lenis is already installed — initialize it on every public page
- All anchor links must use Lenis smooth scroll, not native browser jump

#### Hover Micro-interactions (CRITICAL — every interactive element needs one)

**Buttons:**
- Primary buttons: background fills left to right on hover (CSS pseudo-element sweep)
- Gold accent buttons: `scale-105` + subtle glow shadow on hover
- All transitions: `duration-300` minimum, use `cubic-bezier(0.25, 0.46, 0.45, 0.94)` easing

**Lawyer Cards (search results):**
- Card lifts on hover: `translateY(-6px)` + deeper box-shadow
- Photo scales slightly: `scale(1.05)` with `overflow: hidden` on the image wrapper
- "View Profile" button reveals by sliding up from card bottom on hover
- Specialization badge pulses subtly on card hover

**Navigation Links:**
- Underline grows from center outward on hover (not left-to-right)
- Active link has a gold dot or underline indicator

**Form Fields:**
- Border transitions to gold on focus
- Floating label pattern: label moves up and shrinks on focus/fill
- Focus glow: `box-shadow: 0 0 0 3px rgba(212,175,55,0.15)`

**Slot/Appointment Buttons:**
- "Book This Slot": icon rotates slightly + text shifts on hover
- After booking: button transitions to a checkmark success state

#### Page Transitions
- Alpine.js `x-transition` on all modals, dropdowns, and slot lists
- Modal open: scale from `0.95` + fade in; close: reverse
- Dropdowns: slide down + fade in — never instant appear

---

### 6.3 Micro-animations (the fine details that make it feel human)

- **Loading states**: Buttons show a spinner and disable on form submit — the user must always know something is happening
- **Success feedback**: After booking, a toast slides in from bottom-right or a checkmark draws itself
- **Empty states**: No-results search shows an icon/illustrated empty state with a friendly message — not plain text
- **Skeleton loaders**: Any async-loaded data shows skeleton placeholder cards, not a blank space
- **Staggered list reveals**: All lists (appointments, slots, search results) stagger in with `0.08s` delay between items
- **Number counters**: Homepage stats animate counting up when scrolled into view (GSAP)
- **Focus ring**: Gold-colored custom focus ring — never the browser default blue outline
- **Table row hover**: Row background transitions smoothly, not instant

---

### 6.4 Responsiveness — Non-Negotiable

**Every page must be fully functional and visually polished at every screen size. No horizontal scroll. No clipped text. No broken layouts.**

Test at these breakpoints:

| Breakpoint | Width | Notes |
|------------|-------|-------|
| Mobile S | 320px | No horizontal scroll, tap targets ≥ 44px |
| Mobile M | 375px | Primary mobile target |
| Mobile L | 425px | Large phones |
| Tablet | 768px | Two-column layouts where appropriate |
| Laptop | 1024px | Full nav visible |
| Desktop | 1440px | Max content width, generous margins |

**Navigation:**
- Desktop: horizontal nav with full links visible
- Mobile: hamburger → full-screen overlay or slide-in drawer with smooth animation

**Search page:**
- Desktop: filter sidebar left, 3-column results grid right
- Tablet: filters collapse to a toggleable top bar
- Mobile: filters behind a "Filter" button; single-column results

**Lawyer cards:** 3-col desktop → 2-col tablet → 1-col mobile

**Lawyer profile:** side-by-side desktop → stacked single-column mobile

**Forms:** two-column desktop → single-column mobile, full-width inputs, labels always visible (never placeholder-only)

**Dashboards:**
- Sidebar collapses to a bottom tab bar or hamburger drawer on mobile
- Tables become stacked card-style layouts on mobile (never horizontally scrollable)
- Stat cards stack vertically on mobile

**Typography scales:**
- Hero headline: `text-5xl` desktop → `text-3xl` mobile
- Section headings: `text-4xl` desktop → `text-2xl` mobile

---

### 6.5 Layout Rules

- All public pages extend `layouts/public.blade.php`
- All dashboard pages extend their role layout (`admin.blade.php`, `lawyer.blade.php`, `customer.blade.php`)
- Use existing Blade components: `<x-primary-button>`, `<x-text-input>`, `<x-input-label>`, `<x-modal>`
- Max content width: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` — consistent across all pages
- Section padding: `py-16 md:py-24` for public marketing sections
- Never use inline styles for spacing — Tailwind utility classes only

---

## 7. Known Issues To Fix

Address these issues from the existing codebase:

1. **Lawyer visibility bug**: `PublicController@search` must filter by `status = 'approved'` — verify this is implemented
2. **Double-booking race condition**: Wrap slot booking in a database transaction with a lock:
   ```php
   DB::transaction(function() use ($slotId, $customerId, $lawyerId) {
       $slot = AvailabilitySlot::lockForUpdate()->findOrFail($slotId);
       if ($slot->is_booked) abort(409, 'Slot already booked');
       $slot->update(['is_booked' => true]);
       Appointment::create([...]);
   });
   ```
3. **No-role error**: If a user has no role assigned after registration, they see `errors.no-role`. Ensure every registration flow assigns a role immediately.
4. **Storage symlink**: Run `php artisan storage:link` and confirm lawyer photo uploads resolve correctly via `Storage::url()`
5. **Migrations vs SQL sync**: Check if `php artisan migrate:status` shows any pending migrations that conflict with `database.sql`. Resolve before running fresh migrations.

---

## 8. Commands To Run After Changes

```bash
# Clear all caches after config/route changes
php artisan optimize:clear

# Re-run migrations if schema changed
php artisan migrate

# Rebuild frontend after Blade/JS changes
npm run build

# Fix code style
./vendor/bin/pint

# Run tests
php artisan test

# Check storage symlink
php artisan storage:link
```

---

## 9. Testing Requirements

Write or verify tests for:
- Customer can register and log in
- Lawyer registers and is set to `pending` status
- Admin can approve a lawyer
- Approved lawyer appears in public search; pending does not
- Customer can book an available slot
- Double-booking the same slot returns an error

---

## 10. File Storage

Lawyer photos:
- Store in `storage/app/public/lawyer-photos/`
- Access via `Storage::url('lawyer-photos/filename.jpg')`
- Ensure `php artisan storage:link` has been run
- Validate uploads: `mimes:jpg,jpeg,png|max:2048`

---

## 11. Security Checklist

Before any feature is considered done:
- [ ] All routes that modify data use `POST`/`PUT`/`DELETE`
- [ ] All role-protected routes use the correct middleware (`role.admin`, `role.lawyer`, `role.customer`)
- [ ] User can only see/edit their own appointments (not other customers')
- [ ] Lawyer can only manage their own slots
- [ ] File uploads validate MIME type and max size

---

## 12. Environment Notes

- Default app URL: `http://localhost:8000`
- Database: MySQL — update `.env` with your credentials
- Mail: Mailpit for local dev (`MAIL_HOST=localhost`, `MAIL_PORT=1025`)
- Queue: `sync` (no worker needed for local dev)

---

*This README was generated to guide Claude Code in analyzing and completing the Law-Conect project to spec. Always read CLAUDE.md alongside this file.*