<?php

use Illuminate\Support\Facades\DB;

function areActiveRoutes(array $routes, $output = "active")
{
    foreach ($routes as $route) {
        if (Route::currentRouteName() == $route) return $output;
    }
}
