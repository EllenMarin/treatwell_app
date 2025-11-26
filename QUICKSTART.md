# Quick Start Guide

This guide will help you get the Treatwell Clone application up and running in minutes.

## Prerequisites

- Docker Desktop installed and running
- Git (optional, if cloning from repository)

## Setup Steps

### 1. Environment Configuration

Copy the example environment file:
```bash
cp .env.example .env
```

The default configuration is already set up for Docker. No changes needed unless you want to customize.

### 2. Start Docker Services

Build and start all containers:
```bash
docker-compose up -d --build
```

This will start:
- PHP application (port 9000)
- Nginx web server (port 8000)
- MySQL database (port 3306)
- Redis cache (port 6379)
- Mailhog email testing (ports 1025, 8025)
- Queue worker
- Task scheduler

### 3. Install Dependencies

Install PHP dependencies via Composer:
```bash
docker-compose exec app composer install
```

### 4. Generate Application Key

```bash
docker-compose exec app php artisan key:generate
```

### 5. Run Database Migrations

Create all database tables:
```bash
docker-compose exec app php artisan migrate
```

### 6. Seed Initial Data

Populate the database with roles and categories:
```bash
docker-compose exec app php artisan db:seed
```

This will create:
- **Roles**: admin, business, customer, staff
- **Categories**: Hair Salon, Barbershop, Nail Salon, Spa & Massage, Beauty Salon, Eyebrows & Lashes, Tattoo & Piercing, Wellness

### 7. Access the Application

Open your browser and navigate to:
- **Application**: http://localhost:8000
- **Mailhog (Email Testing)**: http://localhost:8025

## Creating Your First Business

### 1. Register as Business Owner

1. Go to http://localhost:8000/register/business
2. Fill in the registration form:
   - Contact name
   - Email
   - Business name
   - Password
3. Click "Register business"

### 2. Wait for Admin Approval

By default, new businesses require admin approval. The business will be in "pending" status.

### 3. Create an Admin User (for testing)

To approve businesses, you need an admin user. Create one via Tinker:

```bash
docker-compose exec app php artisan tinker
```

Then run:
```php
$admin = App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@treatwell.local',
    'password' => Hash::make('password'),
]);

$adminRole = App\Models\Role::where('name', 'admin')->first();
$admin->roles()->attach($adminRole);
```

Exit Tinker with `exit` or `Ctrl+D`.

### 4. Login as Admin and Approve Business

1. Login at http://localhost:8000/login with:
   - Email: admin@treatwell.local
   - Password: password
2. Go to http://localhost:8000/admin
3. Click "Approve" on the pending business

### 5. Add Services/Plans

As a business owner:
1. Login to your business account
2. Navigate to the business dashboard
3. Add services/plans (this feature needs to be implemented in the UI)

For now, you can add plans via Tinker:

```bash
docker-compose exec app php artisan tinker
```

```php
$business = App\Models\Business::first();
$category = App\Models\Category::where('slug', 'hair-salon')->first();

App\Models\Plan::create([
    'business_id' => $business->id,
    'category_id' => $category->id,
    'name' => 'Women\'s Haircut',
    'slug' => 'womens-haircut',
    'description' => 'Professional haircut and styling',
    'duration' => 60,
    'price' => 45.00,
    'currency' => 'GBP',
    'is_active' => true,
]);
```

## Testing Email Functionality

All emails sent by the application are caught by Mailhog:

1. Trigger an email action in the app
2. Open http://localhost:8025
3. View the email in the Mailhog interface

## Useful Commands

### View Logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f app
docker-compose logs -f nginx
```

### Access Containers
```bash
# PHP application
docker-compose exec app bash

# MySQL database
docker-compose exec db mysql -u treatwell -p
# Password: secret
```

### Laravel Artisan Commands
```bash
# Clear all caches
docker-compose exec app php artisan optimize:clear

# Create a new controller
docker-compose exec app php artisan make:controller BookingController

# Create a new migration
docker-compose exec app php artisan make:migration add_field_to_table

# Run tests (when implemented)
docker-compose exec app php artisan test
```

### Stop Services
```bash
# Stop all containers
docker-compose down

# Stop and remove volumes (WARNING: deletes database data)
docker-compose down -v
```

## Next Steps

Now that your application is running, you can:

1. **Implement Booking UI**: Create forms for customers to book appointments
2. **Add Business Dashboard**: Allow businesses to manage their services and bookings
3. **Implement Search**: Add search functionality for businesses and services
4. **Add Reviews**: Implement a review system for businesses
5. **Payment Integration**: Integrate Stripe or PayPal for payments
6. **Notifications**: Add email/SMS notifications for bookings
7. **Calendar View**: Create a calendar interface for managing bookings
8. **API Development**: Build RESTful API endpoints for mobile apps

## Troubleshooting

### Port Already in Use

If you get a port conflict error:

1. Check what's using the port:
   ```bash
   lsof -i :8000  # or :3306, :6379, etc.
   ```

2. Either stop that service or change the port in `docker-compose.yml`

### Permission Issues

If you encounter permission errors:

```bash
# Fix storage permissions
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R treatwell:treatwell storage bootstrap/cache
```

### Database Connection Issues

1. Make sure the database container is running:
   ```bash
   docker-compose ps
   ```

2. Check database logs:
   ```bash
   docker-compose logs db
   ```

3. Verify `.env` settings:
   ```
   DB_HOST=db
   DB_DATABASE=treatwell
   DB_USERNAME=treatwell
   DB_PASSWORD=secret
   ```

### Clear Everything and Start Fresh

```bash
# Stop containers
docker-compose down

# Remove volumes (deletes all data)
docker-compose down -v

# Rebuild and start
docker-compose up -d --build

# Re-run migrations and seeds
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

## Support

For more detailed information, see:
- `README.md` - Full documentation
- `MODELS_DOCUMENTATION.md` - Database models and relationships
- Laravel Documentation: https://laravel.com/docs

Happy coding! 🚀

