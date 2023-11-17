<?php

namespace Smetaniny\SmLaravelAdmin\Commands;

use ImagickException;
use Smetaniny\SmLaravelAdmin\Contracts\ImageInterface;
use Smetaniny\SmLaravelAdmin\Image;

/**
 *Поворота изображения.
 */
class RotateCommand extends Image implements ImageInterface
{
    /**
     * Поворачивает изображение на заданный угол.
     *
     * @param ImageInterface $image Объект изображения, который нужно повернуть.
     * @param int $angle Угол поворота в градусах.
     *
     * @return ImageInterface Возвращает объект изображения после поворота.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при кодировании изображения.
     */
    public static function execute(ImageInterface $image, int $angle): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Поворачиваем изображение на заданный угол
        $imagick->rotateImage('#000', $angle);

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
