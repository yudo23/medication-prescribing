<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\RoleEnum;
use App\Models\User;
use DB;
use Log;

class UserSeeder extends Seeder
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
            $admin = User::firstOrCreate([
                'email' => "admin@gmail.com",
            ], [
                'name' => 'Administrator',
                'email' => "admin@gmail.com",
                "username" => "admin",
                'password' => bcrypt("123456789"),
            ]);

            $admin->assignRole([RoleEnum::ADMINISTRATOR]);

            $doctor = User::firstOrCreate([
                'email' => "andi@gmail.com",
            ], [
                'name' => 'Dr. Andi Pratama',
                'email' => "andi@gmail.com",
                "username" => "andi",
                'password' => bcrypt("123456789"),
            ]);

            $doctor->assignRole([RoleEnum::DOKTER]);

            $apoteker = User::firstOrCreate([
                'email' => "dewi@gmail.com",
            ], [
                'name' => 'Dewi Lestari',
                'email' => "dewi@gmail.com",
                "username" => "dewi",
                'password' => bcrypt("123456789"),
            ]);

            $apoteker->assignRole([RoleEnum::APOTEKER]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::emergency($th->getMessage());
        }
    }
}
