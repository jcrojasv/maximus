<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Propietario::class, function (Faker\Generator $faker){

	return [
		'id'                 => $faker->unique()->numberBetween(1,50),
		'nombres'            => $faker->firstname,
		'apellidos'          => $faker->lastName,
		'email'              => $faker->unique()->safeEmail,
		'direccion'          => $faker->address,
		'telefono_fijo'      => $faker->phoneNumber,
		'telefono_celular'   => $faker->phoneNumber,
		'created_at'         => $faker->unixTime,
		'updated_at'         => null,

	];

});



$factory->define(App\Mascota::class, function (Faker\Generator $faker){

	$values = array();
	for ($i=1; $i < 51; $i++) {
  // get a random digit, but always a new one, to avoid duplicates
		$values []= $i;
	}
	return [
	    'id'                => $faker->unique()->numberBetween(1,100),
		'nombre'            => $faker->colorName,
		'propietario_id'    => $faker->unique()->randomElement($values),
		'fecha_nacimiento'  => $faker->date('Y-m-d', 'now'),
		'sexo'              => $faker->randomElement(array('F','M')),
		'color_id'          => $faker->randomElement(array(1,2,3,4)),
		'raza_id'           => $faker->randomElement(array(1001,1002,1003,1004,1005,1006)),
		'alimento_id'       => $faker->numberBetween(1,15),
		'sena'              => $faker->text(120),
		'peso'              => $faker->numberBetween(3,20),
		'vacuna'            => $faker->date('Y-m-d', 'now'),
		'desparasitacion'   => $faker->date('Y-m-d', 'now'),
		'correlativo'       => '1',
		'created_at'         => $faker->unixTime,
		'updated_at'         => null,
	];

});

$factory->define(App\Orden::class, function (Faker\Generator $faker){

	return [
		'mascota_id'        => $faker->numberBetween(1,100),
		'fecha'             => $faker->dateTimeBetween('-30 days', 'now'),
		'observaciones'     => $faker->text,

	];

});