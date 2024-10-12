<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'classroom_id'
    ];
    public function passport()
    {
        return $this->hasOne(Passport::class);
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }
    public function classroom()
    {
        return $this->belongsTo(classroom::class);
    }

}
