# CampusFix

CampusFix is a Laravel facility concern reporting system for students and university administrators. Students can submit a concern with a location, description, category, and optional photo; administrators can search the report queue and update report statuses.

## Run locally

The project is set up to use its included SQLite database, so the app can run with one command from this folder:

```powershell
php artisan serve
```

Open <http://127.0.0.1:8000>. Tailwind CSS is prebuilt in `public/css/campusfix.css`, so no Node, npm, internet connection, or Vite build is needed to run the app.

### Demo administrator

- Email: `admin@campusfix.test`
- Password: `CampusFix123!`

Student accounts can be registered from the sign-in page. The demo administrator password and email can be changed in `.env` before seeding a new database.

## Laragon MySQL database

The `campusfix` MySQL database has also been created in the local Laragon MySQL 8.4 data directory. Its repeatable schema/import file is `database/campusfix-laragon.sql`. To use it, start Laragon's MySQL service and set the database values from `.env.laragon.example` in `.env`, keeping the same `APP_KEY` from your local `.env`. The app can still be started with `php artisan serve` once the Laragon MySQL service is running.

If you create a fresh MySQL schema instead of using the prepared one, set `DB_CONNECTION=mysql` and `DB_DATABASE=campusfix` in `.env`, then run `php artisan migrate --seed` once.

## Scope

- Student account registration and sign-in
- Facility concern reports with category, campus location, description, and optional JPG, PNG, or WebP photo
- Student report list, reference number, status tracking, and administrator notes
- Administrator report search and status updates: Pending, In Progress, or Resolved
- No GPS tracking, staff dispatch, repair scheduling, or real-time notifications
