# P118 IATSE Local 118 — Comprehensive Codebase Review

**Date:** March 13, 2026
**Reviewer:** Claude (AI-assisted code review)
**Stack:** Laravel 12.x / PHP 8.2+ / Bootstrap / Livewire 3 / MySQL

---

## Table of Contents

1. [Executive Summary](#executive-summary)
2. [Critical Issues — Fix Immediately](#1-critical-issues--fix-immediately)
3. [Security Vulnerabilities](#2-security-vulnerabilities)
4. [Authorization & Policy Issues](#3-authorization--policy-issues)
5. [Model & Relationship Issues](#4-model--relationship-issues)
6. [Controller & Route Issues](#5-controller--route-issues)
7. [Database & Migration Issues](#6-database--migration-issues)
8. [Services, Jobs & Business Logic Issues](#7-services-jobs--business-logic-issues)
9. [View & Frontend Issues](#8-view--frontend-issues)
10. [Test Coverage Gaps](#9-test-coverage-gaps)
11. [Code Quality & Technical Debt](#10-code-quality--technical-debt)
12. [Prioritized Remediation Roadmap](#prioritized-remediation-roadmap)

---

## Executive Summary

The IATSE Local 118 Laravel application is a substantial content management and member portal with 45+ models, 70+ controllers, 210+ Blade templates, and 125 database migrations. While the application has solid fundamentals (consistent CSRF protection, layout inheritance, Spatie permissions), the review uncovered **significant issues across every layer** of the application.

### Issue Severity Summary

| Severity | Count | Key Areas |
|----------|-------|-----------|
| **CRITICAL** | 18 | Broken bootstrap, SQL injection, broken jobs, exposed credentials, empty policies |
| **HIGH** | 25+ | Wrong relationship types, missing authorization, fat controllers, missing indexes |
| **MEDIUM** | 30+ | Inconsistent patterns, missing validation, accessibility, hardcoded config |
| **LOW** | 20+ | Dead code, TODO comments, naming conventions, type hints |

---

## 1. Critical Issues — Fix Immediately

These issues will cause runtime failures, data exposure, or security breaches.

### 1.1 Broken Application Bootstrap

**File:** `bootstrap/providers.php:6`

```php
App\Providers\RouteServiceProviderzzz::class,  // TYPO — "zzz" suffix
```

The class `RouteServiceProviderzzz` does not exist. This will cause a fatal error on boot. The file also references `AuthServiceProvider` which doesn't exist in `app/Providers/`.

**Fix:** Correct the class name or remove the reference.

---

### 1.2 SQL Injection Vulnerabilities

**File:** `app/Services/QboService.php:80`
```php
$results = $this->query("SELECT * FROM Customer WHERE PrimaryEmailAddr = '{$email}'");
```

**File:** `app/Console/Commands/UpdateExecutiveCommand.php:46`
```php
$result = DB::update('UPDATE executive_user SET current=0 WHERE id='.$d->id);
```

Both use direct string interpolation/concatenation in SQL queries. Use parameterized queries.

---

### 1.3 Broken ProcessMessages Job

**File:** `app/Jobs/ProcessMessages.php:33-40`
```php
public function handle(): void
{
    // todo
    $message->state = 'sending';  // $message is UNDEFINED
}
```

Variable `$message` is never defined. Job will throw "Undefined variable" error on every dispatch, potentially blocking the entire queue.

---

### 1.4 Debug Code Left in Production

**File:** `app/Livewire/Admin/EndlessMedia.php:28`
```php
dd($attachments);  // Dumps data and kills the page
```

This `dd()` call dumps database structure and file paths to the browser and makes the admin media page completely non-functional.

---

### 1.5 Exposed Credentials in Version Control

**File:** `.env.dusk.local.example:3-14`
```
APP_KEY=base64:BRgDV+rGbzw7fzNqKQx0vKTPLbCIK+qTnzPlqqLwFMo=
DB_USERNAME=root
DB_PASSWORD=root
```

The APP_KEY is used for session encryption and password reset tokens. Exposure means an attacker can forge sessions.

---

### 1.6 Undefined Service Injection — Runtime Crashes

**File:** `app/Http/Controllers/OrganizationController.php:31`
**File:** `app/Http/Controllers/FeatureController.php:35-37`

Both reference `$this->userImageService` but the service is never injected via the constructor. Will throw `Error: Call to undefined method` at runtime.

---

### 1.7 Invalid Route Name Reference

**File:** `app/Http/Controllers/InviteUserController.php:292`
```php
return redirect()->route('users.admin_list_invited_users');
```

Route name `users.admin_list_invited_users` does not exist. The actual name is `admin_list_invited_users`.

---

### 1.8 Missing LiveScope Import

**File:** `app/Http/Controllers/Admin/AdminSearchController.php:52+`

References `LiveScope::class` without an import statement. Will cause `Fatal error: Class 'LiveScope' not found`.

---

## 2. Security Vulnerabilities

### 2.1 Direct `$_SERVER` Superglobal Access (9 Files)

Bypasses Laravel's request abstraction and is vulnerable to header spoofing behind proxies:

| File | Lines |
|------|-------|
| `InviteUserController.php` | 103-104 |
| `UserController.php` | 293-295 |
| `MotionController.php` | 113-114 |
| `ContactController.php` | 77-78 |
| `Admin/AdminController.php` | 73-75 |
| `Admin/AdminActivityLogController.php` | 33-34 |
| `Admin/AdminUserController.php` | 443-445 |
| `Admin/AdminMotionController.php` | similar |
| `CommitteePostController.php` | 103-105 |

**Current:**
```php
'ip_address' => $_SERVER['REMOTE_ADDR'],
'user_agent' => $_SERVER['HTTP_USER_AGENT'],
```

**Should be:**
```php
'ip_address' => $request->ip(),
'user_agent' => $request->header('User-Agent'),
```

### 2.2 XSS Vulnerability — Unescaped User Input in Email

**File:** `resources/views/emails/contact.blade.php:50`
```blade
{!! $data['mail_body'] !!}
```

User-submitted contact form data rendered as raw HTML. An attacker can inject malicious HTML/JavaScript.

### 2.3 Hardcoded reCAPTCHA Key in View

**File:** `resources/views/contact.blade.php:45,52`

Google reCAPTCHA site key `6Ldv4sQaAAAAAJApVGt3T9XUyZcNFDrKLS_Umu1A` is hardcoded. Should be `config('services.recaptcha.site_key')`.

### 2.4 Hardcoded Google Analytics ID

**File:** `resources/views/layouts/jumbo.blade.php:18`

Analytics ID `G-WS6SX6VR7N` hardcoded in view. Should be an environment variable.

### 2.5 Mass Assignment Risk

Multiple controllers assign request data without using `validated()`:

```php
// Bad (found in multiple controllers)
$committeePost->fill($request['post']);
$user->fill($userRequest['user']);

// Good
$committeePost->fill($request->validated()['post']);
```

### 2.6 Missing `rel="noopener noreferrer"` on External Links

20+ external links use `target="_blank"` without protection. Affected files include nav.blade.php, footer.blade.php, developer admin views, and user views.

### 2.7 Broken Download Link with Template Name in URL

**File:** `resources/views/admin/attachments/attachment.blade.php:101`

URL contains literal `'attachment.blade.php'` string, creating broken download links. Should use `route('attachment_download', ...)`.

### 2.8 Deprecated `mime_content_type()` Function

**File:** `app/Http/Controllers/Admin/AdminMotionController.php:100`
**File:** `app/Console/Commands/SendEmailsNow.php:66`

Deprecated since PHP 5.3.0, may be removed in future PHP versions. Use `finfo_file()` or Laravel's `Storage::mimeType()`.

---

## 3. Authorization & Policy Issues

### 3.1 Completely Unimplemented Policies

These policies have **all methods empty** — no authorization is enforced:

| Policy | File |
|--------|------|
| `FileAccessPolicy` | `app/Policies/FileAccessPolicy.php` — all 8 methods empty |
| `PolicyPolicy` | `app/Policies/PolicyPolicy.php` — all 7 methods empty |

### 3.2 Missing Return Statements in Policies

**File:** `app/Policies/UserPolicy.php:33-50`
The `view()` method declares `bool` return type but has a code path that returns `null` (implicit). This makes authorization unreliable.

**File:** `app/Policies/InviteUserPolicy.php:12-18`
The `before()` method is missing `$ability` parameter and has no return when `$test` is false.

### 3.3 Overly Permissive Policies

**File:** `app/Policies/MotionPolicy.php:24-29`
```php
public function viewAny(User $user): bool
{
    return true;  // EVERYONE can view all motions
}
```

Has a TODO comment confirming this is incomplete.

### 3.4 Wrong Return Type in CommitteePostPolicy

**File:** `app/Policies/CommitteePostPolicy.php:13-20`
```php
public function viewAny(User $user): User|bool
{
    return $user;  // Returns User object, not bool!
}
```

### 3.5 Empty `view()` Methods Across 10 Policies

These all have empty `view()` methods that return `null` implicitly:

- AgreementPolicy, FeaturePolicy, MeetingPolicy, EmploymentPolicy, TopicPolicy
- VenuePolicy, AttachmentPolicy, OrganizationPolicy, PagePolicy, MemoriamPolicy

### 3.6 Permission-Resource Mismatches

**MemoriamPolicy** and **ExecutivePolicy** check for `'create users'` and `'edit users'` permissions instead of memoriam/executive-specific permissions.

### 3.7 Form Request Authorization Always Returns True

**File:** `app/Http/Requests/Committees/StoreCommitteeRequest.php:17-20`
```php
public function authorize(): bool { return true; }
```

This pattern appears across multiple Form Request classes.

---

## 4. Model & Relationship Issues

### 4.1 Wrong Relationship Type: `HasOne` Instead of `BelongsTo` (11 Models)

These models define `user()` as `HasOne` when they should be `BelongsTo` (the model has the `user_id` column, not the other way around):

| Model | File:Line |
|-------|-----------|
| Organization | `app/Models/Organization.php:116-119` |
| Venue | `app/Models/Venue.php:114-117` |
| Carousel | `app/Models/Carousel.php:74-77` |
| Agreement | `app/Models/Agreement.php:102-105` |
| Bylaw | `app/Models/Bylaw.php:88-91` |
| Policy | `app/Models/Policy.php:72-75` |
| Employment | `app/Models/Employment.php:87-90` |
| Faq | `app/Models/Faq.php:78-81` |
| FaqData | `app/Models/FaqData.php:90-93` |
| ExecutiveMembership | `app/Models/ExecutiveMembership.php:35-38` |
| Meeting | `app/Models/Meeting.php:95-98` |

**Impact:** Generates wrong SQL queries, defeats eager loading, and is semantically incorrect.

### 4.2 Invalid BelongsTo with withPivot()

**File:** `app/Models/Committee.php:123-126`
```php
public function committee_member(): BelongsTo
{
    return $this->belongsTo(User::class)
        ->withPivot('role')        // ERROR! BelongsTo doesn't support this
        ->withTimestamps();        // ERROR!
}
```

Will throw runtime exception. Likely a duplicate of the `committee_members()` BelongsToMany relationship.

### 4.3 N+1 Query Issues in `getSearchResult()` (5 Models)

These models execute raw queries inside `getSearchResult()` instead of using relationships:

| Model | File:Line | Issue |
|-------|-----------|-------|
| UserInfo | `app/Models/UserInfo.php:62-64` | `User::where('id', $this->user_id)->first()` |
| Address | `app/Models/Address.php:47` | Same pattern |
| PhoneNumber | `app/Models/PhoneNumber.php:27` | Same pattern |
| CommitteePost | `app/Models/CommitteePost.php:61` | Manual committee lookup |
| CommitteePostComment | `app/Models/CommitteePostComment.php:68-69` | Two manual lookups |

### 4.4 Missing Relationships

- **Address** and **PhoneNumber** models use `$this->user_id` but have no `user()` BelongsTo relationship
- **CommitteePostComment** has `parent_id` but no `parent()`/`children()` self-referential relationships

### 4.5 Empty Models Without Mass Assignment Config

- `Admin.php`, `Hello.php`, `Site.php`, `Dashboard.php`, `Contact.php` — no `$fillable` or `$guarded`

### 4.6 Incorrect Message Relationship

**File:** `app/Models/Message.php:86-89`
```php
public function email_queue(): BelongsToMany
{
    return $this->belongsToMany(EmailQueue::class, 'message_id'); // 'message_id' is NOT a pivot table name
}
```

---

## 5. Controller & Route Issues

### 5.1 Fat Controllers — Excessive Business Logic

| Controller | Method | Lines | Contains |
|------------|--------|-------|----------|
| `UserController` | `update()` | 124 lines | User data, phone, emergency contact, image uploads, thumbnails, file deletion, membership, activity logging, email |
| `InviteUserController` | `store()` | 30+ lines | Invitation creation, password hashing, email sending, activity logging |
| `Admin/AdminMessageController` | `send()` | 37 lines | Email queue creation for all subscribers |
| `MotionController` | Methods | 120+ lines | Complex business logic, email notifications, date calculations |

**Recommendation:** Extract to Service/Action classes.

### 5.2 Duplicate Route Definitions

**File:** `routes/web.php:54-57` AND `routes/web.php:81-84`

The Post routes (`/posts`, `/post/{post}`) are defined twice, with the second overwriting the first.

### 5.3 Missing Rate Limiting

Only download endpoints have rate limiting. Missing on:
- Contact form submission (spam vector)
- Local search (resource intensive)
- User invitation signup (brute force risk)
- All admin POST endpoints

### 5.4 Inconsistent Authorization Patterns

Three different patterns used across controllers:
1. `Gate::authorize()` (preferred)
2. Manual `Auth::check()` with access level comparison
3. No authorization at all

### 5.5 Dead/Debug Code in Controllers

| File | Issue |
|------|-------|
| `MailController.php` | Entire controller is debug code with `dd()` |
| `UserController.php:97-105` | 9 lines commented image code |
| `AgreementController.php:14-37` | 24 lines commented demo code |
| `CommitteePostCommentController.php:84-122` | `update()` and `destroy()` fully commented |
| `Admin/AdminActivityLogController.php:55-60` | `destroy()` doesn't actually delete |
| `Admin/AdminUserController.php:97-175` | `create()` and `store()` are stubs |
| `ContactlistdataController.php` | All CRUD methods are empty stubs |

### 5.6 Missing Form Request Validation

Multiple controllers accept requests without any validation: `ContactController`, `CommitteePostCommentController`, `ContactlistdataController`, and others.

### 5.7 QBO Routes Not Registered

Controllers `QboAuthController` and `DashboardController` reference route names like `qbo.connect` and `qbo.dashboard`, but these routes do not appear in `routes/web.php`.

---

## 6. Database & Migration Issues

### 6.1 Missing `venues` Table Creation Migration

The `venues` table is referenced in 4+ migrations but **never created**. Running fresh migrations will fail.

### 6.2 Broken Foreign Key Syntax (5 Tables)

These use `->references()->on()` without `->foreign()` wrapper — constraints are not actually created:

- `message_selections.user_id` — also references wrong table name `'user'` instead of `'users'`
- `message_sending.message_id`
- `email_queue.message_id` and `email_queue.user_id`
- `messages.user_id`

### 6.3 Missing Indexes on 60+ Foreign Key Columns

Every `user_id`, `committee_id`, `faq_id`, `post_id`, `parent_id` column across the schema is missing an index. This causes full table scans on joins.

**Most impactful missing indexes:**
- `users_info.user_id`, `addresses.user_id`, `phone_numbers.user_id`, `memberships.user_id`
- `posts.user_id`, `committees.user_id`, `meetings.user_id`, `employment.user_id`
- All pivot table composite indexes

### 6.4 Missing Soft Deletes

Only `users` and `committee_user` have soft deletes. Content tables (pages, posts, topics, agreements, bylaws, meetings, motions) should all support soft deletes for data recovery.

### 6.5 Incomplete Rollback Methods (4 Migrations)

These migrations have empty or commented `down()` methods — cannot be rolled back:

- `2021_02_25_051947_alter_tables_add_live_feature_front.php` — "I want all the columns changed, gone forever"
- `2024_11_16_064241_alter_email_message_sending_tables.php` — "todo not going back to old schema"
- `2020_05_06_210415_remove_allowcomments_committees_table.php`
- `2021_02_08_081241_alter_meetings_table_timestamp.php`

### 6.6 Missing Pivot Table Primary Keys

15+ pivot tables have no primary key or unique constraint, allowing duplicate relationships.

### 6.7 Naming Convention Issues

- Typos: `create_committe_posts_comments_table.php` (missing 'e'), `update_commttee_user.php` (double 't')
- Inconsistent: `carousel.order` is a string when it should be integer for sorting
- Mixed boolean types: some use `$table->boolean()`, others use `$table->tinyInteger()`

### 6.8 Schema Churn

Several tables were created and then immediately dropped or restructured within days (QBO tokens, page_post pivot, meeting_attachments), indicating incomplete requirements.

---

## 7. Services, Jobs & Business Logic Issues

### 7.1 Duplicate Service Classes

`AttachmentService` and `MessageAttachmentService` share nearly identical methods: `createAttachment()`, `updateAttachment()`, `destroyAttachments()`, `human_filesize()`. Should be consolidated.

Similarly, `EmailMemberUpdateService` and `EmailMemberUpdateAddressService` duplicate email sending logic.

### 7.2 Inconsistent Config Key Usage

**File:** `app/Services/EmailCommitteeMembershipService.php:17,31`
```php
config('app.APP_ENV')  // WRONG — returns null
config('app.APP_NAME') // WRONG — returns null
```

Other services correctly use `config('app.env')` and `config('app.name')`.

### 7.3 Missing Error Handling in SendEmailsNow Command

**File:** `app/Console/Commands/SendEmailsNow.php:57-71`

`Mail::send()` is not wrapped in try-catch. If one email fails, the entire batch stops.

### 7.4 Error Suppression Operator

**Files:** `app/Services/AttachmentService.php:89`, `app/Services/MessageAttachmentService.php:112`
```php
return sprintf("%.{$decimals}f", $bytes / (1024 ** $factor)).@$sz[$factor - 1].'B';
```

The `@` operator hides array index errors. Use null coalescing: `($sz[$factor - 1] ?? 'B')`.

### 7.5 Unsafe HTML Truncation

**File:** `app/Composers/ViewComposers.php:35`
```php
$post->short_body = substr($post->body, 0, 3000).'...';
// todo clean post->body so markup doesnt break
```

Truncating raw HTML can split tags mid-way, producing malformed output.

### 7.6 Wrong Admin Route in PolicyProofreaderAdapter

**File:** `app/Adapters/Proofreader/PolicyProofreaderAdapter.php:29`

Uses `'policies_list'` (list page) instead of `'admin_policy_edit'` (edit page) like other adapters.

### 7.7 Hardcoded Developer Email

**File:** `app/Providers/AppServiceProvider.php:162`
```php
if (! app()->environment('production')) {
    Mail::alwaysTo('superwebdeveloper@gmail.com');
}
```

Should be an environment variable.

### 7.8 Environment Variables Used Outside Config

**File:** `app/Console/Commands/SendEmailsNow.php:37`
```php
$data['message']['sender'] = env('MAIL_FROM_ADDRESS');
```

Should be `config('mail.from.address')`. `env()` calls outside config files won't work with config caching.

---

## 8. View & Frontend Issues

### 8.1 Hardcoded Routes in Views (6+ Instances)

| File | Line | Hardcoded Path |
|------|------|----------------|
| `admin/admin.blade.php` | 6 | `action="/admin/search"` |
| `admin/search_admin.blade.php` | — | `action="/admin/search"` |
| `admin/proofreading.blade.php` | — | `action="/admin/proofreading/..."` |
| `layouts/nav.blade.php` | 143 | `href="/page/master-call-list"` |
| `layouts/nav.blade.php` | 112 | `href=" /topic/contract-ratifications"` (note leading space) |
| `layouts/dashboard.blade.php` | 29 | `href="/admin"` |

### 8.2 Missing Accessibility (WCAG Failures)

- **30+ images** lack `alt` attributes (WCAG 2.1 Level A — 1.1.1)
- **20+ file inputs** lack `<label>` associations (WCAG 2.1 Level A — 1.3.1)

### 8.3 TESTTEST Placeholders in Example Config

**File:** `example.env.example:62-63`
```
MAIL_OFFICE_EMAIL_RECIPIENT='TESTTESTadmin@iatse118.com'
MAIL_OFFICE_EMAIL_NAME='TESTTESTIATSE 118 Administrator'
```

### 8.4 Deprecated JavaScript

**Files:** `layouts/app.blade.php:18`, `layouts/invitation-layout.blade.php`

Uses deprecated `document.write()` for jQuery fallback loading.

### 8.5 Vue 2 End-of-Life

**File:** `package.json` — Uses `vue: ^2.6.14`. Vue 2 reached EOL December 31, 2023.

### 8.6 Missing Error Pages

Present: 401, 403, 404, 419, 429, 500, 503. Missing: 400, 405, 422, 502, 504.

---

## 9. Test Coverage Gaps

### 9.1 Current State

Only a handful of test files exist:
- `tests/Feature/Http/Controllers/` — limited controller tests
- `tests/Unit/Http/` — some request validation tests
- `tests/Feature/PublicContactFormTest.php`, `TopicTest.php`, `UserTest.php`

### 9.2 Critical Missing Tests

- **No policy authorization tests** — only 5 policy-related test files for 21 policy classes (24% coverage)
- **No model relationship tests** — wrong relationship types go undetected
- **No service tests** — SQL injection in QboService untested
- **No Livewire component tests**
- **No email/notification tests**
- **No command tests** (broken ProcessMessages job would be caught)

### 9.3 Incomplete Test Infrastructure

- `UserFactory.php:30` has incomplete bcrypt hash: `'password$2y$10$92IXUN'`
- `DatabaseSeeder.php` is completely empty (commented out)

---

## 10. Code Quality & Technical Debt

### 10.1 TODO Comments

**73+ TODO comments** scattered across the codebase, indicating incomplete features. Key ones:

| File | Note |
|------|------|
| `MotionPolicy.php:36` | "todo auth logged in for admin" |
| `PostPolicy.php:27` | "todo differentiate between members and public content" |
| `MessageController.php:72` | "todo form request validator" |
| `UserController.php:61` | "todo authorize is having a problem..." |
| `InviteUserController.php:119` | "todo 48 hour signup limitation" |

### 10.2 Deprecated Validation Rule Interface

**File:** `app/Rules/Phone.php` — Implements `Illuminate\Contracts\Validation\Rule` which is deprecated in modern Laravel. Should use `ValidationRule` interface or closures.

### 10.3 Slug Generation Duplication

11+ models implement slug generation via `setNameAttribute()` / `setTitleAttribute()` mutators with `Str::slug()`. Should be extracted to a trait.

### 10.4 Unused Private Properties

- `Organization.php:66` — `private $attachments;`
- `ExecutiveMembership.php:25` — `private $user;`

### 10.5 Inconsistent Casts Syntax

Some models use the old `protected $casts = []` property, others use the new `protected function casts(): array` method. Should standardize.

---

## Prioritized Remediation Roadmap

### Phase 1: Critical — Do Immediately (1-2 days)

| # | Task | Files |
|---|------|-------|
| 1 | Fix `bootstrap/providers.php` typo | `bootstrap/providers.php` |
| 2 | Remove `dd()` from EndlessMedia | `app/Livewire/Admin/EndlessMedia.php` |
| 3 | Fix SQL injection in QboService | `app/Services/QboService.php` |
| 4 | Fix SQL injection in UpdateExecutiveCommand | `app/Console/Commands/UpdateExecutiveCommand.php` |
| 5 | Fix broken ProcessMessages job | `app/Jobs/ProcessMessages.php` |
| 6 | Fix undefined `userImageService` injection | `OrganizationController.php`, `FeatureController.php` |
| 7 | Fix invalid route name reference | `InviteUserController.php` |
| 8 | Add missing LiveScope import | `AdminSearchController.php` |
| 9 | Fix XSS in contact email | `resources/views/emails/contact.blade.php` |
| 10 | Rotate APP_KEY, remove from example files | `.env.dusk.local.example` |

### Phase 2: Security — This Sprint (3-5 days)

| # | Task | Files |
|---|------|-------|
| 11 | Replace all `$_SERVER` with `$request->ip()` / `$request->header()` | 9 controller files |
| 12 | Implement FileAccessPolicy and PolicyPolicy | 2 policy files |
| 13 | Fix missing return statements in UserPolicy and InviteUserPolicy | 2 policy files |
| 14 | Fix MotionPolicy `viewAny()` — don't allow everyone | `MotionPolicy.php` |
| 15 | Implement all empty policy `view()` methods | 10 policy files |
| 16 | Fix CommitteePostPolicy return types | `CommitteePostPolicy.php` |
| 17 | Fix permission-resource mismatches | `MemoriamPolicy.php`, `ExecutivePolicy.php` |
| 18 | Add `rel="noopener noreferrer"` to external links | ~20 view files |
| 19 | Move hardcoded secrets to .env | `contact.blade.php`, `jumbo.blade.php` |
| 20 | Fix broken download link template | `admin/attachments/attachment.blade.php` |

### Phase 3: Data Integrity — Next Sprint (3-5 days)

| # | Task | Files |
|---|------|-------|
| 21 | Fix all 11 HasOne → BelongsTo relationship inversions | 11 model files |
| 22 | Fix Committee.committee_member() BelongsTo with withPivot | `Committee.php` |
| 23 | Fix N+1 queries in getSearchResult() methods | 5 model files |
| 24 | Add missing `user()` relationships to Address, PhoneNumber | 2 model files |
| 25 | Fix Message.email_queue() relationship type | `Message.php` |
| 26 | Create missing venues table migration | New migration |
| 27 | Fix broken foreign key syntax | 4 migration fixes |
| 28 | Add indexes to 60+ foreign key columns | New migration |
| 29 | Fix `config('app.APP_ENV')` → `config('app.env')` | `EmailCommitteeMembershipService.php` |
| 30 | Register QBO routes in web.php | `routes/web.php` |

### Phase 4: Code Quality — Following Sprint (5-8 days)

| # | Task | Files |
|---|------|-------|
| 31 | Extract business logic from fat controllers into Services | 4+ controllers |
| 32 | Add Form Request validation to unvalidated controllers | 8+ controllers |
| 33 | Implement consistent authorization pattern | Application-wide |
| 34 | Remove duplicate route definitions | `routes/web.php` |
| 35 | Add rate limiting to form submissions | `routes/web.php` |
| 36 | Consolidate duplicate services | `AttachmentService`, `EmailMemberUpdate*Service` |
| 37 | Add error handling to SendEmailsNow | `SendEmailsNow.php` |
| 38 | Replace hardcoded paths with `route()` helpers in views | 6+ view files |
| 39 | Fix TESTTEST placeholders in example config | `example.env.example` |
| 40 | Remove dead/debug code | `MailController.php`, commented methods |

### Phase 5: Polish & Maintenance (Ongoing)

| # | Task | Files |
|---|------|-------|
| 41 | Add comprehensive policy authorization tests | New test files |
| 42 | Add model relationship tests | New test files |
| 43 | Fix UserFactory password hash | `database/factories/UserFactory.php` |
| 44 | Implement DatabaseSeeder | `database/seeders/DatabaseSeeder.php` |
| 45 | Add alt text to 30+ images | Various views |
| 46 | Add labels to 20+ form inputs | Various views |
| 47 | Extract slug generation to a trait | 11+ model files |
| 48 | Standardize casts syntax across models | Multiple models |
| 49 | Evaluate and add soft deletes to content tables | New migrations |
| 50 | Resolve 73+ TODO comments | Application-wide |
| 51 | Upgrade Vue 2 → Vue 3 | `package.json`, JS files |
| 52 | Replace deprecated Phone validation rule | `app/Rules/Phone.php` |
| 53 | Replace `env()` calls outside config | Console commands |
| 54 | Add missing error pages (400, 405, 422) | New view files |

---

## OWASP Top 10 Mapping

| OWASP Category | Issues Found | Severity |
|---|---|---|
| A01 — Broken Access Control | Empty policies, missing returns, overly permissive | CRITICAL |
| A02 — Cryptographic Failures | Exposed APP_KEY and DB credentials | CRITICAL |
| A03 — Injection | SQL injection in QboService and UpdateExecutiveCommand | CRITICAL |
| A04 — Insecure Design | Mass assignment risks, missing validation | HIGH |
| A05 — Security Misconfiguration | Broken bootstrap, debug mode, hardcoded secrets | CRITICAL |
| A06 — Vulnerable Components | Vue 2 EOL, deprecated PHP functions | MEDIUM |
| A07 — Auth Failures | Missing rate limiting, incomplete policies | MEDIUM |

---

*This review was generated by analyzing every file across all application layers. All file paths and line numbers reference the current state of the repository as of the review date. Findings should be verified before implementing fixes, as some issues may be mitigated by runtime configuration not visible in source code.*
