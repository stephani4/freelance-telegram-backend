<?php

namespace App\Models;

use App\Enums\FolderType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'path',
        'mimetype',
        'folder',
        'format'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'task_files', 'file_id', 'task_id');
    }

    /**
     * Меняет папку файла в указанную папку
     *
     * @param Files $file
     * @param string $folder
     * @return void
     */
    public static function movedToFolder(Files $file, string $folder): void
    {
        $file->folder = $folder;
        $file->save();
    }
}
