<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/*
* Adapted from Adam Wathan's method: 
* https://adamwathan.me/2016/04/06/cleaning-up-form-input-with-transpose/
*
* Improved with renamed keys and blank input filtering
*/

class CollectionExtensions extends ServiceProvider
{
    public function boot()
    {
        \Illuminate\Support\Collection::macro('transpose', function () {
            $items = array_map(function (...$items) {
                if( array_filter($items) ){
                    return array_combine( $this->keys()->toArray() , $items);
                }
            }, ...$this->values() );
            return new static( array_filter( $items ) );
        });

    }

    public function register()
    {
        // ...
    }
}