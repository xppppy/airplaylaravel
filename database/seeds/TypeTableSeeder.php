<?php

use Illuminate\Database\Seeder;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);
        $type = ['电视剧','电影','综艺','音乐','动漫','文艺'];
        $remarks = $faker->sentence();
        foreach ($type as $velue){
            DB::table('type')->insert([
                'type' =>$velue,
                'remarks' => $remarks
            ]);
        }
    }
}
