<?php

namespace App\Models;

use App\Models\User;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keyword extends Model
{
    use HasFactory,SoftDeletes;
    
    public $fillable = ['name', 'description'];

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
    public function user()
    {
        return $this->belongTo(User::class);
    }
}
