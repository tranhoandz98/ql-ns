<?php

namespace App\Providers;

use App\Models\DayOffs;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Departments;
use App\Models\KPI;
use App\Models\Position;
use App\Models\Overtimes;
use App\Models\Roles;
use App\Models\Salary;
use App\Models\Timekeeping;
use App\Policies\DayOffPolicy;
use App\Policies\UserPolicy;
use App\Policies\RolePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\KPIPolicy;
use App\Policies\PositionPolicy;
use App\Policies\OvertimePolicy;
use App\Policies\SalaryPolicy;
use App\Policies\TimekeepingPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Roles::class, RolePolicy::class);
        Gate::policy(Departments::class, DepartmentPolicy::class);
        Gate::policy(Position::class, PositionPolicy::class);
        Gate::policy(Overtimes::class, OvertimePolicy::class);
        Gate::policy(Timekeeping::class, TimekeepingPolicy::class);
        Gate::policy(DayOffs::class, DayOffPolicy::class);
        Gate::policy(KPI::class, KPIPolicy::class);
        Gate::policy(Salary::class, SalaryPolicy::class);
    }
}
