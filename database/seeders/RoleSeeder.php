<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Enums\RoleEnum;
use DB;
use Log;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            Role::firstOrCreate([
                'name' => RoleEnum::ADMINISTRATOR,
            ], [
                'name' => RoleEnum::ADMINISTRATOR,
                'guard_name' => 'web'
            ]);

            Role::firstOrCreate([
                'name' => RoleEnum::DOKTER,
            ], [
                'name' => RoleEnum::DOKTER,
                'guard_name' => 'web'
            ]);

            Role::firstOrCreate([
                'name' => RoleEnum::APOTEKER,
            ], [
                'name' => RoleEnum::APOTEKER,
                'guard_name' => 'web'
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::emergency($th->getMessage());
        }
    }
}
