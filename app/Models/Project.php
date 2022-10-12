<?php

namespace App\Models;

use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $with = ['client'];
    protected $appends = ['client_detail'];
    protected $visible = [
        'id',
        'client_detail',
        'name',
        'description',
        'embed_url',
        'action_date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    // GETTER METHOD
    // get client
    public function getClientDetailAttribute()
    {
        // check if category_id is null
        if ($this->client_id == null) {
            return null;
        }
        return [
            'id' => $this->client->id,
            'name' => $this->client->name,
        ];
    }
}
