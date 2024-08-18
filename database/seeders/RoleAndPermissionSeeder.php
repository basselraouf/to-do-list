<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        Permission::updateOrCreate(['name' => 'edit users']);
        Permission::updateOrCreate(['name' => 'delete users']);

        // Create roles and assign permissions
        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(['edit users', 'delete users']);

        $userRole = Role::updateOrCreate(['name' => 'user']);

        // Assign role to user
        $user = User::where('email', 'bassel.raouf50@gmail.com')->first(); // Assuming the user's email is correct
        if ($user) {
            $user->syncRoles('admin'); // Use syncRoles to ensure the user only has the 'admin' role
        }
    }
}
