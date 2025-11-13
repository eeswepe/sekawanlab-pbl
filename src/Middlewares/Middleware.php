<?php
namespace App\Middlewares;
interface Middleware
{
    public function handle(): bool;
}
