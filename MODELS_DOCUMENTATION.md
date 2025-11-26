# Models Documentation

## Overview

This document provides detailed information about all the models in the Treatwell Clone application, their relationships, and usage examples.

## Models

### 1. User Model

**Location**: `app/Models/User.php`

**Purpose**: Represents all users in the system (customers, business owners, staff, admins)

**Fields**:
- `id`: Primary key
- `name`: User's full name
- `email`: Unique email address
- `password`: Hashed password
- `phone`: Contact phone number (optional)
- `avatar`: Profile picture URL (optional)
- `email_verified_at`: Email verification timestamp
- `remember_token`: For "remember me" functionality
- `created_at`, `updated_at`: Timestamps

**Relationships**:
- `roles()`: Many-to-many with Role
- `businesses()`: One-to-many (as owner)
- `bookings()`: One-to-many (as customer)
- `staffBookings()`: One-to-many (as assigned staff)
- `employedAt()`: Many-to-many with Business (as staff member)

**Methods**:
- `hasRole(string $role)`: Check if user has a specific role

**Usage Example**:
```php
// Create a customer
$user = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('password'),
]);

// Assign customer role
$customerRole = Role::where('name', 'customer')->first();
$user->roles()->attach($customerRole);

// Check if user is a business owner
if ($user->hasRole('business')) {
    // Show business dashboard
}
```

---

### 2. Business Model

**Location**: `app/Models/Business.php`

**Purpose**: Represents beauty salons, spas, barbershops, and other wellness businesses

**Fields**:
- `id`: Primary key
- `owner_id`: Foreign key to users table
- `name`: Business name
- `slug`: URL-friendly identifier
- `email`: Business contact email
- `address`: Street address
- `city`: City
- `postal_code`: Postal/ZIP code
- `country`: Country (default: UK)
- `phone`: Contact phone
- `description`: Business description
- `opening_hours`: JSON field for business hours
- `images`: JSON array of image URLs
- `latitude`, `longitude`: Geographic coordinates
- `website`: Business website URL
- `is_active`: Whether business is approved/active
- `created_at`, `updated_at`: Timestamps

**Relationships**:
- `owner()`: Belongs to User
- `plans()`: One-to-many with Plan
- `bookings()`: One-to-many with Booking
- `categories()`: Many-to-many with Category
- `staff()`: Many-to-many with User (via business_staff)

**Scopes**:
- `active()`: Filter only active businesses

**Accessors**:
- `primary_image`: Get the first image from images array

**Usage Example**:
```php
// Create a business
$business = Business::create([
    'owner_id' => $user->id,
    'name' => 'Elegant Hair Salon',
    'slug' => 'elegant-hair-salon-1',
    'email' => 'info@eleganthair.com',
    'address' => '123 Main Street',
    'city' => 'London',
    'phone' => '+44 20 1234 5678',
    'opening_hours' => [
        'monday' => ['open' => '09:00', 'close' => '18:00'],
        'tuesday' => ['open' => '09:00', 'close' => '18:00'],
        // ...
    ],
    'is_active' => false, // Pending approval
]);

// Attach categories
$hairSalonCategory = Category::where('slug', 'hair-salon')->first();
$business->categories()->attach($hairSalonCategory);

// Get active businesses
$activeBusinesses = Business::active()->get();
```

---

### 3. Plan Model

**Location**: `app/Models/Plan.php`

**Purpose**: Represents services/treatments offered by businesses

**Fields**:
- `id`: Primary key
- `business_id`: Foreign key to businesses table
- `category_id`: Foreign key to categories table
- `name`: Service name (e.g., "Women's Haircut")
- `slug`: URL-friendly identifier
- `description`: Service description
- `duration`: Duration in minutes
- `price`: Service price
- `currency`: Currency code (default: GBP)
- `is_active`: Whether service is available
- `max_bookings_per_day`: Booking limit (optional)
- `requires_deposit`: Whether deposit is required
- `deposit_amount`: Deposit amount if required
- `created_at`, `updated_at`: Timestamps

**Relationships**:
- `business()`: Belongs to Business
- `category()`: Belongs to Category
- `bookings()`: One-to-many with Booking

**Scopes**:
- `active()`: Filter only active plans

**Accessors**:
- `formatted_price`: Get price with currency symbol
- `formatted_duration`: Get human-readable duration (e.g., "1h 30min")

**Usage Example**:
```php
// Create a service/plan
$plan = Plan::create([
    'business_id' => $business->id,
    'category_id' => $category->id,
    'name' => 'Women\'s Haircut & Blow Dry',
    'slug' => 'womens-haircut-blow-dry',
    'description' => 'Professional haircut with styling',
    'duration' => 60, // minutes
    'price' => 45.00,
    'currency' => 'GBP',
    'is_active' => true,
]);

// Get formatted price
echo $plan->formatted_price; // "GBP 45.00"

// Get formatted duration
echo $plan->formatted_duration; // "1h"
```

---

### 4. Booking Model

**Location**: `app/Models/Booking.php`

**Purpose**: Represents customer appointments

