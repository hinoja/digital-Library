<?php

namespace App\Models;

use App\Models\User;
use App\Models\Option;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    public $fillable=['name','description'];

    public function options()
    {
      return $this->hasMany(Option::class);
    }
    public function user()
    {
      return $this->belongTo(User::class);
    }
}
