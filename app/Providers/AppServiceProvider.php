<?php

namespace App\Providers;

use App\Classes\MunicipalFeeTaxCalculator;
use App\Classes\VatTaxCalculator;
use App\Services\TaxService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaxService::class, function () {
            return new TaxService([
                new VatTaxCalculator(),
                new MunicipalFeeTaxCalculator(),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        app()->bind(
            \App\Repositories\Contracts\ContractRepositoryInterface::class,
            \App\Repositories\Contracts\EloquentContractRepository::class
        );
        app()->bind(
            \App\Repositories\Invoices\InvoiceRepositoryInterface::class,
            \App\Repositories\Invoices\EloquentInvoiceRepository::class
        );
        app()->bind(
            \App\Repositories\Payments\PaymentRepositoryInterface::class,
            \App\Repositories\Payments\EloquentPaymentRepository::class
        );
    }
}
