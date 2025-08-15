<?php

use Illuminate\Support\Facades\Route;

Route::get('admin/lang/{locale}', function (string $locale) {
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
})->name('admin.locale.switch');
