<?php

use App\Propietario;

use Illuminate\Database\Seeder;

class PropietariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Propietario::class)->times(50)->create();
    }
}
