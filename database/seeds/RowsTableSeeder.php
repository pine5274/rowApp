<?php

use Illuminate\Database\Seeder;

class RowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rows')->insert([
            [
                'user_id' => 1,
                'date_time'    => '2020-11-11',
                'boat_name' => '白鳳',
                'on_the_water' => '06:30:00',
                'off_the_water' => '08:30:00',
                'lower_limit_area' => '1000G',
                'upper_limit_area' => '新橋',
            ]
        ]);
        DB::table('rows')->insert([
            [
                'user_id' => 2,
                'date_time'    => '2020-11-11',
                'boat_name' => '蜻蛉',
                'on_the_water' => '06:20:00',
                'off_the_water' => '08:40:00',
                'lower_limit_area' => '1000G',
                'upper_limit_area' => '仁和寺',
            ]
        ]);
        DB::table('rows')->insert([
            [
                'user_id' => 3,
                'date_time'    => '2020-11-11',
                'boat_name' => '雷神',
                'on_the_water' => '06:30:00',
                'off_the_water' => '08:40:00',
                'lower_limit_area' => '1000G',
                'upper_limit_area' => '新橋',
            ]
        ]);
        DB::table('rows')->insert([
            [
                'user_id' => 4,
                'date_time'    => '2020-11-11',
                'boat_name' => 'ibis',
                'on_the_water' => '06:00:00',
                'off_the_water' => '08:50:00',
                'lower_limit_area' => '1000G',
                'upper_limit_area' => '新橋',
            ]
        ]);
        DB::table('rows')->insert([
            [
                'user_id' => 5,
                'date_time'    => '2020-11-11',
                'boat_name' => '蓮華',
                'on_the_water' => '07:00:00',
                'off_the_water' => '08:00:00',
                'lower_limit_area' => '1000G',
                'upper_limit_area' => '新橋',
            ]
        ]);
    }
}
