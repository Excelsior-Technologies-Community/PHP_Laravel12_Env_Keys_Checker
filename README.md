# PHP_Laravel12_Env_Keys_Checker

## Project Description

PHP_Laravel12_Env_Keys_Checker is a Laravel 12 web application that uses the **`msamgan/laravel-env-keys-checker`** package to automatically check whether all the keys defined in `.env.example` are present across all `.env` files in the project.

This is extremely useful in team projects where different developers may have different `.env` files and some keys can go missing — leading to runtime errors. This tool runs a simple **Artisan command** that lists all missing keys clearly in the terminal.

The main goal is to demonstrate how to integrate and use the `laravel-env-keys-checker` package in a Laravel 12 project to keep all environment configuration files in sync.

---

## Features

1. **Env Key Checker** – Automatically detects missing keys across all `.env` files compared to `.env.example`.
2. **Artisan Command** – Run a single command to check all env keys: `php artisan env:keys-check`.
3. **SQLite Support** – Uses SQLite as the default database — no MySQL setup needed.
4. **Custom Key Support** – Supports custom keys like `TEST_SECRET_KEY` in `.env`.
5. **Team Friendly** – Ensures all team members have all required keys in their local `.env` files.
6. **Zero Config** – Works out of the box after package install and migrate.

---

## Technologies Used

1. **PHP 8.2+** – Minimum required version for this package.
2. **Laravel 12** – Backend framework for routing, commands, and configuration.
3. **SQLite** – Lightweight default database — no extra DB server needed.
4. **msamgan/laravel-env-keys-checker** – The core package that checks env keys.
5. **Composer** – PHP dependency manager used to install the package.

---

---

## Installation Steps

---

## STEP 1: Create Laravel 12 Project

### Open terminal / CMD and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_Env_Keys_Checker "12.*"
```

### Go inside project:

```bash
cd PHP_Laravel12_Env_Keys_Checker
```

#### Explanation:
Installs a fresh Laravel 12 project named `PHP_Laravel12_Env_Keys_Checker`.
Moves into the project directory to start configuration and package setup.

---

## STEP 2: Install the Env Keys Checker Package

### Run:

```bash
composer require msamgan/laravel-env-keys-checker
```

#### Explanation:
Installs the `msamgan/laravel-env-keys-checker` package from Packagist into the Laravel project.
This package adds an Artisan command `php artisan env:keys-check` that compares all `.env` files with `.env.example` and reports any missing keys.
No extra config publish step is required — the package works immediately after install.

---

## STEP 3: Database Setup

This project uses **SQLite** by default — no MySQL or phpMyAdmin needed.

### Update `.env` file:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:qZM3xgv4t2n4nK2fC9XbbB5jHoYlKA53WUqtHY4S+dE=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

TEST_SECRET_KEY=
```

> **Important:** `DB_CONNECTION=sqlite` means Laravel will automatically create a `database/database.sqlite` file.
> Never push your real `APP_KEY` or secret values to GitHub. Keep `.env` in `.gitignore`.
> Use `TEST_SECRET_KEY=` with no quotes — using `TEST_SECRET_KEY=""` can cause an unexpected equals error.

### Run migrations:

```bash
php artisan migrate
```

#### Explanation:
Creates the SQLite database file and runs all default Laravel migrations.
No MySQL server setup required — SQLite works out of the box.

---

## STEP 4: Setup `.env.example`

The `.env.example` file is the **master reference** — the package compares all `.env` files against this file.

### Update `.env.example` to match all required keys:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

PHP_CLI_SERVER_WORKERS=4

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

TEST_SECRET_KEY=
```

#### Explanation:
`.env.example` should contain all keys but with **empty or placeholder values** — never real secrets.
This file IS pushed to GitHub. It serves as a template for other developers to create their own `.env`.
The `TEST_SECRET_KEY=` key is included so the checker knows it is a required key.

---

## STEP 5: Run the Env Keys Checker

### Run the Artisan command:

```bash
php artisan env:keys-check
```

#### Expected Output (All keys present — All OK):

```
Checking keys... 45 / 45 [============================] 100%

All keys are present in all .env files.
```

#### Expected Output (Missing key found):

```
┌──────┬─────────────────┬───────────────┐
│ Line │ Key             │ Is missing in │
├──────┼─────────────────┼───────────────┤
│ 68   │ TEST_SECRET_KEY │ .env.example  │
└──────┴─────────────────┴───────────────┘
```

#### Explanation:
The command compares every key in `.env.example` against all `.env` files in the project.
If a key is missing in any `.env` file, it will be shown in a clear table with line number and filename.
This helps prevent runtime errors caused by missing environment configuration.

---

## STEP 6: Auto-Add Missing Keys (Optional)

If you want the package to **automatically add missing keys** to the `.env` file, run:

```bash
php artisan env:keys-check --auto-add=auto
```

#### Explanation:
The `--auto-add=auto` flag tells the package to inject any missing keys directly into the target `.env` file with an empty value.
This saves time in team environments where new keys are added frequently.

---

## STEP 7: Run the App

### Start development server:

```bash
php artisan serve
```

### Open in browser:

```
http://127.0.0.1:8000
```

#### Explanation:
Starts the Laravel development server locally.
The main purpose of this project is the `env:keys-check` Artisan command — the web interface shows the default Laravel welcome page.

---

## Expected Output

### Terminal — All Keys Present:

```
✔ All keys are present in all .env files.
```

### Terminal — Missing Key Detected:

```
┌──────┬─────────────────┬───────────────┐
│ Line │ Key             │ Is missing in │
├──────┼─────────────────┼───────────────┤
│ 68   │ TEST_SECRET_KEY │ .env.example  │
└──────┴─────────────────┴───────────────┘
```

### Browser:

- Default Laravel 12 welcome page at `http://127.0.0.1:8000`

---

## How It Works

```
.env.example  ──► used as the master key reference
      │
      ▼
php artisan env:keys-check
      │
      ├──► reads all .env files in the project
      │
      ├──► compares every key with .env.example
      │
      └──► reports any missing keys in a clear table in terminal
```

---

## Project Folder Structure

```
PHP_Laravel12_Env_Keys_Checker/
├── database/
│   └── database.sqlite             # Auto-created SQLite database file
├── .env                            # Your local environment file (not pushed to GitHub)
├── .env.example                    # Master reference file (pushed to GitHub)
├── .gitignore                      # Ensures .env is never pushed
├── artisan
├── composer.json                   # Contains msamgan/laravel-env-keys-checker dependency
└── composer.lock
```
<<<<<<< HEAD
<img width="778" height="338" alt="Screenshot 2026-05-18 182623" src="https://github.com/user-attachments/assets/a1360c96-b4ea-451f-b913-6daf8c3fc859" />
=======
<img width="778" height="338" alt="Screenshot 2026-05-18 182623" src="https://github.com/user-attachments/assets/b65f47fe-d82f-4156-aa5f-c02e1a521ee0" />
>>>>>>> development
---
