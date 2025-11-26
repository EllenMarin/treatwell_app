# Agendea Styling Guide

## 🎨 Brand Identity

**Application Name:** Agendea  
**Tagline:** Book Beauty & Wellness Appointments

### Brand Colors

#### Primary Colors (Blue)
- **Primary-50:** `#f0f9ff` - Lightest blue
- **Primary-600:** `#0284c7` - Main brand color
- **Primary-700:** `#0369a1` - Hover states

#### Secondary Colors (Purple/Magenta)
- **Secondary-600:** `#c026d3` - Accent color
- **Secondary-700:** `#a21caf` - Hover states

#### Status Colors
- **Success:** Green (`#22c55e`) - Confirmed bookings
- **Warning:** Yellow (`#f59e0b`) - Pending bookings
- **Danger:** Red (`#ef4444`) - Cancelled bookings
- **Info:** Blue (`#0ea5e9`) - Completed bookings

### Typography

**Primary Font:** Inter (Sans-serif)  
**Display Font:** Poppins (Headings)

```html
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|poppins:600,700" rel="stylesheet" />
```

---

## 🎯 Design System

### Custom CSS Classes

#### Buttons

```html
<!-- Primary Button -->
<button class="btn btn-primary">Click Me</button>

<!-- Secondary Button -->
<button class="btn btn-secondary">Click Me</button>

<!-- Success Button -->
<button class="btn btn-success">Confirm</button>

<!-- Danger Button -->
<button class="btn btn-danger">Delete</button>

<!-- Outline Button -->
<button class="btn btn-outline">Cancel</button>

<!-- Ghost Button -->
<button class="btn btn-ghost">Link</button>

<!-- Button Sizes -->
<button class="btn btn-primary btn-sm">Small</button>
<button class="btn btn-primary">Default</button>
<button class="btn btn-primary btn-lg">Large</button>
```

#### Cards

```html
<!-- Basic Card -->
<div class="card">
    <div class="card-header">
        <h3>Card Title</h3>
    </div>
    <div class="card-body">
        <p>Card content goes here</p>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary">Action</button>
    </div>
</div>
```

#### Form Elements

```html
<!-- Input Field -->
<div class="form-group">
    <label class="label" for="email">Email Address</label>
    <input type="email" id="email" class="input" placeholder="you@example.com">
    <p class="form-help">We'll never share your email</p>
</div>

<!-- Input with Error -->
<div class="form-group">
    <label class="label" for="password">Password</label>
    <input type="password" id="password" class="input input-error">
    <p class="form-error">Password is required</p>
</div>
```

#### Badges & Status

```html
<!-- Status Badges -->
<span class="status-pending">Pending</span>
<span class="status-confirmed">Confirmed</span>
<span class="status-completed">Completed</span>
<span class="status-cancelled">Cancelled</span>
<span class="status-no-show">No Show</span>

<!-- Color Badges -->
<span class="badge badge-primary">Primary</span>
<span class="badge badge-success">Success</span>
<span class="badge badge-warning">Warning</span>
<span class="badge badge-danger">Danger</span>
<span class="badge badge-gray">Gray</span>
```

#### Alerts

```html
<!-- Success Alert -->
<div class="alert alert-success">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        Operation successful!
    </div>
</div>

<!-- Error Alert -->
<div class="alert alert-error">Error message</div>

<!-- Warning Alert -->
<div class="alert alert-warning">Warning message</div>

<!-- Info Alert -->
<div class="alert alert-info">Info message</div>
```

#### Navigation

```html
<!-- Nav Link -->
<a href="#" class="nav-link">Link</a>

<!-- Active Nav Link -->
<a href="#" class="nav-link nav-link-active">Active Link</a>
```

#### Tables

```html
<table class="table">
    <thead class="table-header">
        <tr>
            <th class="table-header-cell">Name</th>
            <th class="table-header-cell">Email</th>
        </tr>
    </thead>
    <tbody class="table-body">
        <tr>
            <td class="table-cell">John Doe</td>
            <td class="table-cell">john@example.com</td>
        </tr>
    </tbody>
</table>
```

---

## 🎨 Gradient Utilities

```html
<!-- Primary Gradient Background -->
<div class="gradient-primary">Content</div>

<!-- Secondary Gradient Background -->
<div class="gradient-secondary">Content</div>

<!-- Hero Gradient (Primary to Secondary) -->
<div class="gradient-hero">Content</div>

<!-- Text Gradient -->
<h1 class="text-gradient">Agendea</h1>
```

