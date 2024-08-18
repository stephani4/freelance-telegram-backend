<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::prefix('telegram')->group(function () {
        // Получение пользователя по телеграм-идентификатору и выдача токенов для авторизации
        Route::post('check', [\App\Http\Controllers\Api\Auth\Telegram\CheckLoginController::class, 'index']);
        Route::post('refresh', [\App\Http\Controllers\Api\Auth\Telegram\RefreshTokenController::class, 'index']);
        Route::post('register', [\App\Http\Controllers\Api\Auth\Telegram\RegisterProfileController::class, 'register']);
    });
});

Route::prefix('roles')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\Roles\LoadRolesController::class, 'load']);
});

Route::prefix('telegram')->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('{telegram}', [\App\Http\Controllers\Api\Users\Telegram\UsersController::class, 'findByTelegramId']);
    });

    Route::prefix('notifications')->group(function () {
        Route::get('current', [\App\Http\Controllers\Api\Notifications\LoadNotificationsController::class, 'current'])
            ->middleware('auth:api');
    });

    Route::prefix('task-statuses')->group(function () {
        Route::get('/', [\App\Http\Controllers\Api\TaskStatuses\TaskStatusesController::class, 'all']);
    });

    Route::prefix('profile')->group(function () {
        Route::post('update', [\App\Http\Controllers\Api\Profile\UpdateProfileController::class, 'update'])
            ->middleware('auth:api');
    });

    Route::prefix('tasks')->group(function () {
        Route::get('home', [\App\Http\Controllers\Api\Tasks\TasksListController::class, 'index']);
        Route::post('create', [\App\Http\Controllers\Api\Tasks\CreateTaskController::class, 'create']);

        Route::prefix('my')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Tasks\MyTasksController::class, 'my']);
            Route::get('{id}', [\App\Http\Controllers\Api\Tasks\MyTasksController::class, 'show']);
        });

        // Задачи, которые доступны для выполнения
        Route::get('actives', [\App\Http\Controllers\Api\Tasks\ActiveTasksController::class, 'index']);
    });

    Route::prefix('service-categories')->group(function () {
        Route::get('{id}/children', [\App\Http\Controllers\Api\Admin\Telegram\ServiceCategory\ServiceCategoryListController::class, 'children']);
    });

    Route::prefix('files')->group(function () {
        Route::post('upload', [\App\Http\Controllers\Api\Files\UploadFileController::class, 'upload']);
    });

    Route::prefix('admin')->group(function () {
        Route::prefix('tasks')->group(function () {
            Route::get('moderates', [\App\Http\Controllers\Api\Admin\Telegram\Tasks\ModerateTasksController::class, 'moderates']);

            Route::prefix('/{id}')->group(function () {
                Route::post('/status', [\App\Http\Controllers\Api\Admin\Telegram\Tasks\ChangeStatusTaskController::class, 'change']);
            });
        });
    });
});

Route::prefix('cash-cards')->group(function () {
    Route::get('my', [\App\Http\Controllers\Api\CashCards\CashCardsController::class, 'my']);
})->middleware('auth:api');

Route::prefix('admin')->group(function () {
    Route::prefix('telegram')->group(function () {
        Route::prefix('service-categories')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Admin\Telegram\ServiceCategory\ServiceCategoryListController::class, 'list']);
            Route::post('create', [\App\Http\Controllers\Api\Admin\Telegram\ServiceCategory\ServiceCategoryListController::class, 'create']);
        });

        Route::prefix('users')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Admin\Telegram\Users\LoadUsersController::class, 'load']);
        });
    });

    Route::prefix('users')->group(function () {
        Route::prefix('roles')->group(function () {
            Route::put('sync', [\App\Http\Controllers\Api\Admin\Roles\UpdateUsersRolesController::class, 'index']);
        });
    });
});
