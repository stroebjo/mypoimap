<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

use App\Vendor\Parsedown;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('parsedown', function () {
            $parsedown = Parsedown::instance();

            $parsedown->setBreaksEnabled(false);

            $parsedown->setMarkupEscaped(false);

            $parsedown->setSafeMode(true);

            $parsedown->setUrlsLinked(true);

            return $parsedown;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->compiler()->directive('markdown', function (string $expression = '') {
            return "<?php echo markdown($expression); ?>";
        });
    }

    /**
     * @return BladeCompiler
     */
    protected function compiler(): BladeCompiler
    {
        return app('view')
            ->getEngineResolver()
            ->resolve('blade')
            ->getCompiler();
    }
}
