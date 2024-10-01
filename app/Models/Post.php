<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Hides model fields when we convert the model into the array.
    // protected $hidden = [
    //     'title'
    // ];

    // Laravel protects the model fields from mass assignment by default. This property enables mass assignment.
    protected $fillable = [
        'title',
        'body',
    ];

    // Guarded does the same as fillable.
    // protected $guarded = [
    //     'title'
    // ];

    protected $casts = [
        'body' => 'array'
    ];

    protected $appends = [
        'title_upper_case'
    ];

    // Accessor: used to read and transform values.
    public function getTitleUpperCaseAttribute()
    {
        return strtoupper($this->title);
    }

    // Mutator: used to transform values before storing them in a database.
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'post_user', 'post_id', 'user_id');
    }
}