<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'assigned_to',
        'due_date',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function dependencies()
    {
        return $this->belongsToMany(Task::class,'task_dependencies','task_id','depends_on_task_id')->withTimestamps();
    }
    public function dependents()
    {
        return $this->belongsToMany(Task::class,'task_dependencies','depends_on_task_id','task_id')->withTimestamps();
    }

}

