<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\LanguageController;
    use App\Http\Controllers\CountryController;
    use App\Http\Controllers\StateController;
    use App\Http\Controllers\ServiceGroupController;
    use App\Http\Controllers\TaglineController;

    Route::get('/', [HomeController::class, 'index'])->name('common.landing');
    Route::get('/register', [HomeController::class, 'register'])->name('common.register');
    Route::get('/register-as-owner', [HomeController::class, 'register_as_owner'])->name('common.register-as-owner');
    Route::post('/signup', [HomeController::class, 'signup'])->name('common.signup');
    Route::get('/verify-otp', [HomeController::class, 'verify_otp'])->name('common.verify-otp');
    Route::get('/forgot-password', [HomeController::class, 'index'])->name('common.forgot-password');

    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('login');
        Route::get('login', [AdminController::class, 'index'])->name('admin.login');
        Route::post('check-login', [AdminController::class, 'check_login'])->name('admin.submit.login');
        Route::post('register', [AdminController::class, 'register'])->name('admin.register');
        
        Route::middleware('auth')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
            Route::get('general-settings', [DashboardController::class, 'general_settings'])->name('admin.general-settings');
            Route::post('submit-general-settings', [DashboardController::class, 'submit_general_settings'])->name('admin.submit.general-settings');

            Route::resource('states', StateController::class);
            Route::get('/load-states', [StateController::class, 'load'])->name('admin.state.load');

            Route::resource('countries', CountryController::class);
            Route::get('/load-countries', [CountryController::class, 'load'])->name('admin.country.load');

            Route::resource('languages', LanguageController::class);
            Route::get('/load-languages', [LanguageController::class, 'load'])->name('admin.language.load');

            Route::resource('service_groups', ServiceGroupController::class);
            Route::get('/load-service-groups', [ServiceGroupController::class, 'load'])->name('admin.service_group.load');

            Route::resource('taglines', TaglineController::class);
            Route::get('/load-taglines', [TaglineController::class, 'load'])->name('admin.tagline.load');
            
            Route::get('logout', [AdminController::class, 'logout'])->name('admin.logout');
        });
    });
