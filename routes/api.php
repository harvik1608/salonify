<?php
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\AuthController;
    use App\Http\Controllers\Api\CommonController;

    // Public route (no auth)
    Route::post('check-number', [AuthController::class, 'checkNumber']);
    // Route::post('login', [AuthController::class, 'login']);
    // Route::post('forget-password', [AuthController::class, 'forget_password']);
    // Route::post('reset-password', [AuthController::class, 'reset_password']);
    // Route::post('languages', [CommonController::class, 'languages']);
    // Route::post('plans', [CommonController::class, 'plans']);

    // Protected routes
    Route::middleware('auth:api')->group(function () {
        Route::post('me', [AuthController::class, 'me']);
        Route::post('verify-otp', [AuthController::class, 'verify_otp']);
        Route::post('resend-otp', [AuthController::class, 'resend_otp']);
        Route::post('edit-profile', [AuthController::class, 'edit_profile']);
        Route::post('my-profile', [AuthController::class, 'my_profile']);
        Route::post('delete-profile', [AuthController::class, 'delete_profile']);
        Route::post('change-password', [AuthController::class, 'change_password']);
        Route::post('frames', [CommonController::class, 'frames']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
