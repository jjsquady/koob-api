<?php
/**
 * Created by PhpStorm.
 * User: jjsquady
 * Date: 5/6/18
 * Time: 6:20 AM
 */

namespace App\Observers;


class BookObserver
{
    public function creating($book)
    {
        $book->user_id = auth()->id();
    }
}