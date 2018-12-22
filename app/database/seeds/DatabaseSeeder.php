<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create project status
        DB::table('project_status')->insert([
          ['id' => 1, 'status' => 'New'],
          ['id' => 2, 'status' => 'Quoted'],
          ['id' => 3, 'status' => 'Sold'],
          ['id' => 4, 'status' => 'Engineered'],
          ['id' => 5, 'status' => 'Lost']
        ]);

        $this->call(UsersTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
    }
}
