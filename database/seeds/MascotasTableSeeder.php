<?php

use App\Mascota;
use Illuminate\Database\Seeder;

class MascotasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Mascota::class)->times(50)->create();
    }
}
