<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    const TABLE_NAME = 'roles';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(self::TABLE_NAME)->delete();

        foreach (seed(self::TABLE_NAME) as $row)
            $records[] = [
                'id'         => $row->id,
                'created_at' => $row->created_at ?? Carbon::now(),
                'updated_at' => $row->updated_at ?? Carbon::now(),

                'slug'       => $row->slug ?? str_slug($row->name),
                'name'       => $row->name,
            ];

		insert(self::TABLE_NAME, $records ?? []);
    }
}
