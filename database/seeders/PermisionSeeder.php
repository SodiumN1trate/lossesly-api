<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'manage.users']);
        Permission::create(['name' => 'manage.applications']);
        Permission::create(['name' => 'manage.user_jobs']);
        Permission::create(['name' => 'manage.job_cancel']);
        Permission::create(['name' => 'manage.support']);
        Permission::create(['name' => 'manage.specialities']);
        Permission::create(['name' => 'start.user_job']);
        Permission::create(['name' => 'end.user_job']);
        Permission::create(['name' => 'accept.user_job']);
        Permission::create(['name' => 'decline.user_job']);
        Permission::create(['name' => 'create.bill']);


        Role::create(['name' => 'Galvenais administrators'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'Administrators']);
        Role::create(['name' => 'Speciālists'])->givePermissionTo([
            'start.user_job',
            'end.user_job',
            'accept.user_job',
            'decline.user_job',
            'create.bill',
        ]);
        Role::create(['name' => 'Lietotājs']);
    }
}
