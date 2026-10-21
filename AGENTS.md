# AGENTS.md

Laravel 13 file-storage web app (`laravel/framework` ^13.17, PHP ^8.3, PHPUnit 12).
Stack: **Blade + Vite 8 + Tailwind 4** (`@tailwindcss/vite`) on the frontend; **JWT** (`php-open-source-saver/jwt-auth`) + **Laravel session** for dual auth; **Yajra DataTables** for server-side table rendering.

---

## Project Overview — Sistem Penyimpanan

A Google Drive–style cloud storage system with:

| Feature | Details |
|---|---|
| File upload / download / preview | `FileController` → `storage/app/local` disk |
| Folder hierarchy | Self-referential `folders` table (`parent_id`) |
| Star, Archive, Trash, Restore | Boolean flags on both `files` and `folders` rows |
| Sharing | `shares` table — per-item, per-email, viewer/editor role + link share |
| Search | `?search=` query param across names |
| Recent files | Last 20 files by `updated_at` |
| Settings page | User profile / storage info |

### Directory Map

```
app/
  Http/Controllers/
    Api/
      AuthController.php     # JWT login/register/logout/refresh + web session sync
      FileController.php     # upload, download, preview
      FolderController.php   # CRUD
      ItemController.php     # list, rename, star, move, share, archive, trash, restore, emptyTrash
      DataTablesController.php # Yajra server-side file table
    ArchiveController.php    # web view — archived items
    HomeController.php       # landing / dashboard
    RecentController.php     # recently modified files
    SharedController.php     # items shared with user
    StarredController.php    # starred items
    StorageController.php    # main file browser + folder drill-down
    TrashController.php      # trash bin view
    SettingsController.php   # settings page
  Models/
    FileItem.php   # table: files  — appends url, download_url, size_label, owner_label, modified_label
    Folder.php     # table: folders — appends url, meta_label, owner_label, modified_label
    Share.php      # table: shares
    User.php
resources/views/
  layouts/        # app shell (sidebar, topbar)
  pages/          # home, storage, list (DataTables), settings
  components/     # 25 Blade components (file-card, folder-card, file-row, modal, share-modal, upload-modal, sidebar, topbar, …)
  auth/           # login, register
  errors/         # 403, 404, 500
routes/
  web.php   # traditional Blade routes (auth, storage, shared, recent, starred, archive, trash, settings, errors)
  api.php   # /api prefix — auth, items, folders, files, datatables
database/migrations/
  2026_10_21_000001_create_storage_system_tables.php  # folders, files, shares
```

### Key Models

- **`FileItem`** (`files` table): `user_id`, `folder_id`, `name`, `path`, `mime_type`, `size`, `is_starred`, `is_archived`, `is_trashed`, `trashed_at`
- **`Folder`** (`folders` table): `user_id`, `parent_id`, `name`, `color`, `is_starred`, `is_archived`, `is_trashed`, `trashed_at`
- **`Share`** (`shares` table): `user_id`, `folder_id`, `file_id`, `shared_with_email`, `role` (viewer/editor), `link_share`

---

## Windows / Laragon Toolchain (do this first)

`php` and `composer` are **not on PATH** in a fresh shell. Prepend before running any command:

```powershell
$env:PATH = "C:\laragon\bin\php\php-8.3.33-Win32-vs16-x64;C:\laragon\bin\composer;$env:PATH"
```

`composer.bat` shells out to `php`, so Composer fails outright without the line above. `node`/`npm` are already on PATH. Shell is PowerShell.

---

## Commands

| Command | What it does |
|---|---|
| `composer setup` | Install deps, copy `.env`, `key:generate`, `migrate --force`, `npm install`, `npm run build` |
| `composer dev` | `php artisan dev` — runs `serve` + `queue:listen` + `npm run dev` (Vite) concurrently |
| `composer test` | `config:clear` then `php artisan test` |
| `php artisan test --filter=test_name` | Run a single test |
| `vendor\bin\pint --test` | Format check (no autofix) |
| `vendor\bin\pint` | Autofix formatting |

No JS lint/typecheck step exists — verify with Pint + `php artisan test`.

---

## Database

- Dev DB: `database/database.sqlite` (`DB_CONNECTION=sqlite` in `.env`)
- Session, queue, and cache all use `database` driver — their tables are in the default migrations.
- After `migrate:fresh`, run `migrate` again before expecting a web request to boot.

---

## Tests

- `phpunit.xml`: forces `DB_CONNECTION=sqlite` / `DB_DATABASE=:memory:`, array cache/session/mail, sync queue — fully hermetic.
- Only the two default example tests exist; both pass as-is.

---

## Auth Notes

- **Dual auth**: every login/register action issues both a web session cookie **and** a JWT token (`php-open-source-saver/jwt-auth`).
- The JWT token is passed to the frontend as a flash value (`jwt_token`) so the Blade-rendered JS can store it for API calls.
- API routes (`routes/api.php`) accept JWT; web routes (`routes/web.php`) use session middleware.
- `ItemController::getUser()` falls back through `auth('api') → auth('web') → User::first()` (dev convenience — harden before production).
