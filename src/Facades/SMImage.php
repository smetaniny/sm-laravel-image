<?php

namespace Smetaniny\LaravelImage\Facades;

use Illuminate\Support\Facades\Facade;
use Smetaniny\LaravelImage\Image;

/**
 * Фасад для удобного доступа к функциональности работы с изображениями
 *
 * @method static Image make(mixed $data): ImageInterface Создает объект изображения
 */
class SMImage extends Facade
{
    /**
     * Получает имя зарегистрированного компонента
     *
     * @return string   Имя компонента
     */
    protected static function getFacadeAccessor(): string
    {
        return 'SMImage';
    }

}
