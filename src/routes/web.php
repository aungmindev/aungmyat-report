<?php

use Aungmyat\Report\Http\Controllers\reportController;
use Illuminate\Support\Facades\Route;

// Route::group(['namespace' => 'Aungmyat\Report\Http\Controllers'],function (){
    Route::get('/report',[reportController::class,'index'])->name('report');
    Route::get('/sendmail',[reportController::class,'sendmail'])->name('sendmail');
// });
