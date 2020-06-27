<?php


namespace App\Providers;

use App\Components\Blade\Blade;

class CustomDirectiveProvider implements ProviderInterface
{
    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function boot(): void
    {
        Blade::directive('name', static function ($find) {
            return '<?php echo  strtoupper('.$find[1].') ; ?>';
        });
    }
}
