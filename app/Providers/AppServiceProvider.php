<?php

namespace Alyya\Providers;

use Alyya\Models\Site\Category;
use Illuminate\Support\Facades\Blade;
use Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('datetime', function($expression) {
            return "<?php echo with{$expression}->format('m/d/Y H:i'); ?>";
        });
        $categoriesLevel_1 = Category::whereNull('parent')->get();
        view()->share('categories', $categoriesLevel_1);
        $bestseller = Category::whereNull('parent')->get();
        $bestseller = Category::find(1)->products->first();
        view()->share('bestseller', $bestseller);
 /*       Blade::directive('categories', function() {
            $categoriesLevel_1 = Category::whereNull('parent')->get();
            dd($categoriesLevel_1);
            echo "<?php dd(time()) ; ?>";
            //return view('front.menu_categories',['categoriesLevel_1' => $categoriesLevel_1]);
//            if(Cache::has('categories')){
//                return Cache::get('categories');
//            }else{
//                $categoriesLevel_1 = Category::whereNull('parent')->get();
//                $view = view('front.menu_categories',['categoriesLevel_1' => $categoriesLevel_1]);
//                Cache::put('categories',$view,2);
//                return $view ;
//            }

        });*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
