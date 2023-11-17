<?php

namespace Smetaniny\SmLaravelAdmin\Commands;

use ImagickException;
use Smetaniny\SmLaravelAdmin\Contracts\ImageInterface;
use Smetaniny\SmLaravelAdmin\Image;

/**
 * Команда для регулировки яркости изображения.
 */
class BrightnessCommand extends Image implements ImageInterface
{
    /**
     * Регулирует яркость изображения.
     *
     * @param ImageInterface $image Объект изображения, которое нужно отредактировать.
     * @param float $brightness Уровень яркости (0 - оригинал, > 0 - увеличить, < 0 - уменьшить).
     *
     * @return ImageInterface Возвращает объект изображения после регулировки яркости.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обработке изображения.
     */
    public function execute(ImageInterface $image, float $brightness): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Регулируем яркость
        $imagick->modulateImage(100 + $brightness, 100, 100);

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
