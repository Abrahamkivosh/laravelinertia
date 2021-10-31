<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ["name","completed","completed_at","user_id"] ;

    /**
     * Get the user that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function booted()
    {
        static::created(function($task){
            Cache::forget('tasks');
        });
    }

 
}
