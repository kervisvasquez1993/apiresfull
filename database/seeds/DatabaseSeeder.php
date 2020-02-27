<?php
use App\User;
use App\Product;
use App\Transactio;
use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transactio::truncate();
        DB::table('category_product')->truncate();

        $cantidadUsuarios = 200;
        $cantidadCategorias = 30;
        $cantidadProductos = 1000;
        $cantidadTransacciones = 1000;
        factory(User::class, $cantidadUsuarios)->create();
        factory(Category::class, $cantidadCategorias)->create();
        factory(Product::class,  $cantidadTransacciones)->create()->each(
            function ($producto){
                    $categorias = Category::all()->random(mt_rand(1,5))->pluck('id');
                    $producto->categories()->attach($categorias);
            }
        );
        factory(Transactio::class, $cantidadTransacciones)->create();


    }
}
