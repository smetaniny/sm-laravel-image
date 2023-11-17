<?php

namespace Smetaniny\SmLaravelAdmin;

use Illuminate\Support\ServiceProvider;

/**
 * Сервис-провайдер предоставляет функциональность пакета. Регистрирует сервисы и настраивает конфигурацию пакета
 */
class LaravelAdminServiceProvider extends ServiceProvider
{
    /**
     * Загрузка всех необходимых сервисов пакета.
     *
     * @return void
     */
    public function boot(): void
    {
        // Публикация необходима только при использовании командной строки (CLI).
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Регистрация всех сервисов пакета
     *
     * @return void
     */
    public function register(): void
    {
        // Объединение конфигурации пакета, если это необходимо.
        $this->mergeConfigFrom(__DIR__ . '/../config/sm-laravel-image.php', 'sm-laravel-image');

        // Регистрация сервиса, предоставляемого пакетом.
        $this->app->singleton('SMImage', function ($app) {
            return new Image();
        });
    }

    /**
     * Получение списка сервисов, предоставляемых сервис-провайдером
     *
     * @return array
     */
    public function provides()
    {
        return ['SMImage'];
    }

    /**
     * Дополнительные действия после регистрации сервисов в командной строке (CLI)
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Публикация файла конфигурации.
        $this->publishes([
            __DIR__ . '/../config/sm-laravel-image.php' => config_path('sm-laravel-image.php'),
        ], 'sm-laravel-image.config');
    }
}
