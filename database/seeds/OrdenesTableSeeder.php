<?php

use App\Orden;

use Illuminate\Database\Seeder;

class OrdenesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(Orden::class)->times(30)->create();

    }
}
