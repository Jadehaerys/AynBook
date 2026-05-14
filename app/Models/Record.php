<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    // Fields that can be mass-assigned — everything except id and timestamps
    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address', 'notes'];

    /**
     * Each record is owned by one user.
     * If the user gets deleted, their records go too (cascade on delete in migration).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