---

## 📱 Responsive Design

All components are mobile-first and responsive:

- **Mobile:** < 640px
- **Tablet:** 640px - 1024px
- **Desktop:** > 1024px

Example:
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Responsive grid -->
</div>
```

---

## ✨ Animations

### Built-in Animations

```html
<!-- Fade In -->
<div class="animate-fade-in">Content</div>

<!-- Slide Down -->
<div class="animate-slide-down">Content</div>

<!-- Skeleton Loading -->
<div class="skeleton h-4 w-full"></div>
```

### Custom Animations

```css
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
```

---

## 🏗️ Layout Structure

### Main Layout (`layouts/app.blade.php`)

```
┌─────────────────────────────────┐
│         Navigation Bar          │ ← Sticky header with logo & menu
├─────────────────────────────────┤
│                                 │
│         Page Content            │ ← @yield('content')
│                                 │
├─────────────────────────────────┤
│           Footer                │ ← Links & copyright
└─────────────────────────────────┘
```

### Navigation Features
- Responsive mobile menu
- User dropdown menu
- Role-based navigation links
- Active link highlighting
- Sticky positioning

### Footer Features
- Brand information
- Social media links
- Quick links for customers
- Quick links for businesses
- Copyright notice

---

## 📄 Page Templates

### Welcome Page
- Hero section with gradient background
- Features section (3-column grid)
- How it works (3-step process)
- Popular categories
- Call-to-action section
- Statistics section

### Login Page
- Centered card layout
- Icon-enhanced form fields
- Remember me checkbox
- Forgot password link
- Sign up links for both customer and business
- Terms & privacy policy links

### Dashboard Pages
- Page header with title and actions
- Quick stats cards
- Data tables with pagination
- Action buttons
- Status badges

---

## 🎯 Best Practices

### 1. Consistent Spacing
Use Tailwind's spacing scale:
- `p-4` for padding
- `m-4` for margin
- `gap-4` for grid/flex gaps

### 2. Color Usage
- **Primary:** Main actions, links, brand elements
- **Secondary:** Accent elements, special features
- **Success:** Positive actions, confirmations
- **Danger:** Destructive actions, errors
- **Warning:** Cautions, pending states

### 3. Typography Hierarchy
```html
<h1 class="text-4xl font-bold">Main Heading</h1>
<h2 class="text-3xl font-semibold">Section Heading</h2>
<h3 class="text-2xl font-semibold">Subsection</h3>
<p class="text-base">Body text</p>
<p class="text-sm text-gray-600">Helper text</p>
```

### 4. Interactive States
Always include hover, focus, and active states:
```html
<button class="btn btn-primary hover:bg-primary-700 focus:ring-2 focus:ring-primary-500">
    Button
</button>
```

### 5. Accessibility
- Use semantic HTML
- Include ARIA labels where needed
- Ensure sufficient color contrast
- Make interactive elements keyboard-accessible

---

## 🚀 Development Workflow

### 1. Install Dependencies
```bash
npm install
```

### 2. Development Mode (Hot Reload)
```bash
npm run dev
```

### 3. Production Build
```bash
npm run build
```

### 4. File Structure
```
resources/
├── css/
│   └── app.css          # Main CSS file with custom classes
├── js/
│   └── app.js           # JavaScript functionality
└── views/
    ├── layouts/
    │   └── app.blade.php    # Main layout
    ├── auth/
    │   └── login.blade.php  # Login page
    ├── customer/
    ├── business/
    └── welcome.blade.php    # Homepage
```

---

## 📦 Assets

### CSS
- **Location:** `resources/css/app.css`
- **Compiled to:** `public/build/assets/app-[hash].css`

### JavaScript
- **Location:** `resources/js/app.js`
- **Compiled to:** `public/build/assets/app-[hash].js`

### Including in Blade Templates
```blade
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

---

## 🎨 Icon System

Using Heroicons (SVG icons):

```html
<!-- Calendar Icon -->
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
</svg>
```

Common icons used:
- Calendar (booking)
- User (profile)
- Building (business)
- Check (success)
- X (close/error)
- Menu (mobile navigation)

---

## 📝 Notes

- All custom classes are defined in `resources/css/app.css`
- Tailwind CSS v4 is used with the new `@theme` directive
- The design is fully responsive and mobile-first
- Dark mode support can be added in the future
- All animations are performant and use CSS transforms

---

**Last Updated:** {{ date('Y-m-d') }}  
**Version:** 1.0.0  
**Maintained by:** Agendea Development Team

