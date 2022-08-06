<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

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

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    // protected $dateFormat = 'U';


    /**
     * set return component
     */
    public function getComponentAttribute()
    {
        if (!empty($this->attributes['component'])) {
            return json_decode($this->attributes['component'], true);
        }
    }
}
