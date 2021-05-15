<?php

namespace App\Providers;

use App\Models\Campaign;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DirectiveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('challenge', function($name) {
            return "<?php \$challenge = App::make('App\Classes\Challenger')->register('{$name}'); ?>";
        });

        Blade::directive('variant', function($params) {
            list($name, $ratio) = explode(',', str_replace(' ', '', $params));

            return "<?php \$challenge->variant('{$name}', {$ratio}); ?>";
        });

        Blade::directive('endvariant', function() {
            return "<?php \$challenge->endVariant(); ?>";
        });

        Blade::directive('endchallenge', function() {
            return "<?php echo \$challenge->show(); ?>";
        });

        Blade::directive('goal', function($goal) {
            return "<?php App::make('App\Classes\Challenger')->goal('{$goal}'); ?>";
        });

    }
}
