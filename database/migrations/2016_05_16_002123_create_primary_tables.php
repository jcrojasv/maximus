<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrimaryTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creacion de la tabla alimentos
        Schema::create('alimentos', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->integer('id');
            $table->string('nombre',40);
            $table->integer('especie_id')->foreign('id')->on('especies')->onUpdate('cascade');
            $table->integer('correlativo')->unsigned();
            $table->timestamps();
        });

        //Creacion de la tabla arreglos
        Schema::create('arreglos', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->increments('id');
            $table->string('descripcion',120);
            $table->integer('padre');
            $table->enum('tipo',['GEN','ESP']);
            $table->timestamps();
        });

        //Creacion de la tabla colores
        Schema::create('colores', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->increments('id');
            $table->string('color',20);
            $table->timestamps('false');
        });

        //Creacion de la tabla especies
        Schema::create('especies', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->increments('id');
            $table->string('descripcion',20);
            $table->timestamps('false');
        });

        //Creacion de la tabla Razas
        Schema::create('razas', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->integer('id')->unsigned()->primary();
            $table->string('descripcion',20);
            $table->integer('especie_id')->foreign('id')->on('especies')->onUpdate('cascade');
            $table->integer('correlativo')->unsigned();
            $table->timestamps('false');
            $table->index('especie_id');
        });

        //Creacion de la tabla Mascotas
        Schema::create('mascotas', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->integer('id')->unsigned()->primary();
            $table->integer('propietario_id')->unsigned()->foreign('id')->on('propietarios')
            ->onUpdate('cascade');
            $table->string('nombre',60);
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('sexo',['F','M']);
            $table->integer('color_id')->foreign('id')->on('colores')->onUpdate('cascade');
            $table->integer('raza_id')->foreign('id')->on('razas')->onUpdate('cascade');
            $table->integer('alimento_id')->foreign('id')->on('alimentos')->onUpdate('cascade');
            $table->string('sena',120);
            $table->tinyInteger('peso')->nullable();
            $table->string('vacuna',15)->nullable();
            $table->string('desparasitacion',15)->nullable();
            $table->tinyInteger('correlativo');
            $table->timestamps();
            $table->index('propietario_id');
            $table->index('color_id');
            $table->index('alimento_id');
            
        });

        //Creacion de la tabla ordenes de trabajo
        Schema::create('ordenes', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->bigIncrements('id');
            $table->integer('mascota_id')->unsigned()->foreign('id')->on('mascotas')
            ->onUpdate('cascade');
            $table->date('fecha');
            $table->binary('firma')->nullable();
            $table->string('observaciones',250)->nullable();
            $table->time('entrada')->nullable();
            $table->time('salida')->nullable();
            $table->integer('creado_por')->foreign('id')->on('users')->onUpdate('cascade');
            $table->integer('modificado_por')->foreign('id')->on('users')->onUpdate('cascade');
            $table->timestamps();
            $table->index('mascota_id');
            $table->index('creado_por');
            $table->index('modificado_por');

        });

        //Creacion de la tabla orden_arreglos
        Schema::create('orden_arreglos', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->bigIncrements('id');
            $table->bigInteger('orden_id')->foreign('id')->on('ordenes')->onUpdate('cascade');
            $table->integer('arreglo_id')->foreign('id')->on('arreglos')->onUpdate('cascade');
            $table->index('orden_id');
            $table->index('arreglo_id');
        });

        //Creacion de la tabla propietarios
        Schema::create('propietarios', function(Blueprint $table){
            $table->engine = 'InnoDb';
            $table->integer('id')->unsigned()->primary();
            $table->string('nombres',25);
            $table->string('apellidos',25);
            $table->string('email',60)->unique()->nullable();
            $table->string('direccion',120)->nullable();
            $table->string('telefono_celular',12)->nullable();
            $table->string('telefono_fijo',12)->nullable();
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('alimentos');
        Schema::drop('arreglos');
        Schema::drop('especies');
        Schema::drop('colores');
        Schema::drop('razas');
        Schema::drop('orden_arreglos');
        Schema::drop('ordenes');
        Schema::drop('propietarios');
        Schema::drop('mascotas');

    }
}
