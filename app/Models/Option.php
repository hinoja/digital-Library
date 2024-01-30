<?php

namespace App\Models;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory;
    public $fillable=['name','department_id','description'];

    public function department()
    {
      return $this->belongsTo(Department::class);
    }
    public function user()
    {
      return $this->belongTo(User::class);
    }
}
