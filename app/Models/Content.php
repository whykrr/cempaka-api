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
        'created_by',
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
        'category_content',
        'creator',
        'created_at',
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
    public function created_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // GETTER METHOD
    // get category name
    public function getCategoryContentAttribute()
    {
        // check if category_id is null
        if ($this->category_id == null) {
            return null;
        }
        return [
            'id' => $this->category->id,
            'name' => $this->category->name,
        ];
    }

    // get creator
    public function getCreatorAttribute()
    {
        // check if created_by is null
        if ($this->created_by == null) {
            return null;
        }
        return $this->created_user->name;
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
