<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Storage fallback (شبكة أمان)
|--------------------------------------------------------------------------
| المفروض `php artisan storage:link` يعمل symlink حقيقي من public/storage
| لـ storage/app/public، وده الوضع الطبيعي. لكن ملفات الـ zip بتاعة النشر
| مش دايمًا بتحافظ على الـ symlink (بيتحول لمجلد فاضي عادي بعد فك الضغط)،
| وده اللي كان بيسبب 404 على كل صور الهيرو والصور المرفوعة رغم إنها موجودة
| فعليًا في storage/app/public. الراوت ده بيشتغل بس لو الملف مش موجود
| فعليًا تحت public/storage (يعني السيرفر مش لاقيه كملف ثابت)، فمش بيأثر
| على الأداء في الوضع الطبيعي (symlink شغال) لأن السيرفر ساعتها بيقدم
| الملف الثابت مباشرة من غير ما يوصل لارافيل أصلًا.
*/
Route::get('/storage/{path}', function (string $path) {
    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('storage.fallback');
