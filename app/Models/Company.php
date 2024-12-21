<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function scopeFilterByIlikeName(Builder $query, ?string $name): void
    {
        $query->when($name, function ($query) use ($name) {
            $query->orWhere('name', 'ILIKE', '%'.$name.'%');
        });
    }
}
