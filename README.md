# ⚖️ Online Lawyers Application Website System
### Product Requirements Document — Claude Code Build Guide
**Framework:** Laravel 10 | **CSS:** Tailwind CSS v3 | **Level:** Junior Developer

---

> ## 🤖 CLAUDE CODE — READ THIS FIRST
>
> You are building the **Online Lawyers Application Website System** described in this document.
> Read every section of this README fully before writing a single line of code.
> Follow every section in order. Do not skip steps. Do not assume anything not written here.
> Every command to run, every file to create, every plugin to install is listed explicitly.
> Your job is to implement exactly what is described — nothing more, nothing less.

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Problem Statement](#2-problem-statement)
3. [Objectives](#3-objectives)
4. [Mandatory Standards](#4-mandatory-standards)
5. [Hardware & Software Requirements](#5-hardware--software-requirements)
6. [User Roles & Module Overview](#6-user-roles--module-overview)
7. [Full Module Descriptions](#7-full-module-descriptions)
8. [Complete Tech Stack & Plugins](#8-complete-tech-stack--plugins)
9. [Design System](#9-design-system)
10. [Animation & Micro-Interaction Spec](#10-animation--micro-interaction-spec)
11. [Responsive Design Rules](#11-responsive-design-rules)
12. [Step-by-Step Setup Commands](#12-step-by-step-setup-commands)
13. [Database Schema](#13-database-schema)
14. [Folder Structure](#14-folder-structure)
15. [Routes](#15-routes)
16. [Controllers](#16-controllers)
17. [Views](#17-views)
18. [Documentation Checklist](#18-documentation-checklist)
19. [Unit Testing Checklist](#19-unit-testing-checklist)
20. [Final Checklist](#20-final-checklist)
21. [Claude Code Step-by-Step Build Order](#21-claude-code-step-by-step-build-order)

---

## 1. Project Overview

**Application Name:** Online Lawyers Application Website System

Today everyone needs legal services but finding lawyers with the right specialization is very difficult. This web application connects customers with lawyers. Customers register, search for lawyers by location and legal service type, view full lawyer profiles, and schedule meetings. Lawyers register and manage their profile panel. Admins manage all content, approvals, and bookings.

---

## 2. Problem Statement

Taken directly from the project specification:

Today everyone needs legal services for some or the other reason. It is very difficult to find lawyers with respective specialization. Getting appointment is also very difficult. There is a need to have a website for doing all this.

Customers can register and search for lawyers basing their requirement. Info related to lawyers will be there in website which customers can browse through and view their profile before contacting them. Customers can book a schedule for meeting with lawyer.

---

## 3. Objectives

Taken directly from the project specification:

- Registration for customer as well as Lawyers
- Panel for Lawyers showcasing their details
- Search by lawyer location, lawyer services like Criminal, Divorce, Affidavit, Civil, and then schedule a meeting
- A customer search shows minimal info of a lawyer — a click on the lawyer profile shows the full profile where the customer can schedule a meeting and book a slot
- Login through normal registration form for customer is mandatory and for a lawyer a registration form is required
- Showcase of the lawyer when they search one by one
- Admin Pages

---

## 4. Mandatory Standards

Taken directly from the project specification. These are non-negotiable.

**Code Standards:**
- Every function must have a PHPDoc block comment explaining what it does
- No inline comments using `//` or block comments using `/* */` anywhere in the codebase
- No unnecessary commits, commented-out code, or dead code left in any file
- Logic must be self-explanatory through clear naming — functions, variables, and classes must be named so clearly that they need no inline explanation

**Naming Rules:**
- Functions: `camelCase` — example: `getApprovedLawyers`
- Variables: `camelCase` — example: `$approvedLawyers`
- Classes and Controllers: `PascalCase` — example: `AdminLawyerController`
- Blade views: `kebab-case` — example: `lawyer-profile.blade.php`
- Database columns: `snake_case` — example: `appointment_date`

**Documentation — Full Project Report Must Include:**
1. Certificate of Completion
2. Table of Contents
3. Problem Definition
4. Customer Requirement Specification
5. Project Plan
6. E-R Diagrams
7. Algorithms
8. GUI Standards Document
9. Interface Design Document
10. Task Sheet
11. Project Review and Monitoring Report
12. Unit Testing Check List
13. Final Check List

---

## 5. Hardware & Software Requirements

Taken directly from the project specification:

**Hardware:** Pentium 166 or better, 128 MB RAM minimum

**Operating System:** Linux or Windows 2000 Server or higher

**Original spec used PHP + MySQL + Apache. We are building with:**

| Original | Replacement |
|---|---|
| PHP | PHP 8.1+ |
| MySQL | MySQL 8.0 |
| Apache | Laravel dev server |

---

## 6. User Roles & Module Overview

Three roles exist in the system:

```
ADMIN          LAWYER              CUSTOMER
─────────────  ──────────────────  ────────────────────
Dashboard      Register            Register
Manage Lawyers Login               Login
Approve/Reject Profile Panel       Search by Location
Manage Slots   Manage Availability Search by Service
Manage Bookings View Appointments  View Lawyer Profile
Manage Homepage                    Book Appointment
                                   My Appointments
```

---

## 7. Full Module Descriptions

All features below are taken directly from the specification. All must be implemented.

### Admin

| Feature | What it does |
|---|---|
| Manage Homepage Content | Admin controls text and images shown on the public homepage |
| Manage Lawyer Profiles | Admin views and manages all lawyer profiles visible in search |
| Approve or Reject Lawyers | When a lawyer registers, admin must approve before they can log in |
| Manage Schedules | Admin can oversee all appointment schedules |
| Manage Booking Slots | Admin can manage available slots across lawyers |

### Lawyer

| Feature | What it does |
|---|---|
| Register | Lawyer submits a registration form with name, specialization, city, address, phone |
| Login | Lawyer logs in with email and password |
| Profile Panel | Lawyer has a dashboard showing all their details |
| Add Availability Slots | Lawyer sets dates and times when they are available to meet |
| View Bookings | Lawyer sees which of their slots are booked |

### Customer

| Feature | What it does |
|---|---|
| Register | Customer submits a registration form |
| Login | Customer logs in with email and password |
| Search by Location | Customer types a city to find lawyers there |
| Search by Service | Customer selects Criminal, Divorce, Affidavit, or Civil |
| See Minimal Info in Results | Search shows name, service, city only — not full profile |
| Click to Full Profile | Clicking a lawyer card opens the full lawyer profile page |
| Book Appointment | From the full profile, customer picks a slot and books it |
| My Appointments | Customer views all their past and upcoming appointments |

### Legal Service Types

These four are the only valid values for lawyer specialization:

- Criminal
- Divorce
- Affidavit
- Civil

---

## 8. Complete Tech Stack & Plugins

### Core

| Package | Install Command | Purpose |
|---|---|---|
| Laravel 10 | `composer create-project laravel/laravel lawyers-website "10.*"` | Main framework |
| Laravel Breeze | `composer require laravel/breeze --dev` | Auth scaffolding |
| Spatie Permission | `composer require spatie/laravel-permission` | Role management |

### Tailwind CSS + Plugins

| Package | Install Command | Purpose |
|---|---|---|
| Tailwind CSS v3 | `npm install -D tailwindcss postcss autoprefixer` | Utility CSS framework |
| @tailwindcss/forms | `npm install -D @tailwindcss/forms` | Resets form element styles cleanly |
| @tailwindcss/typography | `npm install -D @tailwindcss/typography` | Rich text prose styling |
| @tailwindcss/aspect-ratio | `npm install -D @tailwindcss/aspect-ratio` | Consistent image/media ratios |

### Animation Libraries (CDN — no npm install needed)

| Library | CDN Link | Purpose |
|---|---|---|
| AOS | `https://unpkg.com/aos@2.3.1/dist/aos.js` | Scroll-triggered animations |
| Animate.css | `https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css` | Page load animations |

### Tailwind Config File

After running `npx tailwindcss init -p`, replace `tailwind.config.js` with:

```js
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        parchment: '#F5F2EB',
        gold: {
          DEFAULT: '#B8860B',
          dark: '#9A6F00',
        },
        ink: {
          DEFAULT: '#1A1A1A',
          mid: '#4A4A4A',
          muted: '#8A8A8A',
        },
        warm: {
          border: '#E0D9CC',
          surface: '#FFFFFF',
        },
      },
      fontFamily: {
        serif: ['"Playfair Display"', 'Georgia', 'serif'],
        sans: ['Inter', 'system-ui', 'sans-serif'],
      },
      borderRadius: {
        none: '0px',
        DEFAULT: '0px',
      },
      transitionTimingFunction: {
        'out-cubic': 'cubic-bezier(0.33, 1, 0.68, 1)',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
```

### Vite Config

Replace `vite.config.js` with:

```js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
})
```

### resources/css/app.css

Replace the entire file with:

```css
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap');

@tailwind base;
@tailwind components;
@tailwind utilities;

@layer base {
  body {
    @apply bg-parchment text-ink-mid font-sans text-base leading-relaxed;
  }

  h1, h2, h3, h4 {
    @apply font-serif text-ink leading-tight;
  }
}

@layer components {
  .btn-primary {
    @apply bg-gold text-white px-9 py-3.5 text-xs font-semibold tracking-widest uppercase
           transition-all duration-200 hover:-translate-y-0.5 hover:bg-gold-dark
           focus:outline-none focus:ring-2 focus:ring-gold focus:ring-offset-2;
    border-radius: 0;
  }

  .btn-ghost {
    @apply border border-ink text-ink px-9 py-3.5 text-xs font-semibold tracking-widest uppercase
           transition-all duration-200 hover:bg-ink hover:text-white
           focus:outline-none;
    border-radius: 0;
  }

  .lawyer-card {
    @apply bg-warm-surface border border-warm-border relative overflow-hidden
           transition-shadow duration-300 hover:shadow-lg block no-underline text-inherit;
    border-radius: 0;
  }

  .lawyer-card::before {
    content: '';
    @apply absolute top-0 left-0 w-0.5 h-full bg-gold;
    transform: scaleY(0);
    transform-origin: bottom;
    transition: transform 0.3s cubic-bezier(0.33, 1, 0.68, 1);
  }

  .lawyer-card:hover::before {
    transform: scaleY(1);
  }

  .service-tag {
    @apply inline-block border border-warm-border px-4 py-1.5 text-xs font-semibold
           tracking-widest uppercase cursor-pointer text-ink-mid
           transition-all duration-200 select-none;
    border-radius: 0;
  }

  .service-tag:hover,
  .service-tag.active {
    @apply bg-ink text-white border-ink -translate-y-px;
  }

  .search-field {
    @apply border border-warm-border bg-warm-surface px-5 py-3.5 w-full font-sans text-sm
           transition-all duration-200 focus:outline-none focus:border-gold;
    border-radius: 0;
    box-shadow: none;
  }

  .search-field:focus {
    box-shadow: 0 0 0 3px rgba(184, 134, 11, 0.12);
  }

  .footer-link {
    @apply block text-white/55 text-sm leading-loose no-underline
           transition-all duration-200 hover:text-gold hover:pl-1.5;
  }
}

@layer utilities {
  @keyframes subtle-pulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(184, 134, 11, 0.3); }
    50%       { box-shadow: 0 0 0 8px rgba(184, 134, 11, 0); }
  }

  .animate-pulse-gold {
    animation: subtle-pulse 2.5s infinite;
  }

  .animate-pulse-gold:hover {
    animation: none;
    @apply -translate-y-1;
  }
}
```

---

## 9. Design System

### Colors

| Name | Hex | Usage |
|---|---|---|
| `parchment` | `#F5F2EB` | Page background |
| `warm-surface` | `#FFFFFF` | Cards, panels |
| `ink` | `#1A1A1A` | Headings |
| `ink-mid` | `#4A4A4A` | Body text |
| `ink-muted` | `#8A8A8A` | Captions, meta |
| `gold` | `#B8860B` | Accent — buttons, links, borders |
| `gold-dark` | `#9A6F00` | Gold hover state |
| `warm-border` | `#E0D9CC` | Card and input borders |

### Typography

- Headings: Playfair Display — serif, editorial, premium
- Body: Inter — clean, readable, modern

### Design Rules — What Not to Do

| Do Not Use | Use Instead |
|---|---|
| Purple or blue gradients | Dark `ink` backgrounds with gold accent lines |
| `rounded-full` or `rounded-lg` on buttons | `rounded-none` — sharp corners only |
| Heavy card drop shadows | Thin border + subtle hover shadow |
| `font-black` everywhere | Contrast between `font-light` body and `font-bold` headings |
| SaaS blue (`#3B82F6`) | Dark gold (`#B8860B`) |
| Pill-shaped tags | Sharp rectangular tags with uppercase tracking |

---

## 10. Animation & Micro-Interaction Spec

### CDN Links — Add to Every Layout Head

```html
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
```

Add before every layout closing `</body>`:

```html
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 700, once: true, offset: 80, easing: 'ease-out-cubic' });

  window.addEventListener('scroll', function () {
    const nav = document.getElementById('main-nav');
    nav.classList.toggle('bg-warm-surface shadow-sm', window.scrollY > 80);
    nav.classList.toggle('bg-transparent', window.scrollY <= 80);
  });

  document.querySelectorAll('a:not([target="_blank"])').forEach(function (link) {
    link.addEventListener('click', function (e) {
      const href = this.getAttribute('href');
      if (href && href !== '#' && !href.startsWith('http')) {
        e.preventDefault();
        document.getElementById('page-overlay').style.opacity = '1';
        setTimeout(() => { window.location.href = href; }, 280);
      }
    });
  });

  document.querySelectorAll('.service-tag').forEach(function (tag) {
    tag.addEventListener('click', function () {
      document.querySelectorAll('.service-tag').forEach(t => t.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>
```

### Animation Usage Per Page

| Element | Animation | How |
|---|---|---|
| Hero `h1` | Fade up on load | `animate__animated animate__fadeInUp` + `style="animation-delay:0.1s"` |
| Hero `p` | Fade up on load | Same class + `animation-delay:0.3s` |
| Hero CTA button | Fade up on load | Same class + `animation-delay:0.5s` |
| Service category cards | Stagger on scroll | `data-aos="fade-up"` + `data-aos-delay="{{ $loop->index * 100 }}"` |
| Lawyer cards | Stagger on scroll | `data-aos="fade-up"` + `data-aos-delay="{{ $loop->index * 100 }}"` |
| Footer columns | Stagger on scroll | `data-aos="fade-up"` + `data-aos-delay="0/100/200/300"` |
| Navbar | Scroll effect | JS adds `bg-warm-surface shadow-sm` class when `scrollY > 80` |
| Page change | Fade overlay | Dark `div#page-overlay` fades to `opacity-1` then navigates |
| Book button | Pulse | Tailwind custom `animate-pulse-gold` class |
| Lawyer card | Gold left border | CSS `::before` with `scaleY(0 → 1)` on hover |
| Lawyer photo | Color on hover | `grayscale` to `grayscale-0` via Tailwind `group-hover` |

---

## 11. Responsive Design Rules

Every page must work on mobile (375px), tablet (768px), and desktop (1280px).

### Tailwind Breakpoint Reference

| Prefix | Min-width | Device |
|---|---|---|
| (none) | 0px | Mobile first |
| `sm:` | 640px | Large phone |
| `md:` | 768px | Tablet |
| `lg:` | 1024px | Laptop |
| `xl:` | 1280px | Desktop |

### Rules Per Component

**Navigation:**
- Mobile: hamburger menu button, links hidden by default in a collapsible panel
- Desktop `lg:`: horizontal nav with links visible

```html
<nav id="main-nav" class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent px-6 py-5 lg:px-16">
  <div class="max-w-7xl mx-auto flex justify-between items-center">
    <a href="/" class="font-serif text-xl text-ink">Legal<span class="text-gold">Counsel</span></a>
    <button id="nav-toggle" class="lg:hidden text-ink">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
    <div id="nav-links" class="hidden lg:flex items-center gap-8 text-sm text-ink-mid">
      <a href="/search" class="hover:text-gold transition-colors">Find a Lawyer</a>
      @auth
        <a href="{{ route('dashboard') }}" class="btn-primary">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="hover:text-gold transition-colors">Login</a>
        <a href="{{ route('register') }}" class="btn-primary">Register</a>
      @endauth
    </div>
  </div>
  <div id="mobile-menu" class="hidden lg:hidden mt-4 flex flex-col gap-4 text-sm text-ink-mid px-2 pb-4">
    <a href="/search" class="hover:text-gold">Find a Lawyer</a>
    @auth
      <a href="{{ route('dashboard') }}" class="btn-primary w-full text-center">Dashboard</a>
    @else
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}" class="btn-primary w-full text-center">Register</a>
    @endauth
  </div>
</nav>

<script>
  document.getElementById('nav-toggle').addEventListener('click', function () {
    document.getElementById('mobile-menu').classList.toggle('hidden');
  });
</script>
```

**Lawyer Search Grid:**
```html
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  @foreach($lawyers as $lawyer)
  <div class="lawyer-card p-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
    <!-- card content -->
  </div>
  @endforeach
</div>
```

**Footer Grid:**
```html
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
  <!-- footer columns -->
</div>
```

**Hero Section:**
```html
<section class="min-h-screen bg-ink flex items-center px-6 lg:px-16 pt-24">
  <div class="max-w-7xl mx-auto w-full">
    <h1 class="font-serif text-white text-4xl md:text-6xl lg:text-7xl max-w-3xl animate__animated animate__fadeInUp" style="animation-delay:0.1s">
      Find the Right Lawyer, <em>Today</em>
    </h1>
  </div>
</section>
```

**Forms:**
- All form inputs use `w-full` so they fill their container
- On mobile, form fields stack vertically using `flex flex-col`
- On desktop `md:`, forms go side by side using `md:flex-row`

**Admin Tables:**
- On mobile: tables scroll horizontally using `overflow-x-auto`

```html
<div class="overflow-x-auto">
  <table class="w-full text-sm text-left border-collapse">
    <!-- table content -->
  </table>
</div>
```

---

## 12. Step-by-Step Setup Commands

Claude Code must run these commands in this exact order.

### Step 1 — Create the Laravel Project

```bash
composer create-project laravel/laravel lawyers-website "10.*"
cd lawyers-website
```

### Step 2 — Set Up the Database

Edit `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lawyers_db
DB_USERNAME=root
DB_PASSWORD=
```

Create the database:

```bash
php artisan db:create
```

If `db:create` is unavailable, run in MySQL:

```sql
CREATE DATABASE lawyers_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 3 — Install Laravel Breeze

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

### Step 4 — Install Tailwind and All Plugins

```bash
npm install -D tailwindcss postcss autoprefixer
npm install -D @tailwindcss/forms @tailwindcss/typography @tailwindcss/aspect-ratio
npx tailwindcss init -p
```

Replace `tailwind.config.js` with the full config from Section 8.

Replace `resources/css/app.css` with the full CSS from Section 8.

### Step 5 — Install Spatie Permission

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

Open `app/Models/User.php` and add the trait:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
```

### Step 6 — Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### Step 7 — Create the Roles Seeder

```bash
php artisan make:seeder RolesAndAdminSeeder
```

Paste this into `database/seeders/RolesAndAdminSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Create the three system roles and a default admin account.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'lawyer']);
        Role::create(['name' => 'customer']);

        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@lawyers.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('admin');
    }
}
```

Run it:

```bash
php artisan db:seed --class=RolesAndAdminSeeder
```

### Step 8 — Start the Server

```bash
php artisan serve
```

Visit `http://127.0.0.1:8000`

---

## 13. Database Schema

Run each migration command, then paste the schema shown.

### Users Table — Extra Fields

```bash
php artisan make:migration add_fields_to_users_table --table=users
```

```php
Schema::table('users', function (Blueprint $table) {
    $table->string('phone')->nullable()->after('email');
    $table->string('city')->nullable()->after('phone');
    $table->string('address')->nullable()->after('city');
    $table->enum('user_type', ['admin', 'lawyer', 'customer'])->default('customer')->after('address');
});
```

### Lawyers Table

```bash
php artisan make:migration create_lawyers_table
```

```php
Schema::create('lawyers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('full_name');
    $table->string('bar_license')->unique();
    $table->enum('specialization', ['Criminal', 'Divorce', 'Affidavit', 'Civil']);
    $table->string('city');
    $table->string('address');
    $table->string('phone');
    $table->text('bio')->nullable();
    $table->string('photo')->nullable();
    $table->unsignedSmallInteger('experience_years')->default(0);
    $table->decimal('consultation_fee', 8, 2)->nullable();
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->timestamps();
});
```

### Availability Slots Table

```bash
php artisan make:migration create_availability_slots_table
```

```php
Schema::create('availability_slots', function (Blueprint $table) {
    $table->id();
    $table->foreignId('lawyer_id')->constrained()->cascadeOnDelete();
    $table->date('available_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->boolean('is_booked')->default(false);
    $table->timestamps();
});
```

### Appointments Table

```bash
php artisan make:migration create_appointments_table
```

```php
Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
    $table->foreignId('lawyer_id')->constrained('lawyers')->cascadeOnDelete();
    $table->foreignId('slot_id')->constrained('availability_slots')->cascadeOnDelete();
    $table->string('subject');
    $table->string('meeting_place')->nullable();
    $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
    $table->text('notes')->nullable();
    $table->timestamps();
});
```

### Homepage Content Table

```bash
php artisan make:migration create_homepage_contents_table
```

```php
Schema::create('homepage_contents', function (Blueprint $table) {
    $table->id();
    $table->string('section');
    $table->string('title')->nullable();
    $table->text('body')->nullable();
    $table->string('image_path')->nullable();
    $table->timestamps();
});
```

Run all migrations:

```bash
php artisan migrate
```

---

## 14. Folder Structure

Claude Code must create this exact structure:

```
lawyers-website/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PublicController.php
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── AdminLawyerController.php
│   │   │   │   ├── AdminBookingController.php
│   │   │   │   ├── AdminSlotController.php
│   │   │   │   └── AdminHomepageController.php
│   │   │   ├── Lawyer/
│   │   │   │   ├── LawyerDashboardController.php
│   │   │   │   ├── LawyerProfileController.php
│   │   │   │   └── LawyerSlotController.php
│   │   │   └── Customer/
│   │   │       ├── CustomerDashboardController.php
│   │   │       ├── CustomerSearchController.php
│   │   │       └── CustomerAppointmentController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       ├── LawyerMiddleware.php
│   │       └── CustomerMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Lawyer.php
│       ├── AvailabilitySlot.php
│       ├── Appointment.php
│       └── HomepageContent.php
│
├── resources/
│   ├── css/
│   │   └── app.css            (Tailwind + design system — see Section 8)
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   ├── public.blade.php
│       │   ├── admin.blade.php
│       │   ├── lawyer.blade.php
│       │   └── customer.blade.php
│       ├── public/
│       │   ├── home.blade.php
│       │   ├── search.blade.php
│       │   └── lawyer-profile.blade.php
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── lawyers/
│       │   │   └── index.blade.php
│       │   ├── bookings/
│       │   │   └── index.blade.php
│       │   ├── slots/
│       │   │   └── index.blade.php
│       │   └── homepage/
│       │       └── index.blade.php
│       ├── lawyer/
│       │   ├── dashboard.blade.php
│       │   ├── profile/
│       │   │   └── edit.blade.php
│       │   └── slots/
│       │       └── index.blade.php
│       └── customer/
│           ├── dashboard.blade.php
│           ├── search.blade.php
│           └── appointments/
│               ├── index.blade.php
│               └── create.blade.php
│
├── routes/
│   └── web.php
├── tailwind.config.js
└── vite.config.js
```

---

## 15. Routes

Paste this entire block into `routes/web.php`:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLawyerController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminSlotController;
use App\Http\Controllers\Admin\AdminHomepageController;
use App\Http\Controllers\Lawyer\LawyerDashboardController;
use App\Http\Controllers\Lawyer\LawyerProfileController;
use App\Http\Controllers\Lawyer\LawyerSlotController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerSearchController;
use App\Http\Controllers\Customer\CustomerAppointmentController;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/search', [PublicController::class, 'search'])->name('public.search');
Route::get('/lawyer/{id}', [PublicController::class, 'lawyerProfile'])->name('public.lawyer');

Route::get('/dashboard', function () {
    if (auth()->user()->hasRole('admin'))  return redirect()->route('admin.dashboard');
    if (auth()->user()->hasRole('lawyer')) return redirect()->route('lawyer.dashboard');
    return redirect()->route('customer.dashboard');
})->middleware('auth')->name('dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/',                           [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/lawyers',                    [AdminLawyerController::class, 'index'])->name('lawyers.index');
    Route::post('/lawyers/{id}/approve',      [AdminLawyerController::class, 'approve'])->name('lawyers.approve');
    Route::post('/lawyers/{id}/reject',       [AdminLawyerController::class, 'reject'])->name('lawyers.reject');
    Route::delete('/lawyers/{id}',            [AdminLawyerController::class, 'destroy'])->name('lawyers.destroy');
    Route::get('/bookings',                   [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/slots',                      [AdminSlotController::class, 'index'])->name('slots.index');
    Route::get('/homepage',                   [AdminHomepageController::class, 'index'])->name('homepage.index');
    Route::put('/homepage/{id}',              [AdminHomepageController::class, 'update'])->name('homepage.update');
});

Route::prefix('lawyer')->name('lawyer.')->middleware(['auth', 'role:lawyer'])->group(function () {
    Route::get('/',                   [LawyerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',            [LawyerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile',            [LawyerProfileController::class, 'update'])->name('profile.update');
    Route::get('/slots',              [LawyerSlotController::class, 'index'])->name('slots.index');
    Route::post('/slots',             [LawyerSlotController::class, 'store'])->name('slots.store');
    Route::delete('/slots/{id}',      [LawyerSlotController::class, 'destroy'])->name('slots.destroy');
});

Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/',                               [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/search',                         [CustomerSearchController::class, 'index'])->name('search');
    Route::get('/appointments',                   [CustomerAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/book/{lawyerId}',   [CustomerAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments',                  [CustomerAppointmentController::class, 'store'])->name('appointments.store');
    Route::delete('/appointments/{id}',           [CustomerAppointmentController::class, 'destroy'])->name('appointments.cancel');
});
```

---

## 16. Controllers

### Create All Controllers

```bash
php artisan make:controller PublicController
php artisan make:controller Admin/AdminDashboardController
php artisan make:controller Admin/AdminLawyerController
php artisan make:controller Admin/AdminBookingController
php artisan make:controller Admin/AdminSlotController
php artisan make:controller Admin/AdminHomepageController
php artisan make:controller Lawyer/LawyerDashboardController
php artisan make:controller Lawyer/LawyerProfileController
php artisan make:controller Lawyer/LawyerSlotController
php artisan make:controller Customer/CustomerDashboardController
php artisan make:controller Customer/CustomerSearchController
php artisan make:controller Customer/CustomerAppointmentController
```

### Create All Models

```bash
php artisan make:model Lawyer
php artisan make:model AvailabilitySlot
php artisan make:model Appointment
php artisan make:model HomepageContent
```

### Create Middleware

```bash
php artisan make:middleware AdminMiddleware
php artisan make:middleware LawyerMiddleware
php artisan make:middleware CustomerMiddleware
```

### PublicController — Full Implementation

```php
<?php

namespace App\Http\Controllers;

use App\Models\Lawyer;
use App\Models\HomepageContent;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display the public homepage with featured lawyers and homepage content.
     */
    public function home()
    {
        $featuredLawyers = Lawyer::where('status', 'approved')->latest()->take(6)->get();
        $content = HomepageContent::all()->keyBy('section');
        return view('public.home', compact('featuredLawyers', 'content'));
    }

    /**
     * Handle the lawyer search with optional city and service filters.
     */
    public function search(Request $request)
    {
        $lawyerQuery = Lawyer::where('status', 'approved');

        if ($request->filled('city')) {
            $lawyerQuery->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('service')) {
            $lawyerQuery->where('specialization', $request->service);
        }

        $lawyers = $lawyerQuery->get();
        return view('public.search', compact('lawyers'));
    }

    /**
     * Show the full public profile for a single approved lawyer.
     */
    public function lawyerProfile($id)
    {
        $lawyer = Lawyer::where('status', 'approved')->with('availabilitySlots')->findOrFail($id);
        return view('public.lawyer-profile', compact('lawyer'));
    }
}
```

### AdminLawyerController — Full Implementation

```php
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;

class AdminLawyerController extends Controller
{
    /**
     * Show all lawyer registrations for admin review.
     */
    public function index()
    {
        $lawyers = Lawyer::with('user')->latest()->get();
        return view('admin.lawyers.index', compact('lawyers'));
    }

    /**
     * Approve a lawyer so they can log in and appear in search results.
     */
    public function approve($id)
    {
        Lawyer::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('success', 'Lawyer approved.');
    }

    /**
     * Reject a lawyer registration.
     */
    public function reject($id)
    {
        Lawyer::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Lawyer rejected.');
    }

    /**
     * Permanently delete a lawyer profile and their user account.
     */
    public function destroy($id)
    {
        Lawyer::findOrFail($id)->delete();
        return back()->with('success', 'Lawyer removed.');
    }
}
```

### CustomerAppointmentController — Full Implementation

```php
<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Lawyer;
use App\Models\Appointment;
use App\Models\AvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAppointmentController extends Controller
{
    /**
     * Show all appointments belonging to the logged-in customer.
     */
    public function index()
    {
        $appointments = Appointment::where('customer_id', Auth::id())
            ->with('lawyer')
            ->latest()
            ->get();
        return view('customer.appointments.index', compact('appointments'));
    }

    /**
     * Show the booking form for a specific lawyer with their available slots.
     */
    public function create($lawyerId)
    {
        $lawyer = Lawyer::where('status', 'approved')->findOrFail($lawyerId);
        $availableSlots = AvailabilitySlot::where('lawyer_id', $lawyerId)
            ->where('is_booked', false)
            ->where('available_date', '>=', today())
            ->get();
        return view('customer.appointments.create', compact('lawyer', 'availableSlots'));
    }

    /**
     * Save a new appointment and mark the selected slot as booked.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lawyer_id' => 'required|exists:lawyers,id',
            'slot_id'   => 'required|exists:availability_slots,id',
            'subject'   => 'required|string|max:255',
        ]);

        $slot = AvailabilitySlot::findOrFail($request->slot_id);

        Appointment::create([
            'customer_id'   => Auth::id(),
            'lawyer_id'     => $request->lawyer_id,
            'slot_id'       => $request->slot_id,
            'subject'       => $request->subject,
            'meeting_place' => $request->meeting_place,
        ]);

        $slot->update(['is_booked' => true]);

        return redirect()->route('customer.appointments.index')->with('success', 'Appointment booked.');
    }

    /**
     * Cancel an appointment and free the slot back to available.
     */
    public function destroy($id)
    {
        $appointment = Appointment::where('customer_id', Auth::id())->findOrFail($id);
        AvailabilitySlot::find($appointment->slot_id)?->update(['is_booked' => false]);
        $appointment->delete();
        return back()->with('success', 'Appointment cancelled.');
    }
}
```

---

## 17. Views

### Public Layout — `resources/views/layouts/public.blade.php`

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'LegalCounsel — Find Your Lawyer')</title>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-parchment text-ink-mid font-sans">

  <div id="page-overlay" class="fixed inset-0 bg-ink z-[9999] pointer-events-none opacity-0 transition-opacity duration-300"></div>

  <nav id="main-nav" class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent px-6 py-5 lg:px-16">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <a href="{{ route('home') }}" class="font-serif text-xl text-ink no-underline">
        Legal<span class="text-gold">Counsel</span>
      </a>
      <button id="nav-toggle" class="lg:hidden text-ink">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
      <div class="hidden lg:flex items-center gap-8 text-sm text-ink-mid">
        <a href="{{ route('public.search') }}" class="hover:text-gold transition-colors">Find a Lawyer</a>
        @auth
          <a href="{{ route('dashboard') }}" class="btn-primary">Dashboard</a>
        @else
          <a href="{{ route('login') }}" class="hover:text-gold transition-colors">Login</a>
          <a href="{{ route('register') }}" class="btn-primary">Register</a>
        @endauth
      </div>
    </div>
    <div id="mobile-menu" class="hidden lg:hidden mt-4 flex flex-col gap-4 text-sm text-ink-mid px-2 pb-4 bg-warm-surface border-t border-warm-border">
      <a href="{{ route('public.search') }}" class="pt-3 hover:text-gold">Find a Lawyer</a>
      @auth
        <a href="{{ route('dashboard') }}" class="btn-primary text-center">Dashboard</a>
      @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}" class="btn-primary text-center">Register</a>
      @endauth
    </div>
  </nav>

  <main>
    @yield('content')
  </main>

  <footer class="bg-ink text-white/65 pt-20 pb-10 px-6 lg:px-16">
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
      <div data-aos="fade-up" data-aos-delay="0">
        <div class="w-10 h-0.5 bg-gold mb-4"></div>
        <h5 class="font-serif text-white text-lg mb-3">LegalCounsel</h5>
        <p class="text-sm leading-loose">Connecting you with the right legal expertise.</p>
      </div>
      <div data-aos="fade-up" data-aos-delay="100">
        <div class="w-10 h-0.5 bg-gold mb-4"></div>
        <h5 class="font-serif text-white text-lg mb-3">Practice Areas</h5>
        <a href="{{ route('public.search', ['service' => 'Criminal']) }}" class="footer-link">Criminal Law</a>
        <a href="{{ route('public.search', ['service' => 'Divorce']) }}" class="footer-link">Divorce</a>
        <a href="{{ route('public.search', ['service' => 'Affidavit']) }}" class="footer-link">Affidavit</a>
        <a href="{{ route('public.search', ['service' => 'Civil']) }}" class="footer-link">Civil Law</a>
      </div>
      <div data-aos="fade-up" data-aos-delay="200">
        <div class="w-10 h-0.5 bg-gold mb-4"></div>
        <h5 class="font-serif text-white text-lg mb-3">Quick Links</h5>
        <a href="{{ route('home') }}" class="footer-link">Home</a>
        <a href="{{ route('public.search') }}" class="footer-link">Find a Lawyer</a>
        <a href="{{ route('register') }}" class="footer-link">Register</a>
      </div>
      <div data-aos="fade-up" data-aos-delay="300">
        <div class="w-10 h-0.5 bg-gold mb-4"></div>
        <h5 class="font-serif text-white text-lg mb-3">Contact</h5>
        <a href="mailto:info@legalcounsel.com" class="footer-link">info@legalcounsel.com</a>
      </div>
    </div>
    <div class="max-w-7xl mx-auto mt-12 pt-6 border-t border-white/10 text-center text-white/30 text-xs">
      &copy; {{ date('Y') }} LegalCounsel. All rights reserved.
    </div>
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 700, once: true, offset: 80, easing: 'ease-out-cubic' });

    window.addEventListener('scroll', function () {
      const nav = document.getElementById('main-nav');
      if (window.scrollY > 80) {
        nav.classList.add('bg-warm-surface', 'shadow-sm');
        nav.classList.remove('bg-transparent');
      } else {
        nav.classList.remove('bg-warm-surface', 'shadow-sm');
        nav.classList.add('bg-transparent');
      }
    });

    document.getElementById('nav-toggle').addEventListener('click', function () {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    document.querySelectorAll('a:not([target="_blank"])').forEach(function (link) {
      link.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href && href !== '#' && !href.startsWith('http')) {
          e.preventDefault();
          document.getElementById('page-overlay').style.opacity = '1';
          setTimeout(() => { window.location.href = href; }, 280);
        }
      });
    });
  </script>
</body>
</html>
```

### Home View — `resources/views/public/home.blade.php`

```html
@extends('layouts.public')
@section('title', 'LegalCounsel — Find Your Lawyer')

@section('content')

{{-- Hero --}}
<section class="min-h-screen bg-ink flex items-center px-6 lg:px-16 pt-24">
  <div class="max-w-7xl mx-auto w-full">
    <p class="text-gold text-xs tracking-widest uppercase mb-6 animate__animated animate__fadeInUp" style="animation-delay:0s">
      Legal Services Platform
    </p>
    <h1 class="font-serif text-white text-4xl md:text-6xl lg:text-7xl max-w-3xl leading-tight animate__animated animate__fadeInUp" style="animation-delay:0.1s">
      Find the Right Lawyer, <em>Today</em>
    </h1>
    <p class="text-white/60 text-lg mt-6 max-w-xl animate__animated animate__fadeInUp" style="animation-delay:0.3s">
      Search by specialty and location. Book your consultation in minutes.
    </p>
    <a href="{{ route('public.search') }}" class="btn-primary mt-10 inline-block animate__animated animate__fadeInUp" style="animation-delay:0.5s">
      Find a Lawyer
    </a>
  </div>
</section>

{{-- Service Categories --}}
<section class="py-24 px-6 lg:px-16 bg-parchment">
  <div class="max-w-7xl mx-auto">
    <p class="text-gold text-xs tracking-widest uppercase mb-3" data-aos="fade-up">Practice Areas</p>
    <h2 class="font-serif text-3xl md:text-4xl mb-12" data-aos="fade-up" data-aos-delay="50">
      What Do You Need Help With?
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $index => $service)
      <a href="{{ route('public.search', ['service' => $service]) }}"
         class="block border border-warm-border p-8 transition-all duration-300 hover:-translate-y-1 hover:border-gold group"
         data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
        <p class="font-serif text-2xl text-ink group-hover:text-gold transition-colors">{{ $service }}</p>
        <p class="text-xs text-ink-muted mt-2 tracking-widest uppercase">Law</p>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- Featured Lawyers --}}
<section class="py-24 px-6 lg:px-16 bg-warm-surface">
  <div class="max-w-7xl mx-auto">
    <p class="text-gold text-xs tracking-widest uppercase mb-3" data-aos="fade-up">Our Lawyers</p>
    <h2 class="font-serif text-3xl md:text-4xl mb-12" data-aos="fade-up" data-aos-delay="50">
      Featured Legal Professionals
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($featuredLawyers as $lawyer)
      <a href="{{ route('public.lawyer', $lawyer->id) }}"
         class="lawyer-card p-6 group"
         data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
        <div class="flex items-center gap-4 mb-4">
          <div class="w-14 h-14 overflow-hidden shrink-0">
            <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=1A1A1A&color=B8860B' }}"
                 alt="{{ $lawyer->full_name }}"
                 class="w-full h-full object-cover grayscale-[25%] group-hover:grayscale-0 scale-100 group-hover:scale-105 transition-all duration-400">
          </div>
          <div>
            <p class="font-serif text-ink font-semibold">{{ $lawyer->full_name }}</p>
            <p class="text-xs text-ink-muted tracking-widest uppercase mt-0.5">{{ $lawyer->specialization }}</p>
          </div>
        </div>
        <p class="text-sm text-ink-mid">{{ $lawyer->city }}</p>
        <p class="text-xs text-gold mt-3 tracking-wide uppercase">View Profile →</p>
      </a>
      @endforeach
    </div>
  </div>
</section>

@endsection
```

### Search View — `resources/views/public/search.blade.php`

```html
@extends('layouts.public')
@section('title', 'Find a Lawyer — LegalCounsel')

@section('content')

<div class="pt-32 pb-24 px-6 lg:px-16">
  <div class="max-w-7xl mx-auto">

    <h1 class="font-serif text-4xl md:text-5xl text-ink mb-10" data-aos="fade-up">Find a Lawyer</h1>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('public.search') }}"
          class="flex flex-col md:flex-row gap-4 mb-12" data-aos="fade-up" data-aos-delay="100">
      <input type="text" name="city" value="{{ request('city') }}"
             placeholder="City or location..."
             class="search-field md:w-72">
      <select name="service" class="search-field md:w-56">
        <option value="">All Practice Areas</option>
        @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
          <option value="{{ $service }}" {{ request('service') === $service ? 'selected' : '' }}>
            {{ $service }}
          </option>
        @endforeach
      </select>
      <button type="submit" class="btn-primary">Search</button>
    </form>

    {{-- Service Tags --}}
    <div class="flex flex-wrap gap-3 mb-10" data-aos="fade-up" data-aos-delay="150">
      @foreach(['Criminal', 'Divorce', 'Affidavit', 'Civil'] as $service)
        <span class="service-tag {{ request('service') === $service ? 'active' : '' }}"
              onclick="document.querySelector('[name=service]').value='{{ $service }}'; this.closest('form').submit()">
          {{ $service }}
        </span>
      @endforeach
    </div>

    {{-- Results --}}
    @if($lawyers->isEmpty())
      <p class="text-ink-muted text-center py-20" data-aos="fade-up">No lawyers found for your search. Try a different city or practice area.</p>
    @else
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($lawyers as $lawyer)
        <a href="{{ route('public.lawyer', $lawyer->id) }}"
           class="lawyer-card p-6 group"
           data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
          <div class="flex items-center gap-4 mb-4">
            <div class="w-14 h-14 overflow-hidden shrink-0">
              <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=1A1A1A&color=B8860B' }}"
                   alt="{{ $lawyer->full_name }}"
                   class="w-full h-full object-cover grayscale-[25%] group-hover:grayscale-0 transition-all duration-400">
            </div>
            <div>
              <p class="font-serif text-ink font-semibold">{{ $lawyer->full_name }}</p>
              <p class="text-xs text-gold tracking-widest uppercase mt-0.5">{{ $lawyer->specialization }}</p>
            </div>
          </div>
          <p class="text-sm text-ink-muted">{{ $lawyer->city }}</p>
          <p class="text-xs mt-4 tracking-wide uppercase text-gold">View Profile →</p>
        </a>
        @endforeach
      </div>
    @endif

  </div>
</div>

@endsection
```

### Lawyer Profile View — `resources/views/public/lawyer-profile.blade.php`

```html
@extends('layouts.public')
@section('title', $lawyer->full_name . ' — LegalCounsel')

@section('content')

<div class="pt-32 pb-24 px-6 lg:px-16">
  <div class="max-w-5xl mx-auto">

    {{-- Profile Header --}}
    <div class="flex flex-col md:flex-row gap-10 mb-16" data-aos="fade-up">
      <div class="w-32 h-32 md:w-48 md:h-48 overflow-hidden shrink-0">
        <img src="{{ $lawyer->photo ? asset('storage/' . $lawyer->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($lawyer->full_name) . '&background=1A1A1A&color=B8860B&size=200' }}"
             alt="{{ $lawyer->full_name }}"
             class="w-full h-full object-cover grayscale-[20%] hover:grayscale-0 transition-all duration-500">
      </div>
      <div>
        <p class="text-gold text-xs tracking-widest uppercase mb-2">{{ $lawyer->specialization }} Law</p>
        <h1 class="font-serif text-4xl md:text-5xl text-ink mb-4">{{ $lawyer->full_name }}</h1>
        <p class="text-ink-muted text-sm">{{ $lawyer->city }} · {{ $lawyer->experience_years }} years experience</p>
        @if($lawyer->consultation_fee)
          <p class="text-sm text-ink mt-2">Consultation: <span class="font-semibold">${{ number_format($lawyer->consultation_fee, 2) }}</span></p>
        @endif
      </div>
    </div>

    {{-- Bio --}}
    @if($lawyer->bio)
    <div class="mb-16 border-l-2 border-gold pl-8" data-aos="fade-up">
      <p class="text-ink-mid leading-relaxed">{{ $lawyer->bio }}</p>
    </div>
    @endif

    {{-- Book Appointment --}}
    <div data-aos="fade-up" data-aos-delay="100">
      <div class="w-10 h-0.5 bg-gold mb-6"></div>
      <h2 class="font-serif text-3xl text-ink mb-8">Book an Appointment</h2>

      @auth
        @if($lawyer->availabilitySlots->where('is_booked', false)->count())
          <form method="POST" action="{{ route('customer.appointments.store') }}" class="max-w-lg">
            @csrf
            <input type="hidden" name="lawyer_id" value="{{ $lawyer->id }}">

            <div class="mb-6">
              <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Select a Time Slot</label>
              @foreach($lawyer->availabilitySlots->where('is_booked', false) as $slot)
              <label class="flex items-center gap-3 p-4 border border-warm-border mb-2 cursor-pointer hover:border-gold transition-colors">
                <input type="radio" name="slot_id" value="{{ $slot->id }}" required>
                <span class="text-sm text-ink">{{ \Carbon\Carbon::parse($slot->available_date)->format('D, M j Y') }} · {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}</span>
              </label>
              @endforeach
            </div>

            <div class="mb-6">
              <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Subject</label>
              <input type="text" name="subject" required class="search-field" placeholder="Briefly describe your matter">
            </div>

            <div class="mb-8">
              <label class="block text-xs tracking-widest uppercase text-ink-muted mb-2">Preferred Meeting Place (optional)</label>
              <input type="text" name="meeting_place" class="search-field" placeholder="Office, video call, etc.">
            </div>

            <button type="submit" class="btn-primary animate-pulse-gold">Book Appointment</button>
          </form>
        @else
          <p class="text-ink-muted">No available slots at this time. Check back soon.</p>
        @endif
      @else
        <p class="text-ink-muted">
          Please <a href="{{ route('login') }}" class="text-gold underline">log in</a> or
          <a href="{{ route('register') }}" class="text-gold underline">register</a> to book an appointment.
        </p>
      @endauth
    </div>

  </div>
</div>

@endsection
```

---

## 18. Documentation Checklist

All 13 items required per the project specification:

- [ ] Certificate of Completion
- [ ] Table of Contents
- [ ] Problem Definition
- [ ] Customer Requirement Specification
- [ ] Project Plan
- [ ] E-R Diagrams
- [ ] Algorithms
- [ ] GUI Standards Document
- [ ] Interface Design Document
- [ ] Task Sheet
- [ ] Project Review and Monitoring Report
- [ ] Unit Testing Check List
- [ ] Final Check List

---

## 19. Unit Testing Checklist

**Auth:**
- [ ] Customer can register and log in
- [ ] Lawyer registers and lands in pending state
- [ ] `admin@lawyers.com` / `password` logs in and reaches admin dashboard
- [ ] Unauthenticated user is redirected to login

**Public:**
- [ ] Homepage loads with hero, service categories, featured lawyers
- [ ] Search without login works
- [ ] City filter returns correct results
- [ ] Service filter (Criminal / Divorce / Affidavit / Civil) returns correct results
- [ ] Search card shows only: name, service, city (minimal info per spec)
- [ ] Clicking a card navigates to full lawyer profile

**Admin:**
- [ ] Admin sees all lawyer registrations
- [ ] Admin can approve a lawyer — status becomes `approved`
- [ ] Admin can reject a lawyer — status becomes `rejected`
- [ ] Admin sees all bookings
- [ ] Admin can edit homepage content

**Lawyer:**
- [ ] Approved lawyer logs in and reaches dashboard
- [ ] Lawyer can update profile fields
- [ ] Lawyer can add a slot
- [ ] Lawyer can delete a slot
- [ ] Pending/rejected lawyer cannot reach dashboard

**Customer:**
- [ ] Customer searches by location
- [ ] Customer searches by service type
- [ ] Customer views full lawyer profile
- [ ] Customer books an appointment — slot becomes `is_booked = true`
- [ ] Customer views their appointments list
- [ ] Customer cancels appointment — slot becomes `is_booked = false`

**Responsive:**
- [ ] Homepage looks correct on 375px mobile
- [ ] Hamburger menu works on mobile
- [ ] Search results grid collapses to 1 column on mobile
- [ ] Footer grid collapses to 2 then 1 column on small screens
- [ ] Admin tables scroll horizontally on mobile

---

## 20. Final Checklist

- [ ] All 3 roles work — Admin, Lawyer, Customer
- [ ] Public homepage and search work without login
- [ ] Lawyer approval flow works end to end
- [ ] Full customer booking journey works end to end
- [ ] Navbar turns from transparent to white on scroll
- [ ] AOS stagger animations on cards, service tiles, footer
- [ ] Animate.css hero fadeInUp with staggered delays
- [ ] Dark page overlay fades in on internal navigation
- [ ] Gold `::before` border slides in on lawyer card hover
- [ ] Book button has `animate-pulse-gold` animation
- [ ] Search input has gold glow on focus
- [ ] Service tags toggle `.active` correctly
- [ ] Lawyer photo transitions from desaturated to full color on hover
- [ ] Hamburger menu toggles on mobile
- [ ] Search grid: 1 col mobile / 2 col tablet / 3 col desktop
- [ ] Footer grid: 1 col mobile / 2 col tablet / 4 col desktop
- [ ] Admin tables have `overflow-x-auto` on mobile
- [ ] No `//` inline comments anywhere in PHP files
- [ ] No `/* */` block comments anywhere in PHP files
- [ ] All PHP functions have PHPDoc `/** */` blocks
- [ ] No dead code, no commented-out lines
- [ ] Tailwind config includes all 3 plugins: forms, typography, aspect-ratio
- [ ] `npm run build` completes with no errors
- [ ] All 13 documentation items are complete

---

## 21. Claude Code Step-by-Step Build Order

Claude Code must follow this order. Complete each step fully before moving to the next.

```
Step 1  → Run all commands in Section 12 from top to bottom
Step 2  → Replace tailwind.config.js with the config in Section 8
Step 3  → Replace resources/css/app.css with the CSS in Section 8
Step 4  → Run npm run build and confirm it succeeds
Step 5  → Run all migration commands from Section 13 in order
Step 6  → Run php artisan migrate
Step 7  → Create and run RolesAndAdminSeeder from Section 12
Step 8  → Create all models listed in Section 16 with make:model
Step 9  → Create all controllers listed in Section 16 with make:controller
Step 10 → Create all middleware listed in Section 16 with make:middleware
Step 11 → Paste the full routes block from Section 15 into routes/web.php
Step 12 → Implement PublicController, AdminLawyerController,
           and CustomerAppointmentController using the code in Section 16
Step 13 → Implement remaining controllers following the same PHPDoc pattern
Step 14 → Create resources/views/layouts/public.blade.php from Section 17
Step 15 → Create resources/views/public/home.blade.php from Section 17
Step 16 → Create resources/views/public/search.blade.php from Section 17
Step 17 → Create resources/views/public/lawyer-profile.blade.php from Section 17
Step 18 → Create admin, lawyer, and customer layouts mirroring the public layout
           but with a sidebar instead of the top nav
Step 19 → Create all remaining blade views in the folder structure from Section 14
Step 20 → Run php artisan serve and test every item in the Unit Testing Checklist
Step 21 → Fix any failures found during testing
Step 22 → Verify every item in the Final Checklist
```