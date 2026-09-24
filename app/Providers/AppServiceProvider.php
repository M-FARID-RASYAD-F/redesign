<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Gate::policy(\App\Models\Book::class, \App\Policies\BookPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\BookCategory::class, \App\Policies\BookCategoryPolicy::class);
        \Illuminate\Support\Facades\Gate::policy(\App\Models\BookLoan::class, \App\Policies\BookLoanPolicy::class);

        // Super Admin Global Gate Bypass (Kecuali aksi khusus seperti menghapus diri sendiri)
        Gate::before(function ($user, string $ability) {
            if ($user && $user->is_active && $user->role === 'super_admin') {
                return true;
            }
        });

        // Register Policies Explicitly
        Gate::policy(\App\Models\News::class, \App\Policies\NewsPolicy::class);
        Gate::policy(\App\Models\Gallery::class, \App\Policies\GalleryPolicy::class);
        Gate::policy(\App\Models\TeacherStaff::class, \App\Policies\TeacherStaffPolicy::class);
        Gate::policy(\App\Models\Major::class, \App\Policies\MajorPolicy::class);
        Gate::policy(\App\Models\Announcement::class, \App\Policies\AnnouncementPolicy::class);
        Gate::policy(\App\Models\Agenda::class, \App\Policies\AgendaPolicy::class);
        Gate::policy(\App\Models\PpdbRegistration::class, \App\Policies\PpdbRegistrationPolicy::class);
        Gate::policy(\App\Models\PpdbDocument::class, \App\Policies\PpdbDocumentPolicy::class);
        Gate::policy(\App\Models\User::class, \App\Policies\UserPolicy::class);

        // Blade directive untuk sanitasi konten HTML (Cegah XSS)
        \Illuminate\Support\Facades\Blade::directive('sanitizeHtml', function ($expression) {
            return "<?php echo app(\\App\\Services\\HtmlSanitizerService::class)->clean($expression); ?>";
        });
    }
}
