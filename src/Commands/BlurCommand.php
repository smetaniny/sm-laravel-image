<?php

namespace Smetaniny\LaravelImage\Commands;

use ImagickException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Image;

/**
 * Команда для применения размытия к изображению.
 */
class BlurCommand extends Image implements ImageInterface
{
    /**
     * Применяет размытие к изображению.
     *
     * @param ImageInterface $image Объект изображения, которое нужно размыть.
     * @param float $radius Радиус размытия (чем больше, тем сильнее размытие).
     * @param float $sigma Стандартное отклонение для гауссова размытия.
     *
     * @return ImageInterface Возвращает объект изображения после применения размытия.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обработке изображения.
     */
    public function execute(ImageInterface $image, float $radius = 5, float $sigma = 1): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Применяем размытие с заданными параметрами
        $imagick->blurImage($radius, $sigma);

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
