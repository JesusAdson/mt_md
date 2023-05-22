<?php

namespace App\Listeners\Tenant;

use App\Events\Tenant\CreatedCompany;
use App\Events\Tenant\CreatedDatabase;
use App\Tenant\Database\DatabaseManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCompanyDatabase
{
    private DatabaseManager $database_manager;

    /**
     * Create the event listener.
     */
    public function __construct(DatabaseManager $database_manager)
    {
        $this->database_manager = $database_manager;
    }

    /**
     * Handle the event.
     * @throws \Exception
     */
    public function handle(CreatedCompany $event): void
    {
        $company = $event->getCompany();

        if (!$this->database_manager->createDatabase($company)) {
            throw new \Exception('Error creating database');
        }

        event(new CreatedDatabase($company));
    }
}
