<?php
/**
 * Created by PhpStorm.
 * User: jjsquady
 * Date: 5/6/18
 * Time: 7:26 AM
 */

namespace App\Filters;

class BookFilters extends QueryFilters
{
    public function status($value = null)
    {
        if(!$value) {
            return null;
        }

        return $this->builder->where('status', $value);
    }

    public function search($value = null)
    {
        if(!$value) {
            return null;
        }

        return $this->builder->where('title', 'LIKE', "%{$value}%")
            ->orWhere('author', 'LIKE', "%{$value}%");
    }
}