**Fields**:
- `id`: Primary key
- `business_id`: Foreign key to businesses table
- `customer_id`: Foreign key to users table
- `plan_id`: Foreign key to plans table
- `staff_id`: Foreign key to users table (optional)
- `booking_date`: Date of appointment
- `booking_time`: Time of appointment
- `duration`: Duration in minutes
- `status`: Booking status (pending, confirmed, completed, cancelled, no_show)
- `price`: Total price
- `currency`: Currency code
- `deposit_paid`: Whether deposit has been paid
- `deposit_amount`: Deposit amount
- `total_paid`: Total amount paid
- `payment_method`: Payment method used
- `customer_name`: Customer name (cached)
- `customer_email`: Customer email (cached)
- `customer_phone`: Customer phone (cached)
- `notes`: Additional notes
- `cancellation_reason`: Reason for cancellation
- `cancelled_at`: Cancellation timestamp
- `created_at`, `updated_at`: Timestamps

**Relationships**:
- `business()`: Belongs to Business
- `customer()`: Belongs to User
- `plan()`: Belongs to Plan
- `staff()`: Belongs to User

**Scopes**:
- `pending()`: Filter pending bookings
- `confirmed()`: Filter confirmed bookings
- `completed()`: Filter completed bookings
- `cancelled()`: Filter cancelled bookings
- `forDate($date)`: Filter by specific date
- `today()`: Filter today's bookings
- `upcoming()`: Filter upcoming bookings

**Methods**:
- `canBeCancelled()`: Check if booking can be cancelled
- `cancel($reason)`: Cancel the booking
- `confirm()`: Confirm the booking
- `complete()`: Mark booking as completed

**Accessors**:
- `formatted_date_time`: Get formatted date and time
- `status_color`: Get color for status badge

**Usage Example**:
```php
// Create a booking
$booking = Booking::create([
    'business_id' => $business->id,
    'customer_id' => $customer->id,
    'plan_id' => $plan->id,
    'booking_date' => '2025-01-15',
    'booking_time' => '14:00:00',
    'duration' => 60,
    'status' => Booking::STATUS_PENDING,
    'price' => 45.00,
    'customer_name' => $customer->name,
    'customer_email' => $customer->email,
]);

// Confirm booking
$booking->confirm();

// Get today's bookings for a business
$todayBookings = Booking::where('business_id', $business->id)
    ->today()
    ->confirmed()
    ->get();

// Cancel booking
if ($booking->canBeCancelled()) {
    $booking->cancel('Customer requested cancellation');
}
```

---

### 5. Category Model

**Location**: `app/Models/Category.php`

**Purpose**: Categorizes businesses and services

**Fields**:
- `id`: Primary key
- `name`: Category name
- `slug`: URL-friendly identifier
- `description`: Category description
- `icon`: Icon/emoji for category
- `is_active`: Whether category is active
- `created_at`, `updated_at`: Timestamps

**Relationships**:
- `businesses()`: Many-to-many with Business
- `plans()`: One-to-many with Plan

**Usage Example**:
```php
// Get all businesses in a category
$category = Category::where('slug', 'hair-salon')->first();
$businesses = $category->businesses()->active()->get();

// Get all services in a category
$services = $category->plans()->active()->get();
```

---

### 6. Role Model

**Location**: `app/Models/Role.php`

**Purpose**: Defines user roles for access control

**Fields**:
- `id`: Primary key
- `name`: Role name (admin, business, customer, staff)
- `created_at`, `updated_at`: Timestamps

**Relationships**:
- `users()`: Many-to-many with User

**Usage Example**:
```php
// Get all users with a specific role
$businessOwners = Role::where('name', 'business')
    ->first()
    ->users()
    ->get();
```

---

## Database Relationships Diagram

```
User
├── roles (many-to-many) → Role
├── businesses (one-to-many as owner) → Business
├── bookings (one-to-many as customer) → Booking
├── staffBookings (one-to-many as staff) → Booking
└── employedAt (many-to-many as staff) → Business

Business
├── owner (belongs to) → User
├── plans (one-to-many) → Plan
├── bookings (one-to-many) → Booking
├── categories (many-to-many) → Category
└── staff (many-to-many) → User

Plan
├── business (belongs to) → Business
├── category (belongs to) → Category
└── bookings (one-to-many) → Booking

Booking
├── business (belongs to) → Business
├── customer (belongs to) → User
├── plan (belongs to) → Plan
└── staff (belongs to) → User

Category
├── businesses (many-to-many) → Business
└── plans (one-to-many) → Plan

Role
└── users (many-to-many) → User
```

## Common Queries

### Get all bookings for a business on a specific date
```php
$bookings = Booking::where('business_id', $businessId)
    ->forDate('2025-01-15')
    ->with(['customer', 'plan', 'staff'])
    ->orderBy('booking_time')
    ->get();
```

### Get upcoming bookings for a customer
```php
$upcomingBookings = Booking::where('customer_id', $userId)
    ->upcoming()
    ->with(['business', 'plan'])
    ->get();
```

### Get all active services for a business
```php
$services = Plan::where('business_id', $businessId)
    ->active()
    ->with('category')
    ->get();
```

### Get businesses in a specific category and city
```php
$businesses = Business::active()
    ->whereHas('categories', function($query) use ($categoryId) {
        $query->where('categories.id', $categoryId);
    })
    ->where('city', 'London')
    ->with(['categories', 'plans'])
    ->get();
```

