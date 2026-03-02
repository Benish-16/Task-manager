<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'created_by',
        'assigned_to',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}