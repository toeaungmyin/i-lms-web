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
            'name' => 'student',
            'id_prefix' => 'MKPT',
            'is_active'=> '1'
        ]);

        Config::create([
            'name' => 'instructor',
            'id_prefix' => 'INS',
            'is_active' => '1'
        ]);

        $roles = ['admin', 'instructor', 'student'];
        foreach($roles as $role){
            Role::create(['name' => $role]);
        }
    }
}
