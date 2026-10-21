# Sistem Penyimpanan — Project Guidelines

## What This App Is

**Sistem Penyimpanan** is a Laravel 13 Google Drive–style file storage system. Users can upload files, organise them into nested folders, star, archive, or trash items, and share them with others by email or link.

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 13 (PHP ^8.3) |
| Frontend | Blade templates, Vite 8, Tailwind CSS 4 (`@tailwindcss/vite`) |
| Auth | Dual: Laravel session (web) + JWT (`php-open-source-saver/jwt-auth`) |
| Tables | Yajra DataTables (`yajra/laravel-datatables-oracle`) |
| Database | SQLite (dev) — `database/database.sqlite` |
| Testing | PHPUnit 12 (not Pest) |
| Linting | Laravel Pint (default `laravel` preset) |

## Key Routes

### Web (`routes/web.php`)
- `/` — home dashboard
- `/login`, `/register` — auth pages
- `/storage`, `/storage/{folder}` — file browser
- `/shared`, `/recent`, `/starred`, `/archive`, `/trash` — filtered views
- `/settings` — user settings
- `/errors/403|404|500` — error pages (also directly browseable for QA)

### API (`routes/api.php`, prefix `/api`)
- `POST /api/auth/login|register|logout` / `GET /api/auth/me` / `POST /api/auth/refresh`
- `GET /api/items` — list files & folders (supports `?folder=`, `?search=`, `?starred=`, `?archived=`, `?trash=`, `?recent=`)
- `PATCH /api/items/{id}` — rename; `PATCH /api/items/{id}/star` — star/unstar
- `POST /api/items/move|archive|restore|trash/empty`; `DELETE /api/items` — soft-trash or hard-delete
- `POST /api/items/{id}/shares` — share with email(s)
- CRUD `POST|GET|PATCH|DELETE /api/folders/{folder}`
- `POST /api/files` — upload; `GET /api/files/{file}/download|preview`
- `GET /api/datatables/files` — server-side DataTables endpoint

## Database Schema (custom tables)

```
folders: id, user_id, parent_id (nullable self-ref), name, color, is_starred, is_archived, is_trashed, trashed_at
files:   id, user_id, folder_id (nullable), name, path, mime_type, size, is_starred, is_archived, is_trashed, trashed_at
shares:  id, user_id, folder_id (nullable), file_id (nullable), shared_with_email, role (viewer|editor), link_share
```

## Windows Setup (Laragon)

```powershell
# Run this first in every new shell before any php/composer command
$env:PATH = "C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64;C:\laragon\bin\composer;$env:PATH"
```

## Common Commands

```powershell
composer setup          # first-time bootstrap
composer dev            # dev server (artisan serve + Vite + queue)
composer test           # run test suite
vendor\bin\pint         # autofix code style
vendor\bin\pint --test  # check style only (no writes)
```

## Conventions

- **Soft-delete pattern**: items use `is_trashed` / `trashed_at` boolean flags, **not** Laravel's `SoftDeletes` trait. A second delete call on an already-trashed item hard-deletes it (and removes the file from disk for `FileItem`).
- **Model appends**: `FileItem` and `Folder` both expose computed attributes (`url`, `owner_label`, `modified_label`, `size_label` / `meta_label`) via `$appends` — these are serialised automatically in JSON responses.
- **Auth fallback** in `ItemController::getUser()`: `auth('api') → auth('web') → User::first()`. This is a dev convenience; remove/harden for production.
- **No middleware on API routes yet** — add `auth:api` middleware before going live.
- Pint is the only linter; no TypeScript, no JS linting, no typecheck step.
