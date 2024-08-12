<?php

namespace App\Models;

use App\Enums\TaskStatus;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'price',
        'service_category_id',
        'complete_at',
        'status',
        'moderator_id',
        'moderated_at',
    ];

    /**
     * @return string[]
     */
    public static function getStatuses() : array
    {
        return [
            TaskStatus::DRAFT->value => 'Черновик',
            TaskStatus::MODERATE->value => 'На модерации',
            TaskStatus::ACCEPT->value => 'Опубликована'
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this
            ->belongsToMany(Files::class, 'task_files', 'task_id', 'file_id')
            ->withPivot('side');
    }
}
