<?php
use App\User;
use App\Product;
use App\Category;
use App\Transactio;
use App\Seller;

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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?:$password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verificado = $faker->randomElement([User::USUARIO_VERIFICADO, User::USUARIO_NO_VERIFICADO]),
        'verification_token' => $verificado == User::USUARIO_VERIFICADO? null:  User::generarVerificationToken(),
        'admin' => $faker->randomElement([User::USUARIO_ADMINISTRADOR, User::USUARIO_REGULAR]),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {


    return [
        'name' => $faker->word,
        'description' => $faker->unique()->paragraph(1),
    ];
});

$factory->define(App\Product::class, function (Faker\Generator $faker) {


    return [
        'name' => $faker->word,
        'description' => $faker->unique()->paragraph(1),
        'quantity' => $faker->numberBetween(1,10),
        'status' => $faker->randomElement([Product::PRODUCTO_DISPONIBLE, Product::PRODUCTO_NO_DISPONIBLE]),
        'image' => $faker->randomElement(['1.jpg','2.jpg','3.jpg',]),
        'seller_id' => User::all()->random()->id,
    ];
});

$factory->define(App\Transactio::class, function (Faker\Generator $faker) {
    $vendedor = Seller::has('products')->get()->random();
    $comprador = User::all()->except($vendedor->id)->random();
    return [
      
        'quantity' => $faker->numberBetween(1,3),
        'buyer_id' => $comprador->id ,
        'product_id' => $vendedor->products->random()->id,
    ];
});



