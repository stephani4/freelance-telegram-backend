<?php

namespace App\Http\Services\Telegram;

use App\Enums\FolderType;
use App\Enums\TaskStatus;
use App\Models\Files;

class FileService
{
    private Files $files;

    public function __construct(Files $files)
    {
        $this->files = $files;
    }

    /**
     * @param array $fillable
     * @return int
     */
    public function create(array $fillable) : Files
    {
        $fillable = array_merge(
            ['folder' => FolderType::TEMP->value],
            $fillable
        );

        $this->files->fill($fillable);
        $this->files->save();

        return $this->files;
    }
}
