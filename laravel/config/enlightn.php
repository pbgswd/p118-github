<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enlightn Analyzer Classes
    |--------------------------------------------------------------------------
    |
    | The following array lists the "analyzer" classes that will be registered
    | with Enlightn. These analyzers run an analysis on the application via
    | various methods such as static analysis. Feel free to customize it.
    |
    */
    'analyzers' => ['*'],

    // If you wish to skip running some analyzers, list the classes in the array below.
    'exclude_analyzers' => [],

    // If you wish to skip running some analyzers in CI mode, list the classes below.
    'ci_mode_exclude_analyzers' => [],

    /*
    |--------------------------------------------------------------------------
    | Enlightn Analyzer Paths
    |--------------------------------------------------------------------------
    |
    | The following array lists the "analyzer" paths that will be searched
    | recursively to find analyzer classes. This option will only be used
    | if the analyzers option above is set to the asterisk wildcard. The
    | key is the base namespace to resolve the class name.
    |
    */
    'analyzer_paths' => [
        'Enlightn\\Enlightn\\Analyzers' => base_path('vendor/enlightn/enlightn/src/Analyzers'),
        'Enlightn\\EnlightnPro\\Analyzers' => base_path('vendor/enlightn/enlightnpro/src/Analyzers'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Enlightn Base Path
    |--------------------------------------------------------------------------
    |
    | The following array lists the directories that will be scanned for
    | application specific code. By default, we are scanning your app
    | folder, migrations folder and the seeders folder.
    |
    */
    'base_path' => [
        app_path(),
        database_path('migrations'),
        database_path('seeders'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Specific Analyzers
    |--------------------------------------------------------------------------
    |
    | There are some analyzers that are meant to be run for specific environments.
    | The options below specify whether we should skip environment specific
    | analyzers if the environment does not match.
    |
    */
    'skip_env_specific' => env('ENLIGHTN_SKIP_ENVIRONMENT_SPECIFIC', false),

    /*
    |--------------------------------------------------------------------------
    | Guest URL
    |--------------------------------------------------------------------------
    |
    | Specify any guest url or path (preferably your app's login url) here. This
    | would be used by Enlightn to inspect your application HTTP headers.
    | Example: '/login'.
    |
    */
    'guest_url' => null,

    /*
    |--------------------------------------------------------------------------
    | Exclusions From Reporting
    |--------------------------------------------------------------------------
    |
    | Specify the analyzer classes that you wish to exclude from reporting. This
    | means that if any of these analyzers fail, they will not be counted
    | towards the exit status of the Enlightn command. This is useful
    | if you wish to run the command in your CI/CD pipeline.
    | Example: [\Enlightn\Enlightn\Analyzers\Security\XSSAnalyzer::class].
    |
    */
    'dont_report' => [Enlightn\Enlightn\Analyzers\Performance\CacheHeaderAnalyzer::class, Enlightn\Enlightn\Analyzers\Performance\RouteCachingAnalyzer::class, Enlightn\Enlightn\Analyzers\Reliability\EnvExampleAnalyzer::class, Enlightn\Enlightn\Analyzers\Security\FilePermissionsAnalyzer::class, Enlightn\Enlightn\Analyzers\Security\PHPIniAnalyzer::class, Enlightn\Enlightn\Analyzers\Security\StableDependencyAnalyzer::class, Enlightn\Enlightn\Analyzers\Security\XSSAnalyzer::class],

    /*
    |--------------------------------------------------------------------------
    | Ignoring Errors
    |--------------------------------------------------------------------------
    |
    | Use this config option to ignore specific errors. The key of this array
    | would be the analyzer class and the value would be an associative
    | array with path and details. Run php artisan enlightn:baseline
    | to auto-generate this. Patterns are supported in details.
    |
    */
    'ignore_errors' => [Enlightn\Enlightn\Analyzers\Reliability\DeadCodeAnalyzer::class => [['path' => 'app/Http/Controllers/AdminController.php', 'details' => 'Empty array passed to foreach.'], ['path' => 'app/Http/Controllers/AdminController.php', 'details' => 'Empty array passed to foreach.'], ['path' => 'app/Http/Controllers/AdminEmploymentController.php', 'details' => 'Unreachable statement - code above always terminates.'], ['path' => 'app/Http/Controllers/AdminUserController.php', 'details' => 'Unreachable statement - code above always terminates.'], ['path' => 'app/Http/Requests/CommitteePost/UpdateCommitteePostRequest.php', 'details' => 'Unreachable statement - code above always terminates.'], ['path' => 'database/seeders/AgreementsTableSeeder.php', 'details' => 'Empty array passed to foreach.'], ['path' => 'database/seeders/ByLawsTableSeeder.php', 'details' => 'Empty array passed to foreach.'], ['path' => 'database/seeders/EmploymentSeeder.php', 'details' => 'Empty array passed to foreach.'], ['path' => 'database/seeders/MinutesSeeder.php', 'details' => 'Empty array passed to foreach.']], Enlightn\Enlightn\Analyzers\Reliability\ForeachIterableAnalyzer::class => [['path' => 'app/Http/Controllers/AdminUserController.php', 'details' => 'Argument of an invalid type App\\Models\\User|Illuminate\\Database\\Eloquent\\Collection<App\\Models\\User> supplied for foreach, only iterables are supported.'], ['path' => 'app/Http/Controllers/AttachmentController.php', 'details' => 'Argument of an invalid type array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile supplied for foreach, only iterables are supported.'], ['path' => 'app/Http/Controllers/AttachmentController.php', 'details' => 'Argument of an invalid type App\\Models\\Attachment|Illuminate\\Database\\Eloquent\\Collection<App\\Models\\Attachment> supplied for foreach, only iterables are supported.'], ['path' => 'app/Http/Controllers/EmploymentController.php', 'details' => 'Argument of an invalid type Illuminate\\Contracts\\Pagination\\LengthAwarePaginator supplied for foreach, only iterables are supported.'], ['path' => 'app/Services/AttachmentService.php', 'details' => 'Argument of an invalid type array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile supplied for foreach, only iterables are supported.'], ['path' => 'database/migrations/2021_05_02_114106_create_import_users_table.php', 'details' => 'Argument of an invalid type array<int, string>|false supplied for foreach, only iterables are supported.']], Enlightn\Enlightn\Analyzers\Reliability\InvalidMethodCallAnalyzer::class => [['path' => 'app/Adapters/Proofreader/BaseProofreaderAdapter.php', 'details' => 'Call to an undefined method App\\Adapters\\Proofreader\\BaseProofreaderAdapter::getMeta().'], ['path' => 'app/Http/Controllers/AdminCommitteeController.php', 'details' => 'Cannot call method getClientOriginalName() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminCommitteeController.php', 'details' => 'Cannot call method find() on array<App\\Models\\User>.'], ['path' => 'app/Http/Controllers/AdminCommitteeController.php', 'details' => 'Cannot call method filter() on array<App\\Models\\User>.'], ['path' => 'app/Http/Controllers/AdminCommitteeController.php', 'details' => 'Cannot call method getClientOriginalName() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminCommitteeController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminFeatureController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminFeatureController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminMemoriamController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminMemoriamController.php', 'details' => 'Cannot call method getClientOriginalName() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminMemoriamController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminMemoriamController.php', 'details' => 'Cannot call method getClientOriginalName() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminOrganizationController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminOrganizationController.php', 'details' => 'Cannot call method getClientOriginalName() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminOrganizationController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminOrganizationController.php', 'details' => 'Cannot call method getClientOriginalName() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminPageController.php', 'details' => 'Cannot call method pluck() on array<App\\Models\\Topic>.'], ['path' => 'app/Http/Controllers/AdminPageController.php', 'details' => 'Cannot call method pluck() on array<App\\Models\\Topic>.'], ['path' => 'app/Http/Controllers/AdminVenueController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminVenueController.php', 'details' => 'Cannot call method getClientOriginalName() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminVenueController.php', 'details' => 'Cannot call method store() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/AdminVenueController.php', 'details' => 'Cannot call method getClientOriginalName() on array<int, Illuminate\\Http\\UploadedFile>|Illuminate\\Http\\UploadedFile.'], ['path' => 'app/Http/Controllers/CommitteeController.php', 'details' => 'Cannot call method filter() on array<App\\Models\\User>.'], ['path' => 'app/Http/Controllers/CommitteeController.php', 'details' => 'Cannot call method filter() on array<App\\Models\\Committee>.'], ['path' => 'app/Http/Controllers/Controller.php', 'details' => 'Call to an undefined static method App\\Models\\Options::countries().'], ['path' => 'app/Http/Controllers/TopicController.php', 'details' => 'Cannot call method sortByDesc() on array<App\\Models\\Attachment>.'], ['path' => 'app/Http/Controllers/TopicController.php', 'details' => 'Cannot call method sortByDesc() on array<App\\Models\\Page>.'], ['path' => 'app/Http/Controllers/TopicController.php', 'details' => 'Cannot call method sortByDesc() on array<App\\Models\\Post>.'], ['path' => 'app/Http/Controllers/UserController.php', 'details' => 'Method App\\Services\\UserImageService::updateImage() invoked with 3 parameters, 4 required.'], ['path' => 'app/Models/Address.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Agreement.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Bylaw.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Committee.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/CommitteePost.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/CommitteePostComment.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Employment.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Executive.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/ExecutiveMembership.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Feature.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Meeting.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Memoriam.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Organization.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Page.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/PhoneNumber.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Policy.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Post.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Topic.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/User.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/UserInfo.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Models/Venue.php', 'details' => 'Cannot call method getName() on object|string.'], ['path' => 'app/Policies/CommitteePolicy.php', 'details' => 'Cannot call method find() on array<App\\Models\\User>.'], ['path' => 'app/Services/AttachmentService.php', 'details' => 'Call to an undefined method App\\Models\\Interfaces\\HasAttachment::load().'], ['path' => 'app/Services/ProofreaderService.php', 'details' => 'Call to an undefined method App\\Adapters\\Proofreader\\BaseProofreaderAdapter::getMeta().'], ['path' => 'app/Services/ProofreaderService.php', 'details' => 'Call to an undefined method App\\Adapters\\Proofreader\\BaseProofreaderAdapter::getMeta().'], ['path' => 'app/Services/UserImageService.php', 'details' => 'Call to an undefined method Spatie\\Image\\Manipulations::save().'], ['path' => 'database/seeders/MinutesSeeder.php', 'details' => 'Call to method save() on an unknown class App\\Models\\MeetingAttachment.']], Enlightn\Enlightn\Analyzers\Reliability\InvalidPropertyAccessAnalyzer::class => [['path' => 'app/Http/Controllers/AdminOrganizationController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminOrganizationController::$attachmentService.'], ['path' => 'app/Http/Controllers/AdminOrganizationController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminOrganizationController::$attachmentService.'], ['path' => 'app/Http/Controllers/AdminOrganizationController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminOrganizationController::$attachmentService.'], ['path' => 'app/Http/Controllers/AdminPageController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminPageController::$attachmentService.'], ['path' => 'app/Http/Controllers/AdminPageController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminPageController::$attachmentService.'], ['path' => 'app/Http/Controllers/AdminPageController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminPageController::$attachmentService.'], ['path' => 'app/Http/Controllers/AdminPageController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminPageController::$attachmentService.'], ['path' => 'app/Http/Controllers/AdminUserController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminUserController::$userImageService.'], ['path' => 'app/Http/Controllers/AdminUserController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminUserController::$userImageService.'], ['path' => 'app/Http/Controllers/AdminUserController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminUserController::$userImageService.'], ['path' => 'app/Http/Controllers/AdminVenueController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\AdminVenueController::$userImageService.'], ['path' => 'app/Http/Controllers/AttachmentController.php', 'details' => 'Cannot access property $id on App\\Models\\Attachment|string.'], ['path' => 'app/Http/Controllers/FeatureController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\FeatureController::$userImageService.'], ['path' => 'app/Http/Controllers/OrganizationController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\OrganizationController::$userImageService.'], ['path' => 'app/Http/Controllers/VenueController.php', 'details' => 'Access to an undefined property App\\Http\\Controllers\\VenueController::$userImageService.'], ['path' => 'app/Http/Requests/Committees/UpdateCommitteeRequest.php', 'details' => 'Cannot access property $slug on object|string.'], ['path' => 'app/Http/Requests/Feature/UpdateFeatureRequest.php', 'details' => 'Cannot access property $slug on object|string.'], ['path' => 'app/Http/Requests/Member/UpdateMember.php', 'details' => 'Cannot access property $id on object|string.'], ['path' => 'app/Http/Requests/Memoriam/UpdateMemoriamRequest.php', 'details' => 'Cannot access property $slug on object|string.'], ['path' => 'app/Http/Requests/Organization/UpdateOrganizationRequest.php', 'details' => 'Cannot access property $slug on object|string.'], ['path' => 'app/Http/Requests/Page/UpdatePageRequest.php', 'details' => 'Cannot access property $slug on object|string.'], ['path' => 'app/Http/Requests/Posts/UpdatePostRequest.php', 'details' => 'Cannot access property $slug on object|string.'], ['path' => 'app/Http/Requests/Topic/UpdateTopicRequest.php', 'details' => 'Cannot access property $slug on object|string.'], ['path' => 'app/Http/Requests/User/UpdateUser.php', 'details' => 'Cannot access property $id on object|string.'], ['path' => 'app/Http/Requests/Venues/UpdateVenueRequest.php', 'details' => 'Cannot access property $slug on object|string.'], ['path' => 'app/Services/AttachmentService.php', 'details' => 'Access to an undefined property App\\Models\\Interfaces\\HasAttachment::$attachments.'], ['path' => 'database/migrations/2021_01_19_045842_add_uuid_to_failed_jobs_table.php', 'details' => 'Cannot access property $id on (int|string).']], Enlightn\Enlightn\Analyzers\Reliability\InvalidReturnTypeAnalyzer::class => [['path' => 'app/Http/Controllers/AdminCommitteeController.php', 'details' => 'Method App\\Http\\Controllers\\AdminCommitteeController::uploadImage() should return string but returns string|false.'], ['path' => 'app/Http/Controllers/AttachmentController.php', 'details' => 'Method App\\Http\\Controllers\\AttachmentController::edit() should return Illuminate\\View\\View but returns Illuminate\\Http\\RedirectResponse.'], ['path' => 'app/Http/Controllers/Auth/RegisterController.php', 'details' => 'Method App\\Http\\Controllers\\Auth\\RegisterController::create() should return App\\User but returns App\\Models\\User.'], ['path' => 'app/Http/Controllers/InviteUserController.php', 'details' => 'Method App\\Http\\Controllers\\InviteUserController::show() should return Illuminate\\View\\View but returns Illuminate\\Http\\RedirectResponse.'], ['path' => 'app/Http/Controllers/PageController.php', 'details' => 'Method App\\Http\\Controllers\\PageController::show() should return Illuminate\\Support\\Facades\\Response but returns Illuminate\\Http\\RedirectResponse.'], ['path' => 'app/Http/Controllers/PageController.php', 'details' => 'Method App\\Http\\Controllers\\PageController::show() should return Illuminate\\Support\\Facades\\Response but returns Illuminate\\View\\View.'], ['path' => 'app/Models/ModelList.php', 'details' => 'Method App\\Models\\ModelList::getModelInfo() should return array<string> but returns array<string>.'], ['path' => 'app/Models/ModelList.php', 'details' => 'Method App\\Models\\ModelList::getModelList() should return array<array<string>> but returns array<string, array<string, string>>.'], ['path' => 'app/Models/Options.php', 'details' => 'Method App\\Models\\Options::years() should return array but returns array<float|int, float|int>.'], ['path' => 'app/Policies/CommitteePostPolicy.php', 'details' => 'Method App\\Policies\\CommitteePostPolicy::view() should return bool but returns App\\Models\\User.']], Enlightn\Enlightn\Analyzers\Reliability\MissingReturnStatementAnalyzer::class => [['path' => 'app/Console/Commands/UpdateEmploymentStatusCommand.php', 'details' => 'Method App\\Console\\Commands\\UpdateEmploymentStatusCommand::handle() should return int but return statement is missing.'], ['path' => 'app/Http/Controllers/AdminCarouselController.php', 'details' => 'Method App\\Http\\Controllers\\AdminCarouselController::store() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/AdminCarouselController.php', 'details' => 'Method App\\Http\\Controllers\\AdminCarouselController::show() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/AdminCarouselController.php', 'details' => 'Method App\\Http\\Controllers\\AdminCarouselController::destroy() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/CarouselController.php', 'details' => 'Method App\\Http\\Controllers\\CarouselController::index() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/CarouselController.php', 'details' => 'Method App\\Http\\Controllers\\CarouselController::create() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/CarouselController.php', 'details' => 'Method App\\Http\\Controllers\\CarouselController::store() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/CarouselController.php', 'details' => 'Method App\\Http\\Controllers\\CarouselController::edit() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/CarouselController.php', 'details' => 'Method App\\Http\\Controllers\\CarouselController::update() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/CarouselController.php', 'details' => 'Method App\\Http\\Controllers\\CarouselController::destroy() should return Illuminate\\Http\\Response but return statement is missing.'], ['path' => 'app/Http/Controllers/ContactController.php', 'details' => 'Method App\\Http\\Controllers\\ContactController::submit() should return Illuminate\\Http\\RedirectResponse but return statement is missing.'], ['path' => 'app/Http/Middleware/Authenticate.php', 'details' => 'Method App\\Http\\Middleware\\Authenticate::redirectTo() should return string but return statement is missing.'], ['path' => 'app/Policies/AttachmentPolicy.php', 'details' => 'Method App\\Policies\\AttachmentPolicy::viewAny() should return bool but return statement is missing.'], ['path' => 'app/Policies/AttachmentPolicy.php', 'details' => 'Method App\\Policies\\AttachmentPolicy::create() should return bool but return statement is missing.'], ['path' => 'app/Policies/InviteUserPolicy.php', 'details' => 'Method App\\Policies\\InviteUserPolicy::before() should return bool but return statement is missing.'], ['path' => 'app/Policies/MemoriamPolicy.php', 'details' => 'Method App\\Policies\\MemoriamPolicy::before() should return bool but return statement is missing.'], ['path' => 'app/Policies/UserPolicy.php', 'details' => 'Method App\\Policies\\UserPolicy::before() should return bool but return statement is missing.'], ['path' => 'app/Policies/UserPolicy.php', 'details' => 'Method App\\Policies\\UserPolicy::view() should return bool but return statement is missing.']], Enlightn\Enlightn\Analyzers\Security\FillableForeignKeyAnalyzer::class => [['path' => 'app/Models/Agreement.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/Bylaw.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/CommitteePost.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/CommitteePostComment.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/Employment.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/ExecutiveMembership.php', 'details' => 'Potential foreign key executive_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/InviteUser.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/Meeting.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/Memoriam.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/Organization.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/Policy.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.'], ['path' => 'app/Models/Post.php', 'details' => 'Potential foreign key user_id declared as fillable and available for mass assignment.']]],

    /*
    |--------------------------------------------------------------------------
    | Analyzer Configurations
    |--------------------------------------------------------------------------
    |
    | The following configuration options pertain to individual analyzers.
    | These are recommended options but feel free to customize them based
    | on your application needs.
    |
    */
    'license_whitelist' => [
        'Apache-2.0', 'Apache2', 'BSD-2-Clause', 'BSD-3-Clause', 'LGPL-2.1-only', 'LGPL-2.1',
        'LGPL-2.1-or-later', 'LGPL-3.0', 'LGPL-3.0-only', 'LGPL-3.0-or-later', 'MIT', 'ISC',
        'CC0-1.0', 'Unlicense',
    ],

    // Set to true to restrict the max number of files displayed in the enlightn
    // command for each check. Set to false to display all files.
    'compact_lines' => true,

    // List your commercial packages (licensed by you) below, so that they are not
    // flagged by the License Analyzer.
    'commercial_packages' => [
        'enlightn/enlightnpro',
    ],

    'allowed_permissions' => [
        base_path() => '775',
        app_path() => '775',
        resource_path() => '775',
        storage_path() => '775',
        public_path() => '775',
        config_path() => '775',
        database_path() => '775',
        base_path('routes') => '775',
        app()->bootstrapPath() => '775',
        app()->bootstrapPath('cache') => '775',
        app()->bootstrapPath('app.php') => '664',
        base_path('artisan') => '775',
        public_path('index.php') => '664',
        public_path('server.php') => '664',
    ],

    'writable_directories' => [
        storage_path(),
        app()->bootstrapPath('cache'),
    ],
];
