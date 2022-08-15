<?php

namespace App\Models;

use App\Casts\Json;
use Cocur\Slugify\Slugify;
use App\Models\ContentCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Content extends Model
{
    use HasFactory;

    /**
     * Table name
     */
    protected $table = 'contents';
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'image',
        'tags',
        'is_active',
    ];
    protected $with = ['category'];
    protected $appends = ['category_content'];
    protected $visible = [
        'id',
        'title',
        'slug',
        'content',
        'image',
        'tags',
        'is_active',
        'category_content'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'content' => Json::class
    ];

    // belongsto content category
    public function category()
    {
        return $this->belongsTo(ContentCategory::class, 'category_id');
    }

    // GETTER METHOD
    // get category name
    public function getCategoryContentAttribute()
    {
        return [
            'id' => $this->category->id,
            'name' => $this->category->name,
        ];
    }

    // SETTER METHOD
    // set slug
    public function setTitleAttribute($value)
    {
        $slugify = new Slugify();
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $slugify->slugify($value);
    }
}
