<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $receiver_id
 */
class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'body',
        'attachment',
        'seen',
        'source_id',
        'source_type',
        'destination_id',
        'destination_type'
    ];


    public function conversation(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function receiver(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

}
