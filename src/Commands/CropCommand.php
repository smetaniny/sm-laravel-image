<?php

namespace Smetaniny\SmLaravelAdmin\Commands;

use ImagickException;
use Smetaniny\SmLaravelAdmin\Contracts\ImageInterface;
use Smetaniny\SmLaravelAdmin\Image;

/**
 * Команда обрезки изображения
 */
class CropCommand extends Image implements ImageInterface
{
    /**
     * Обрезает изображение
     *
     * @param ImageInterface $image Изображение, которое будет обрезано
     * @param int $width Ширина обрезанного изображения
     * @param int $height Высота обрезанного изображения
     * @param int|null $x X-координата верхнего левого угла обрезки
     * @param int|null $y Y-координата верхнего левого угла обрезки
     *
     * @return ImageInterface Новый объект изображения с обрезанными размерами
     *
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обрезке изображения
     */
    public function execute(ImageInterface $image, int $width, int $height, ?int $x = null, ?int $y = null): ImageInterface
    {
        $imagick = $image->getImageResource();

        // Получаем текущие размеры изображения
        $currentWidth = $imagick->getImageWidth();
        $currentHeight = $imagick->getImageHeight();

        // Положение обрезки (по умолчанию центр)
        $xOffset = $x ?? ($currentWidth - $width) / 2;
        $yOffset = $y ?? ($currentHeight - $height) / 2;

        // Создаем прямоугольник для обрезки
        $imagick->cropImage($width, $height, $xOffset, $yOffset);

        // Обновляем ресурс изображения в объекте $image.
        $image->setImageResource($imagick);

        // Возвращаем объект изображения с обрезанными размерами.
        return $image;
    }

}
