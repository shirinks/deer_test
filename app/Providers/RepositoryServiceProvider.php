<?php

namespace App\Providers;
use App\Contracts\OrderContract;
use App\Repositories\OrderRepository;

class RouteServiceProvider extends ServiceProvider
{
    protected $repositories = [
        OrderContract::class            =>          OrderRepository::class,
    ];
}