<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $appends = ['project_name'];
    protected $fillable = ['name','priority','timestamp','ip','project_id'];

    public function getProjectNameAttribute(){
        return $this->project?->title;
    }
    protected $casts = [
        'timestamp' => 'datetime',
    ];
    public function project(){
        return $this->belongsTo(Project::class);
    }
}
