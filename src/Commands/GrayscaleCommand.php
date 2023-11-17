<?php

namespace Smetaniny\SmLaravelAdmin\Commands;

use Imagick;
use ImagickException;
use Smetaniny\SmLaravelAdmin\Contracts\ImageInterface;
use Smetaniny\SmLaravelAdmin\Image;

/**
 * Команда для преобразования изображения в черно-белый (оттенки серого).
 */
class GrayscaleCommand extends Image implements ImageInterface
{
    /**
     * Преобразует изображение в черно-белый (оттенки серого).
     *
     * @param ImageInterface $image Объект изображения, которое нужно отредактировать.
     *
     * @return ImageInterface Возвращает объект изображения после преобразования в черно-белый.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обработке изображения.
     */
    public function execute(ImageInterface $image): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Преобразуем в черно-белый
        $imagick->setImageType(Imagick::IMGTYPE_GRAYSCALE);

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
