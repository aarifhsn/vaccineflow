<?php

use Illuminate\Support\Facades\Route;
use App\Models\VaccineCenter;

Route::get('/vaccine-centers', function () {
    return VaccineCenter::all(['name']);
});
