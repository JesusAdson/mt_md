<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\CreatedDatabase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class RunMigrationsTenant
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreatedDatabase $event): void
    {
        Artisan::call('tenants:migrate', [
            'id' => $event->getCompany()->id
        ]);
    }
}
