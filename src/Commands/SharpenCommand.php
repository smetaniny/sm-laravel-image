<?php

namespace Smetaniny\SmLaravelAdmin\Commands;

use ImagickException;
use Smetaniny\SmLaravelAdmin\Contracts\ImageInterface;
use Smetaniny\SmLaravelAdmin\Image;

/**
 * Команда для применения эффекта заточки к изображению.
 */
class SharpenCommand extends Image implements ImageInterface
{
    /**
     * Применяет эффект заточки к изображению.
     *
     * @param ImageInterface $image Объект изображения, которое нужно отредактировать.
     * @param float $amount Уровень заточки (чем больше, тем сильнее резкость).
     * @param float $radius Радиус заточки.
     * @param float $sigma Стандартное отклонение для гауссова заточки.
     *
     * @return ImageInterface Возвращает объект изображения после применения эффекта заточки.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обработке изображения.
     */
    public function execute(ImageInterface $image, float $amount = 2, float $radius = 1, float $sigma = 0.5): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Применяем эффект заточки с заданными параметрами
        $imagick->sharpenImage($radius, $sigma, $amount);

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
