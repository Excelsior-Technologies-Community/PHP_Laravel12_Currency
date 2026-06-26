# PHP_Laravel12_Currency

## Introduction

PHP_Laravel12_Currency is a modern Laravel 12 Currency Converter project that demonstrates converting amounts between USD, INR, and EUR.

This project uses the Torann Currency package to handle currency storage, conversion logic, and formatting. You can either use database-based static rates or live exchange rates from OpenExchangeRates API.

---

## Project Overview

Key Features:

- Convert amounts between USD, INR, EUR.

- Supports database or live API exchange rates.

- Premium responsive design with Tailwind CSS and glassmorphism effects.

- Fully functional Laravel 12 controller, routes, and Blade templates.

- Seeder included with up-to-date currency rates (2026).

- Easy to extend for more currencies or API integrations.

- Clean, professional project structure suitable for portfolio submission.

--- 

## Tech Stack:

- Backend: Laravel 12

- Package: Torann Currency ^1.1

- Frontend: Tailwind CSS (premium modern design)

- Database: MySQL (or any supported Laravel DB)

---

## Installation

Run the following commands to create the project and install dependencies:

## Step 1: Create Laravel 12 project

```bash
composer create-project laravel/laravel PHP_Laravel12_Currency "12.*"
cd PHP_Laravel12_Currency
```

---

## Step 2: Install Torann Currency Package

```bash
composer require torann/currency
```

Publish config and migrations:

```bash
php artisan vendor:publish --provider="Torann\Currency\CurrencyServiceProvider"
```

Run migrations:

```bash
php artisan migrate
```

This creates the currencies table in your database.

---

## Step 3: Configure .env

Update .env

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_currency
DB_USERNAME=root
DB_PASSWORD=
```
Then Run Migration Command:

```bash
php artisan migrate
```

---

## Step 4: Configure Currency Package

Open config/currency.php and set:

'default' => 'INR',         // Default currency
'driver' => 'database',     // Storage driver

Optional: Later, you can add API key if using live exchange rates.

---

## Step 5: Create Currency Seeder

Create seeder:

```bash
php artisan make:seeder CurrencySeeder
```

Edit database/seeders/CurrencySeeder.php:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'format' => '$1.00',
                'exchange_rate' => 1, // Base
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Indian Rupee',
                'code' => 'INR',
                'symbol' => '₹',
                'format' => '₹1',
                'exchange_rate' => 91, // Approx. current INR per USD
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'format' => '€1',
                'exchange_rate' => 0.848, // Approx. current EUR per USD
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
```
Run seeder:

```bash
php artisan db:seed --class=CurrencySeeder
```

---

## Step 6: Create Controller

```bash
php artisan make:controller CurrencyController
```

Edit app/Http/Controllers/CurrencyController.php:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        return view('currency.index');
    }

    public function convert(Request $request)
    {
        $amount = $request->amount;
        $from = $request->from;
        $to = $request->to;

        $converted = Currency::convert($amount, $from, $to);

        return view('currency.index', compact('converted', 'amount', 'from', 'to'));
    }
}
```

---

## Step 7: Define Routes

Edit routes/web.php:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurrencyController;

Route::get('/', [CurrencyController::class, 'index']);
Route::post('/convert', [CurrencyController::class, 'convert']);
```

---

## Step 8: Create Blade View

Create resources/views/currency/index.blade.php

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Converter | Laravel 12</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-50 via-white to-purple-50 font-sans">

<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <!-- Glassmorphism Card -->
    <div class="bg-white/80 backdrop-blur-md shadow-2xl rounded-3xl w-full max-w-md p-10">
        <h1 class="text-4xl font-extrabold text-gray-800 text-center mb-4 drop-shadow-md">
            Currency Converter
        </h1>
        <p class="text-center text-gray-500 mb-8">
            Convert between USD, INR, EUR with current exchange rates
        </p>

        <form method="POST" action="/convert" class="space-y-6">
            @csrf

            <!-- Amount Input -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Amount</label>
                <input type="number" name="amount" value="{{ $amount ?? '' }}" required
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-md">
            </div>

            <!-- From & To Dropdown -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">From</label>
                    <select name="from" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-md">
                        <option value="USD" {{ ($from ?? '') == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="INR" {{ ($from ?? '') == 'INR' ? 'selected' : '' }}>INR</option>
                        <option value="EUR" {{ ($from ?? '') == 'EUR' ? 'selected' : '' }}>EUR</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">To</label>
                    <select name="to" 
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 shadow-sm hover:shadow-md">
                        <option value="USD" {{ ($to ?? '') == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="INR" {{ ($to ?? '') == 'INR' ? 'selected' : '' }}>INR</option>
                        <option value="EUR" {{ ($to ?? '') == 'EUR' ? 'selected' : '' }}>EUR</option>
                    </select>
                </div>
            </div>

            <!-- Convert Button -->
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                Convert
            </button>
        </form>

        <!-- Result Card -->
        @if(isset($converted))
            <div class="mt-6 p-6 bg-green-50 border-l-4 border-green-400 rounded-xl text-center shadow-inner">
                <h2 class="text-xl font-semibold text-green-700">Converted Amount</h2>
                <p class="text-3xl font-bold text-green-900 mt-2">{{ $converted }}</p>
            </div>
        @endif
    </div>
</div>

</body>
</html>
```

---

## Step 9: Run Laravel Server

```bash
php artisan serve
```
Open browser:

```bash
http://127.0.0.1:8000
```

Test the converter by entering Amount, selecting From → To currencies, and clicking Convert.

---

## Output

<img width="1919" height="1029" alt="Screenshot 2026-03-13 164236" src="https://github.com/user-attachments/assets/20ca1492-5ada-4b39-8d9e-861853a53246" />

---

## Project Structure

```
PHP_Laravel12_Currency/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── CurrencyController.php       # Main controller for conversion
│   │   ├── Middleware/
│   │  
│   ├── Models/
│   └── Providers/
├── bootstrap/
│   └── app.php
├── config/
│   ├── app.php
│   ├── database.php
│   ├── currency.php                          # Torann Currency config
│   └── ...
├── database/
│   ├── factories/
│   ├── migrations/
│   │   └── 2013_11_26_161501_create_currency_table.php
│   └── seeders/
│       └── CurrencySeeder.php               # Seeder with latest currency rates
├── public/
│   ├── index.php
│   └── ...
├── resources/
│   ├── views/
│   │   └── currency/
│   │       └── index.blade.php             # Premium Tailwind UI Blade view
│   └── ...
├── routes/
│   └── web.php                              # Routes for index & convert
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/
├── vendor/
│   └── torann/currency/                     # Torann package
├── .env
├── artisan
├── composer.json
├── composer.lock
└── package.json
```

--- 

Your PHP_Laravel12_Currency Project is now ready!
