<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['title','file', 'slug', 'description', 'image', 'published_at', 'category_id', 'is_active'];
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }
}
