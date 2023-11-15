<?php

namespace Smetaniny\LaravelImage\Commands;

use ImagickException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Image;

/**
 * Команда для регулировки контраста изображения.
 */
class ContrastCommand extends Image implements ImageInterface
{
    /**
     * Регулирует контраст изображения.
     *
     * @param ImageInterface $image Объект изображения, которое нужно отредактировать.
     * @param float $contrast Уровень контраста (0 - оригинал, > 0 - увеличить, < 0 - уменьшить).
     *
     * @return ImageInterface Возвращает объект изображения после регулировки контраста.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обработке изображения.
     */
    public function execute(ImageInterface $image, float $contrast): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Регулируем контраст
        $imagick->contrastImage($contrast > 0);

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
