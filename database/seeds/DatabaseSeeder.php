<?php

use Illuminate\Database\Seeder;
use App\Models\Users\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Import locations
        $files = ['countries.sql', 'states.sql', 'cities.sql'];

        foreach ($files as $file) {
            $sql = file_get_contents(database_path('seeds/dumps/' . $file));
            $statements = array_filter(array_map('trim', explode(';', $sql)));

            foreach ($statements as $stmt) {
                DB::statement($stmt);
            }
        }

        $permissions = config('protecms.users.permissions');

        foreach ($permissions as $permission) {
            Permission::create([
                'permission' => $permission
            ]);
        }
    }
}
