<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Show the application home page.
     */
    public function index()
    {
        $storageDir = storage_path('app/submissions');
        $submissionsCount = File::isDirectory($storageDir)
            ? count(File::glob($storageDir . '/*.json'))
            : 0;

        return view('pages.home', [
            'submissionsCount' => $submissionsCount,
        ]);
    }
}
