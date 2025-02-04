<?php

use App\Http\Controllers\Template\TemplateController;

Route::group(['prefix' => 'templates', 'as' => 'templates.'], function () {

    Route::get('/', [TemplateController::class, 'index'])->name('index')
        ->middleware(['role:admin', 'permission:templates.view']);
    Route::get('data', [TemplateController::class, 'listData'])->name('list_data')
        ->middleware(['role:admin', 'permission:templates.view']);
    Route::post('/', [TemplateController::class, 'store'])->name('store')
         ->middleware(['role:admin', 'permission:templates.add']);
    Route::get('{template}/duplicate', [TemplateController::class, 'duplicate'])->name('duplicate')
         ->middleware(['role:admin', 'permission:templates.add']);
    Route::get('{template}/edit', [TemplateController::class, 'edit'])->name('edit')
         ->middleware(['role:admin', 'permission:templates.edit']);
    Route::put('{template}/template-settings', [TemplateController::class, 'updateTemplateSettings'])
         ->name('update_template_settings')->middleware(['role:admin', 'permission:templates.edit']);
    Route::put('{template}/content-settings', [TemplateController::class, 'updateContentSettings'])
         ->name('update_content_settings')->middleware(['role:admin', 'permission:templates.edit']);
    Route::put('{template}/content', [TemplateController::class, 'updateContent'])
         ->name('update_content')->middleware(['role:admin', 'permission:templates.edit']);
    Route::get('{template}/preview', [TemplateController::class, 'preview'])
         ->name('preview')->middleware(['role:admin', 'permission:templates.view']);
    Route::put('{template}/deactivate', [TemplateController::class, 'deactivate'])
         ->name('deactivate')->middleware(['role:admin', 'permission:templates.delete']);
    Route::put('{template}/activate', [TemplateController::class, 'activate'])
         ->name('activate')->middleware(['role:admin', 'permission:templates.delete']);
    Route::delete('{template}', [TemplateController::class, 'delete'])->name('delete')
         ->middleware(['role:admin', 'permission:templates.delete']);
});
