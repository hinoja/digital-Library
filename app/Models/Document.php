<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['type', 'user_id','level', 'authors', 'description', 'extension', 'title', 'file', 'option_id', 'slug', 'description', 'image', 'published_at', 'is_visible'];
  
  public function categories()
  {
    return $this->belongsToMany(Category::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function keywords()
  {
    return $this->belongsToMany(Keyword::class);
  }
}
