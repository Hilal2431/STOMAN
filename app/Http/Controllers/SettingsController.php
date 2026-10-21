<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('pages.settings', [
            'topbarTitle' => __('stoman.settings.title'),
            'breadcrumbs' => [],
            'fileTypeUsage' => collect(),
        ]);
    }
}
