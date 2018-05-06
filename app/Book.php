<?php

namespace App;

use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use Filterable;

    protected $fillable = [
        'user_id',
        'odlbook_id',
        'title',
        'author',
        'picture',
        'picture_thumb',
        'sinopse',
        'favorite',
        'listed',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('user_id', auth()->id());
        });
    }
}
