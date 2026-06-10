# TLab Developer Guide

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Local Setup](#2-local-setup)
3. [Testing](#3-testing)
4. [Feature Flags](#4-feature-flags)
5. [CI/CD Pipeline](#5-cicd-pipeline)
6. [Staging Environment](#6-staging-environment)
7. [Production Deployment](#7-production-deployment)
8. [Branch Strategy & PR Workflow](#8-branch-strategy--pr-workflow)
9. [Running Specific Flows Locally](#9-running-specific-flows-locally)
10. [Common Issues](#10-common-issues)

---

## 1. Project Overview

TLab is a Laravel 10 application with:
- **Frontend**: TailwindCSS, Alpine.js, Chart.js
- **Backend**: PHP 8.1+, Laravel 10
- **Database**: MySQL 8.0
- **Auth**: Local + Edfrica OAuth (SSO)
- **Payments**: Paystack
- **PDF**: DomPDF + QR codes

### Key Directories

```
app/
├── Http/Controllers/
│   ├── Admin/        # Admin panel (users, clubs, courses, payments, safety, schools)
│   ├── Parent/       # Parent portal (dashboard, children, courses, approvals)
│   ├── Child/        # Child portal (dashboard, learning, projects)
│   ├── Teacher/      # Teacher portal (dashboard, attendance, grading, comms)
│   └── Auth/         # Login, register, OAuth, password reset
├── Models/           # All Eloquent models
├── Services/         # EdfricaAuthService
└── helpers.php       # Global helper functions (feature(), etc.)

database/
├── migrations/       # All DB migrations
├── factories/        # Model factories for testing
└── seeders/          # Database seeders

resources/views/
├── layouts/          # app.blade.php, admin.blade.php, teacher.blade.php, parent.blade.php
├── admin/            # Admin views
├── parent/           # Parent portal views
├── child/            # Child portal views
├── teacher/          # Teacher portal views
├── auth/             # Authentication views
├── pages/            # Public pages
├── notifications/    # Notification center
├── communications/   # Teacher-parent communications
└── certificates/     # Certificate PDF + verification

tests/
└── Feature/          # Feature tests for all user roles

.github/
└── workflows/        # CI/CD pipelines

deploy/               # Deployment scripts
docs/                 # Developer documentation
```

---

## 2. Local Setup

### Prerequisites
- PHP 8.1+
- MySQL 8.0
- Composer
- Node.js (optional, for frontend asset watching)

### Steps

```bash
# 1. Clone the repo
git clone https://github.com/shuaib192/Tlab.git
cd Tlab

# 2. Install PHP dependencies
composer install

# 3. Create .env from example
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Edit .env with your local DB credentials
#    DB_DATABASE=tlab_db
#    DB_USERNAME=root
#    DB_PASSWORD=

# 6. Create database and run migrations
php artisan migrate

# 7. Seed the database
php artisan db:seed

# 8. Create storage link
php artisan storage:link

# 9. Start dev server
php artisan serve
```

### Running Tests Locally

```bash
# Create test database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS tlab_test"

# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=ParentFlowTest

# Run with coverage (requires Xdebug)
php artisan test --coverage
```

---

## 3. Testing

### Test Structure

All tests are in `tests/Feature/`:

| Test File | What It Tests | How to Run |
|---|---|---|
| `ParentFlowTest.php` | Register, dashboard, add child, switch, courses, subscription | `php artisan test --filter=ParentFlowTest` |
| `TeacherFlowTest.php` | Dashboard, course view, attendance, grading | `php artisan test --filter=TeacherFlowTest` |
| `ChildFlowTest.php` | PIN login, dashboard, course view | `php artisan test --filter=ChildFlowTest` |
| `AdminFlowTest.php` | Dashboard, clubs, users, courses, payments, safe links | `php artisan test --filter=AdminFlowTest` |
| `FeatureFlagTest.php` | Flag enabled/disabled, staging-only, user-based access | `php artisan test --filter=FeatureFlagTest` |

### Writing Tests

```php
<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyNewTest extends TestCase
{
    use RefreshDatabase;  // Resets DB between tests

    public function test_something_works()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $response = $this->actingAs($user)->get(route('parent.dashboard'));
        $response->assertStatus(200);
    }
}
```

### Factory Usage

```php
use App\Models\ChildProfile;

// Basic factory
$child = ChildProfile::factory()->create();

// With custom attributes
$child = ChildProfile::factory()->create([
    'xp' => 500,
    'rank' => 'Builder',
]);

// With relationships
$child = ChildProfile::factory()
    ->for(User::factory()->create(['role' => 'parent']))
    ->create();
```

Available factories:
- `UserFactory` — creates users with any role
- `ChildProfileFactory` — creates child profiles
- `CourseFactory` — creates courses (requires Club)
- `ClubFactory` — creates clubs
- `CohortFactory` — creates cohorts
- `ClassSessionFactory` — creates class sessions
- `EnrollmentFactory` — creates enrollments
- `AssignmentFactory` — creates assignments
- `AssignmentSubmissionFactory` — creates submissions
- `ModuleFactory` — creates modules
- `LessonFactory` — creates lessons

---

## 4. Feature Flags

### What Are Feature Flags?

Feature flags let you enable/disable features for specific users or environments without deploying new code. This enables **canary releases** — roll out features to a subset of users first.

### Pre-seeded Flags

| Key | Default | Description |
|---|---|---|
| `new_dashboard` | Active (all) | New dashboard UI |
| `ai_recommendations` | Inactive (staging-only) | AI learning recommendations |
| `bulk_invoicing` | Inactive (staging-only) | Bulk school invoicing |

### Managing Flags

**Via Admin UI** (recommended): `/admin/feature-flags`
- Toggle `Active` to enable/disable
- Check `Staging Only` to restrict to staging env (or whitelisted users)
- Add user IDs or role names in the whitelist fields

**Via code**:
```php
// Check if a feature is enabled
if (feature('new_dashboard')) {
    // show new dashboard
}

// Check for a specific user
if (feature('ai_recommendations', $user)) {
    // show AI recommendations
}
```

**Via middleware**:
```php
// Protect a route with a feature flag
Route::get('/ai-recommendations', [AiController::class, 'index'])
    ->middleware('feature:ai_recommendations');
```

### How Staging-Only Works

1. Flag marked `staging_only = true`
2. In production:
   - **Blocked** for everyone by default
   - **Allowed** for whitelisted users (`enabled_for_users`)
   - **Allowed** for whitelisted roles (`enabled_for_roles`)
3. In staging/dev: always allowed

---

## 5. CI/CD Pipeline

### Overview

Two GitHub Actions workflows:

| Workflow | Trigger | Jobs |
|---|---|---|
| `ci.yml` | Push to main/develop/feature/* or PR | lint → test → deploy-staging (develop) / deploy-production (main) |
| `pr-checks.yml` | PR to main/develop | route validation, debug statement check |

### Pipeline Flow

```
Push to feature/* branch
  ↓
CI runs: lint + test (both must pass)
  ↓
Create PR → feature/* → develop
  ↓
PR Checks run: route validation, no debug statements
  ↓
Merge to develop
  ↓
Auto-deploy to Staging (https://staging.tlab.edfrica.org)
  ↓
QA testing on staging
  ↓
PR → develop → main
  ↓
PR Checks run again
  ↓
Merge to main
  ↓
Auto-deploy to Production (https://tlab.edfrica.org)
```

### Running Lint Locally

```bash
# Laravel Pint is used for code style
vendor/bin/pint --test    # Check style (dry run)
vendor/bin/pint           # Auto-fix style issues
```

### Required GitHub Secrets

For deploy jobs to work, add these secrets in GitHub → Settings → Secrets and variables → Actions:

| Secret | Description | Example |
|---|---|---|
| `SSH_PRIVATE_KEY` | SSH private key for deployment | (contents of `~/.ssh/namecheap_migration_key`) |
| `DEPLOY_HOST` | Server hostname | `199.188.201.180` |
| `DEPLOY_PORT` | SSH port | `21098` |
| `DEPLOY_USER` | SSH username | `dadeggbt` |
| `STAGING_PATH` | Staging directory on server | `~/staging.tlab.edfrica.org` |
| `PROD_PATH` | Production directory on server | `~/tlab.edfrica.org` |

---

## 6. Staging Environment

### What Is It?

A separate copy of TLab at `staging.tlab.edfrica.org` where new features are tested before going to production.

### Setting It Up (One Time)

Run the setup script on the server:

```bash
# SSH into server
ssh -p 21098 -i ~/.ssh/namecheap_migration_key dadeggbt@199.188.201.180

# Run the staging setup
bash ~/tlab.edfrica.org/deploy/staging-setup.sh
```

This script:
1. Creates `~/staging.tlab.edfrica.org/`
2. Copies production files as base
3. Updates `.env` for staging (APP_URL, APP_ENV)
4. Generates unique APP_KEY

### Auto-Deploy

Every push to `develop` branch triggers auto-deploy to staging via GitHub Actions (once secrets are configured).

### Manual Deploy

```bash
# From your local machine, rsync to staging
rsync -avz --delete --exclude='.env' --exclude='.git' --exclude='storage' \
  -e "ssh -p 21098 -i ~/.ssh/namecheap_migration_key" \
  ./ dadeggbt@199.188.201.180:~/staging.tlab.edfrica.org/

# Run migrations and clear cache
ssh -p 21098 -i ~/.ssh/namecheap_migration_key dadeggbt@199.188.201.180 \
  "cd ~/staging.tlab.edfrica.org && php artisan migrate --force && php artisan optimize:clear && touch public/index.php"
```

---

## 7. Production Deployment

### Auto-Deploy

Every merge/push to `main` branch triggers auto-deploy to production via GitHub Actions.

### Manual Deploy

```bash
rsync -avz --delete --exclude='.env' --exclude='.git' --exclude='storage' \
  -e "ssh -p 21098 -i ~/.ssh/namecheap_migration_key" \
  ./ dadeggbt@199.188.201.180:~/tlab.edfrica.org/

# Run migrations + clear cache + OPcache reset
ssh -p 21098 -i ~/.ssh/namecheap_migration_key dadeggbt@199.188.201.180 \
  "cd ~/tlab.edfrica.org && php artisan migrate --force && php artisan optimize:clear && touch public/index.php"
```

### Post-Deploy Checklist

- [ ] Visit `https://tlab.edfrica.org` — loads without errors
- [ ] Run `php artisan migrate:status` on server — no pending migrations
- [ ] Test login at `/login`
- [ ] Test child PIN login at `/child/login`
- [ ] Verify `/pricing` loads subscription plans
- [ ] Check `/admin/dashboard` loads with stats

---

## 8. Branch Strategy & PR Workflow

### Branch Hierarchy

```
main (production)
  └── develop (staging)
       └── feature/* (new features)
       └── hotfix/* (emergency fixes)
```

### Workflow

1. **Start a new feature**:
   ```bash
   git checkout develop
   git pull origin develop
   git checkout -b feature/my-new-feature
   ```

2. **Make changes, commit, push**:
   ```bash
   git add .
   git commit -m "feat: add my new feature"
   git push origin feature/my-new-feature
   ```

3. **Create PR** → `feature/my-new-feature` → `develop` on GitHub

4. **PR checks run automatically**:
   - Route validation
   - Debug statement detection (`dd()`, `dump()`, `ray()`)
   - Style check (Pint)

5. **Get review**, fix any issues, merge

6. **Auto-deploy to staging** on merge to `develop`

7. **QA on staging**, then create PR → `develop` → `main`

8. **Auto-deploy to production** on merge to `main`

### Commit Message Convention

```
type: description

Types: feat, fix, chore, docs, test, refactor, style, ci
```

Examples:
- `feat: add teacher assignment creation form`
- `fix: resolve notification sidebar layout`
- `test: add parent flow feature tests`
- `ci: update GitHub Actions to Node 24`

---

## 9. Running Specific Flows Locally

### Test Parent Flow
1. Register: `POST /signup`
2. Login: `POST /login`
3. Visit dashboard: `GET /parent/dashboard`
4. Add child: `GET /parent/children/add`
5. Switch to child: `GET /parent/switch/{child}`
6. Browse courses: `GET /parent/courses`
7. View subscription: `GET /parent/subscription`

### Test Teacher Flow
1. Login as teacher role user
2. Dashboard: `GET /teacher/dashboard`
3. View course: `GET /teacher/courses/{course}`
4. Manage cohort: `GET /teacher/cohorts/{cohort}`
5. Mark attendance: `POST /teacher/sessions/{session}/attendance`
6. Grade assignments: `GET /teacher/assignments/{assignment}/grade`
7. Create assignment: `GET /teacher/courses/{course}/assignments/create`
8. Send communication: `POST /teacher/communications/send`

### Test Child Flow
1. Visit child login: `GET /child/login`
2. Login with username + PIN
3. Dashboard: `GET /child/dashboard`
4. View course: `GET /child/course/{enrollment}`
5. View lesson: `GET /child/lesson/{lesson}`
6. Take assessment: `GET /child/assessment/{assessment}`
7. Submit project: `GET /child/{enrollment}/project/{assignment}`

### Test Admin Flow
1. Login as super_admin
2. Dashboard: `GET /admin`
3. Manage clubs: `GET /admin/clubs`
4. Manage courses: `GET /admin/courses`
5. Manage users: `GET /admin/users`
6. View children: `GET /admin/children`
7. View payments: `GET /admin/payments`
8. Manage safe links: `GET /admin/safety/safe-links`
9. Moderate uploads: `GET /admin/safety/uploads`
10. View communications: `GET /admin/safety/communications`
11. Compliance log: `GET /admin/compliance`
12. Invoices: `GET /admin/invoices`
13. Schools: `GET /admin/schools`
14. Feature flags: `GET /admin/feature-flags`

---

## 10. Common Issues

### Migration says "Nothing to migrate" but file exists
```bash
# Check migration status
php artisan migrate:status

# If the migration is not listed, try full path
php artisan migrate --path=database/migrations/2026_06_11_000002_create_feature_flags_table.php --force
```

### OPcache — changes not showing
```bash
touch public/index.php
```

### "Class not found" for new models
```bash
composer dump-autoload
```

### Storage links broken
```bash
php artisan storage:link
```

### Permission errors on server
```bash
chmod -R 775 storage bootstrap/cache
```

### Paystack payments not working
Check `.env` has these set:
```
PAYSTACK_PUBLIC_KEY=your_public_key
PAYSTACK_SECRET_KEY=your_secret_key
PAYSTACK_MERCHANT_EMAIL=merchant@example.com
```

### Config cache broken on server
The server has issues with `php artisan config:cache`. **Skip it.** Instead:
```bash
php artisan optimize:clear
touch public/index.php
```
