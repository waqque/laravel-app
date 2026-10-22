<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MainController extends Controller
{
    // Главная страница
    public function index()
    {
        return view('home');
    }

    // Страница с формой (GET)
    public function form()
    {
        return view('form');
    }

    // Обработка формы (POST)
    public function store(Request $request)
    {
        // 1. Серверная валидация
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // 2. Уникальное имя файла
        $fileName = 'data_' . uniqid() . '.json';
        $dir = storage_path('app/data');

        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        // 3. Сохранение данных в формате JSON
        File::put($dir . '/' . $fileName, json_encode($validated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // 4. Сообщение об успешном сохранении
        return back()->with('success', 'Данные успешно сохранены в файл ' . $fileName);
    }

    // Страница с таблицей данных (GET)
    public function data()
    {
        $dir = storage_path('app/data');
        $files = File::isDirectory($dir) ? File::glob($dir . '/*.json') : [];
        $items = [];

        foreach ($files as $file) {
            $items[] = json_decode(File::get($file), true);
        }

        return view('data', ['items' => $items]);
    }
}
