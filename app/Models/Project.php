<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'embed_url',
        'action_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
