<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static findOrFail($id)
 * @property mixed $user_id
 */
class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';
    const PRIORITIES = [
        'low',
        'medium',
        'high',
        'critical',

    ];
    const CATEGORIES= [
        'bug',
        'feature request',
        'General Inquiry',
        'critical'
    ];
    const STATUSES= [
        'new',
        'open',
        'pending',
        'resolved'
    ];
    protected $fillable = [
        'title',
        'description',
        'priority',
        'category',
        'status',
        'user_id'
    ];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value;
    }

    public function setPriorityAttribute($value)
    {
        $this->attributes['priority'] = $value;
    }

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = $value;
    }
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

 }
