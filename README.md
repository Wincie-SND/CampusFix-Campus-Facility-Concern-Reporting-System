# CampusFix

CampusFix is a Laravel facility concern reporting system for students, guests, faculty, and university staff. Students and guests can submit and track their own reports; faculty can do that and review all reports; staff can review and update all reports.

## Run locally

The project is set up to use its included SQLite database, so the app can run with one command from this folder:

```powershell
php artisan serve
```

Open <http://127.0.0.1:8000>. Tailwind CSS is prebuilt in `public/css/campusfix.css`, so no Node, npm, internet connection, or Vite build is needed to run the app.

### Demo staff administrator

- Email: `admin@campusfix.test`
- Password: `CampusFix123!`

This account has the `staff` type and can review and update all reports.

- Staff test account: `staff@campusfix.test` / `StaffFix123!`

### Demo reporting accounts

Students and guests can submit and track their own reports:

- `student1@campusfix.test` / `StudentFix123!`
- `student2@campusfix.test` / `StudentFix123!`
- `student3@campusfix.test` / `StudentFix123!`
- `guest@campusfix.test` / `GuestFix123!`

### Demo faculty account

- Email: `faculty@campusfix.test`
- Password: `FacultyFix123!`

Faculty can submit and track their own reports, and also review and update all reports.

Run `php artisan migrate --seed` to apply role updates and create the demo accounts. They are also included in the Laragon SQL import. Public registration is available for students and guests; faculty and staff accounts are provisioned by the university because they have report review privileges. The demo staff administrator password and email can be changed in `.env` before seeding a new database.

## Laragon MySQL database

The `campusfix` MySQL database has also been created in the local Laragon MySQL 8.4 data directory. Its repeatable schema/import file is `database/campusfix-laragon.sql`. To use it, start Laragon's MySQL service and set the database values from `.env.laragon.example` in `.env`, keeping the same `APP_KEY` from your local `.env`. The app can still be started with `php artisan serve` once the Laragon MySQL service is running.

If you create a fresh MySQL schema instead of using the prepared one, set `DB_CONNECTION=mysql` and `DB_DATABASE=campusfix` in `.env`, then run `php artisan migrate --seed` once.

## Scope

- Student, guest, faculty, and staff account roles
- Student and guest registration and sign-in
- Facility concern reports with a title, category, building, location, description, and optional JPG, PNG, or WebP photo
- Reporter report list, reference number, status tracking, and reviewer notes
- Staff and faculty report search and status updates: Pending, In Progress, or Resolved
- No GPS tracking, staff dispatch, repair scheduling, or real-time notifications
