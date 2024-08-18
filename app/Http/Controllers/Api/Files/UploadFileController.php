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
    public function upload(Request $request): mixed
    {
        $file = $request->file('files');
        $file = is_array($file)? $file : [$file];

        $resources = [];
        foreach ($file as $singleFile) {
            Storage::disk('local')->put(
                $path = md5(microtime()) . '_' . $singleFile->getClientOriginalName(),
                $singleFile->getContent()
            );

            $resources[] = $this->fileService->create([
                'name'     => $singleFile->getBasename(),
                'size'     => $singleFile->getSize(),
                'path'     => $path,
                'mimetype' => $singleFile->getMimeType(),
                'format'   => $singleFile->getClientOriginalExtension()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Файл`ы успешно загружен`ы;',
            'payload' => [
                'files' => $resources,
            ]
        ]);
    }
}
