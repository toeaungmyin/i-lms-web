<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Config::create([
            'name' => 'default',
            'id_prefix' => 'MKPT',
            'is_active'=> '1'
        ]);

        $roles = ['admin', 'instructor', 'student'];
        foreach($roles as $role){
            Role::create(['name' => $role]);
        }
    }
}
