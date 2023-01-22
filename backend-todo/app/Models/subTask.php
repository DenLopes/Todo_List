<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subTask extends Model {
    public function task() {
        return $this->belongsTo(Task::class);
    }
    protected $fillable = [
        'task_name',
        'state',
        'id'
    ];
}
