<?php

namespace App\Console\Commands\Tenant;

use App\Models\Company;
use App\Tenant\ManagerTenant;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;

class TenantMigrations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrate {id?} {--refresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Tenants Migrations';

    private ManagerTenant $manager_tenant;

    public function __construct(ManagerTenant $manager_tenant)
    {
        parent::__construct();
        $this->manager_tenant = $manager_tenant;
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($company_id = $this->argument('id')) {
            $this->runMigrations($this->getCompanyById($company_id));

            return;
        }

        $companies = $this->getCompanies();

        foreach ($companies as $company) {
            /**@var Company $company*/
            $this->runMigrations($company);
        }
    }

    private function getCompanies(): Collection
    {
        return Company::query()->get();
    }

    private function getCompanyById(int $id): ?Company
    {
        /**@var Company*/
        return Company::query()->find($id);
    }

    private function runMigrations(Company $company): void
    {
        $command = $this->option('refresh') ? 'migrate:refresh' : 'migrate';

        $this->manager_tenant->setConnection($company);

        $this->info("Connecting Company {$company->name}");

        Artisan::call($command, [
            '--force' => true,
            '--path' => 'database/migrations/tenants'
        ]);

        $this->info("End Connecting Company {$company->name}");

        $this->info('---------------');
    }
}
