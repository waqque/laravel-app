<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FeedbackController extends Controller
{
    /**
     * Directory path where submission JSON files are stored.
     */
    protected function getStorageDirectory(): string
    {
        $dir = storage_path('app/submissions');
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true, true);
        }
        return $dir;
    }

    /**
     * Display list of all submissions formatted as a table.
     */
    public function index()
    {
        $storageDir = $this->getStorageDirectory();
        $files = File::glob($storageDir . '/*.json') ?: [];

        $submissions = [];
        foreach ($files as $filePath) {
            $rawContent = File::get($filePath);
            $item = json_decode($rawContent, true);

            if (is_array($item)) {
                $item['_filename'] = basename($filePath);
                $item['_filesize'] = File::size($filePath);
                $submissions[] = $item;
            }
        }

        // Sort descending by created_at timestamp
        usort($submissions, function ($a, $b) {
            $timeA = isset($a['created_at']) ? strtotime($a['created_at']) : 0;
            $timeB = isset($b['created_at']) ? strtotime($b['created_at']) : 0;
            return $timeB <=> $timeA;
        });

        return view('pages.table', [
            'submissions' => $submissions,
            'totalCount' => count($submissions),
        ]);
    }

    /**
     * Display the feedback / submission form.
     */
    public function create()
    {
        return view('pages.form');
    }

    /**
     * Store submitted form data into a uniquely named JSON file.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'topic' => ['required', 'string', 'min:3', 'max:150'],
            'category' => ['required', 'string', 'in:Вопрос,Предложение,Отзыв,Техподдержка,Другое'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'name.min' => 'Имя должно содержать не менее 2 символов.',
            'name.max' => 'Имя не должно превышать 100 символов.',
            'email.required' => 'Поле "Email" обязательно для заполнения.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'topic.required' => 'Поле "Тема" обязательно для заполнения.',
            'topic.min' => 'Тема должна содержать не менее 3 символов.',
            'category.required' => 'Пожалуйста, выберите категорию обращения.',
            'category.in' => 'Выбрана некорректная категория.',
            'message.required' => 'Поле "Сообщение" обязательно для заполнения.',
            'message.min' => 'Сообщение должно содержать не менее 10 символов.',
            'message.max' => 'Сообщение не должно превышать 2000 символов.',
        ]);

        // Generate unique identifier and filename in controller
        $uniqueId = uniqid('sub_', true);
        $timestamp = now();
        $filename = 'submission_' . $timestamp->format('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.json';

        $data = [
            'id' => $uniqueId,
            'created_at' => $timestamp->format('Y-m-d H:i:s'),
            'name' => trim($validated['name']),
            'email' => trim($validated['email']),
            'topic' => trim($validated['topic']),
            'category' => $validated['category'],
            'message' => trim($validated['message']),
            'meta' => [
                'user_agent' => $request->userAgent() ?? 'N/A',
                'ip' => $request->ip() ?? '127.0.0.1',
            ],
        ];

        $storageDir = $this->getStorageDirectory();
        $filePath = $storageDir . DIRECTORY_SEPARATOR . $filename;

        File::put(
            $filePath,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );

        return redirect()
            ->route('feedback.create')
            ->with('success', 'Данные успешно сохранены в файл: ' . $filename)
            ->with('saved_file', $filename);
    }

    /**
     * Download or view individual JSON submission file.
     */
    public function download(string $filename): BinaryFileResponse
    {
        // Sanitize filename to prevent directory traversal
        $safeFilename = basename($filename);
        $filePath = $this->getStorageDirectory() . DIRECTORY_SEPARATOR . $safeFilename;

        if (!File::exists($filePath) || !str_ends_with($safeFilename, '.json')) {
            abort(404, 'Файл не найден');
        }

        return response()->download($filePath, $safeFilename, [
            'Content-Type' => 'application/json',
        ]);
    }
}
