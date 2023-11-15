<?php

namespace Smetaniny\LaravelImage\Commands;

use Imagick;
use ImagickException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Image;

/**
 * Команда изменения ориентации изображения.
 */
class OrientateCommand extends Image implements ImageInterface
{
    /**
     * Изменяет ориентацию изображения. Автоматически повернет изображение так, чтобы оно было правильно отображено.
     *
     * @param ImageInterface $image Объект изображения, который нужно изменить.
     *
     * @return ImageInterface Возвращает объект изображения после изменения ориентации.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при кодировании изображения.
     */
    public function execute(ImageInterface $image): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Получаем текущую ориентацию изображения из тега Exif
        $orientation = $imagick->getImageOrientation();

        // Определяем соответствующую ориентацию и применяем изменение
        switch ($orientation) {
            case Imagick::ORIENTATION_TOPRIGHT:
                $imagick->flopImage();
                break;
            case Imagick::ORIENTATION_BOTTOMRIGHT:
                $imagick->rotateImage('#000', 180);
                break;
            case Imagick::ORIENTATION_BOTTOMLEFT:
                $imagick->flipImage();
                break;
            case Imagick::ORIENTATION_LEFTTOP:
                $imagick->flopImage();
                $imagick->rotateImage('#000', -90);
                break;
            case Imagick::ORIENTATION_RIGHTTOP:
                $imagick->rotateImage('#000', 90);
                break;
            case Imagick::ORIENTATION_RIGHTBOTTOM:
                $imagick->flopImage();
                $imagick->rotateImage('#000', 90);
                break;
            case Imagick::ORIENTATION_LEFTBOTTOM:
                $imagick->rotateImage('#000', -90);
                break;
            default:
                // Если ориентация неизвестна, ничего не меняем
                break;
        }

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
