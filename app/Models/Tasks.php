<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tags(){
        return $this->hasMany(Tags::class, "task_id", "id");
    }
    public function list(){
        return $this->belongsTo(Lists::class,"list_id","id");
    }
}
