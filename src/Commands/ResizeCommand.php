<?php

namespace Smetaniny\SmLaravelAdmin\Commands;

use Imagick;
use ImagickException;
use Smetaniny\SmLaravelAdmin\Contracts\ImageInterface;
use Smetaniny\SmLaravelAdmin\Image;

/**
 * Команда изменения размера изображения
 */
class ResizeCommand extends Image implements ImageInterface
{
    /**
     * Изменяет размер изображения
     *
     * @param ImageInterface $image Изображение, которое будет изменено
     * @param int|null $width Новая ширина изображения
     * @param int|null $height Новая высота изображения
     *
     * @return ImageInterface Новый объект изображения с измененным размером
     *
     * @throws ImagickException Исключение, если произошла ошибка Imagick при изменении размера
     */
    public function execute(ImageInterface $image, ?int $width, ?int $height): ImageInterface
    {
        $imagick = $image->getImageResource();

        // Определяем текущие размеры изображения
        $currentWidth = $imagick->getImageWidth();
        $currentHeight = $imagick->getImageHeight();

        if ($width === null && $height === null) {
            // Если и ширина, и высота равны null, ничего не делаем.
            return $image;
        }

        if ($width === null) {
            // Вычисляем новую ширину, чтобы сохранить пропорции
            $width = ($currentWidth * $height) / $currentHeight;
        } elseif ($height === null) {
            // Вычисляем новую высоту, чтобы сохранить пропорции
            $height = ($currentHeight * $width) / $currentWidth;
        }

        // Изменяем размер изображения с использованием метода resizeImage и фильтра FILTER_LANCZOS.
        $imagick->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);

        // Обновляем ресурс изображения в объекте $image.
        $image->setImageResource($imagick);

        // Возвращаем объект изображения с измененным размером.
        return $image;
    }
}
