<?php

namespace App\Observers;

use App\Models\Goods;
use App\Models\GoodsSkus;
use App\Models\Picture;

class PictureObserver
{
    /**
     * Handle the picture "created" event.
     *
     * @param  \App\Picture  $picture
     * @return void
     */
    public function created(Picture $picture)
    {

    }

    /**
     * Handle the picture "updated" event.
     *
     * @param  \App\Picture  $picture
     * @return void
     */
    public function updated(Picture $picture)
    {
        //
    }

    /**
     * Handle the picture "deleted" event.
     *
     * @param  \App\Picture  $picture
     * @return void
     */
    public function deleted(Picture $picture)
    {
        //
    }

    /**
     * Handle the picture "restored" event.
     *
     * @param  \App\Picture  $picture
     * @return void
     */
    public function restored(Picture $picture)
    {
        //
    }

    /**
     * Handle the picture "force deleted" event.
     *
     * @param  \App\Picture  $picture
     * @return void
     */
    public function forceDeleted(Picture $picture)
    {
        //
    }
}
