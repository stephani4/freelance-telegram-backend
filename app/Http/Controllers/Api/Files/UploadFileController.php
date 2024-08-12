<?php

namespace App\Http\Controllers\Api\Files;

use App\Http\Controllers\Controller;
use App\Http\Services\Telegram\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function upload(Request $request)
    {
        $data = $request->validate(['files' => 'required|file|mimetypes:image/jpeg,image/png,application/pdf,application']);

        if (!$request->hasFile('files')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Параметр "file" не соответсвует типа файла'
            ], 403);
        }

        $file = $request->file('files');
         Storage::disk('local')->put(
            $path = md5(microtime()) . '_' . $file->getClientOriginalName(),
            $file->getContent()
        );

        $resource = $this->fileService->create([
            'name'     => $file->getBasename(),
            'size'     => $file->getSize(),
            'path'     => $path,
            'mimetype' => $file->getMimeType(),
            'format'   => $file->getClientOriginalExtension()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Файл`ы успешно загружен`ы;',
            'payload' => [
                'files' => $resource,
                'path' => $path
            ]
        ]);
    }
}
