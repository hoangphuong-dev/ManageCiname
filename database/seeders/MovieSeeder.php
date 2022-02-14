<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = \Faker\Factory::create();

        // $users = User::where('role', 1)->pluck('id')->toArray();
        // $users_caretaker = User::where('role', 2)->pluck('id')->toArray();
        // $province_ids = Province::all()->pluck('id')->toArray();
        // $hospital_department_ids = HospitalDepartment::all()->pluck('id')->toArray();
        // for ($i = 0; $i < 100; $i++) {
        //     $province_id = $province_ids[array_rand($province_ids)];
        //     $city_id = City::where('province_id', $province_id)->get()->random()->id;
        //     $job = Job::create([
        //         'address' => $faker->address,
        //         'user_id' => $users[array_rand($users)],
        //         'name' => $faker->name,
        //         'hospital_name' => $faker->name,
        //         'province_id' => $province_id,
        //         'city_id' => $city_id,
        //         'hospital_department_id' => $hospital_department_ids[array_rand($hospital_department_ids)],
        //         'description' => $faker->text,
        //         'wage_min' => 10,
        //         'wage_max' => 20,
        //         'annual_income_min' => 1000,
        //         'annual_income_max' => 2000,
        //         'type_of_work' => array_rand([0, 1]),
        //         'working_hours' => (['日勤', '深夜', 'パート']),
        //         'holidays' => (['5', '6', '7']),
        //         'number_annual_holidays' => 12,
        //         'status' => array_rand([0, 1, 2, 3]),
        //     ]);
        //     $job_id = $job->id;
        //     clone ($job)->images()->createMany([
        //         [
        //             'name' => 'Screenshot from 2021-12-10 10-04-21.png',
        //             'path' => 'jobs/kWh2Xvr4Hggft97YN8NKItXNtQ3pgxgHyE6TQUkW.png'
        //         ],
        //         [
        //             'name' => 'Screenshot from 2021-12-10 10-04-21.png',
        //             'path' => 'jobs/kWh2Xvr4Hggft97YN8NKItXNtQ3pgxgHyE6TQUkW.png'
        //         ],
        //         [
        //             'name' => 'Screenshot from 2021-12-10 10-04-21.png',
        //             'path' => 'jobs/kWh2Xvr4Hggft97YN8NKItXNtQ3pgxgHyE6TQUkW.png'
        //         ],
        //         [
        //             'name' => 'Screenshot from 2021-12-10 10-04-21.png',
        //             'path' => 'jobs/kWh2Xvr4Hggft97YN8NKItXNtQ3pgxgHyE6TQUkW.png'
        //         ],
        //         [
        //             'name' => 'Screenshot from 2021-12-10 10-04-21.png',
        //             'path' => 'jobs/kWh2Xvr4Hggft97YN8NKItXNtQ3pgxgHyE6TQUkW.png'
        //         ]
        //     ]);
        //     $job->processes()->createMany([
        //         [
        //             'content' => $faker->name,
        //             'order' => 1
        //         ],
        //         [
        //             'content' => $faker->name,
        //             'order' => 2
        //         ],
        //         [
        //             'content' => $faker->name,
        //             'order' => 3
        //         ],
        //     ]);

        //     JobFavorite::create([
        //         'user_id' => $users_caretaker[array_rand($users_caretaker)],
        //         'job_id' => $job_id
        //     ]);
        // }
    }
}
