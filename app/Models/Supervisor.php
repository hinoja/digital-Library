<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    use HasFactory;
    public $fillable=['name','description'];

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
