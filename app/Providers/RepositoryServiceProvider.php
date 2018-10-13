<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\BipIncIncidenteRepository::class, \App\Repositories\BipIncIncidenteRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BipCoiCodigoIcRepository::class, \App\Repositories\BipCoiCodigoIcRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BipEmpEmpresaRepository::class, \App\Repositories\BipEmpEmpresaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BipGrsGrupoDesignadoRepository::class, \App\Repositories\BipGrsGrupoDesignadoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BipPriPrioridadeRepository::class, \App\Repositories\BipPriPrioridadeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\BipSumSumarioRepository::class, \App\Repositories\BipSumSumarioRepositoryEloquent::class);
        //:end-bindings:
    }
}
