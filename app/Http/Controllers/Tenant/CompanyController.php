<?php

namespace App\Http\Controllers\Tenant;

use App\Events\Tenant\CreatedCompany;
use App\Events\Tenant\CreatedDatabase;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    private Company $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }


    public function store(Request $request)
    {
        /**@var Company $company*/
        $company = $this->company->newQuery()->create([
            'name' => 'Empresa X' . Str::random(5),
            'domain' => Str::random(5) . 'minhaempresa.com',
            'db_database' => 'mt_db_' . Str::random(3),
            'db_hostname' => '127.0.0.1',
            'db_username' => 'root',
            'db_password' => 'root',
        ]);

        if (true)
            // caso for trabalhar com banco de dados dentro do msm host
            event(new CreatedCompany($company));
        else
            // caso for trabalhr com banco de dados dentro de um host diferente,
            // melhor é criar um banco de dados lá do que criar pelo sistema (muito trabalho)
            event(new CreatedDatabase($company));
        dd($company);
    }
}
