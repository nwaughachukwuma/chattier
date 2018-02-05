<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        EloquentBuilder::macro('cursorPaginate', function ($limit, $cursor, $order = 'asc') {
            return $this
                ->lampager()
                ->limit($limit)
                ->orderBy('id', $order)
                ->seekable()
                ->paginate($cursor);
        });
    }

    public function register()
    {
        //
    }
}
