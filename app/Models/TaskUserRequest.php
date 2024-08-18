<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskUserRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'comment',
        'prevent_price',
        'view',
        'selected',
    ];

    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
