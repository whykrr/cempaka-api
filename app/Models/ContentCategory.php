<?php

namespace App\Models;

use App\Casts\Json;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentCategory extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'content_categories';

    /**
     * Fillable fields
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'component',
        'is_active',
        'is_display',
    ];

    // casting attribute
    protected $casts = [
        'is_active' => 'boolean',
        'is_display' => 'boolean',
        'component' => Json::class
    ];

    // METHOD SETTER
    // set name
    public function setNameAttribute($value)
    {
        $slugify = new Slugify();
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $slugify->slugify($value);
    }
}
