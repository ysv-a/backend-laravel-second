<?php

namespace App\Listeners;

use App\Events\BookCreated;

use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotifyAfterCreateBook
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BookCreated  $event
     * @return void
     */
    public function handle(BookCreated $event): void
    {
        $book_id = $event->book_id;

        Log::info('Book created ' . $book_id);
    }

}
