<?php

namespace Smetaniny\LaravelImage\Commands;

use ImagickException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Image;

/**
 * Команда кодирования изображения в определенный формат.
 */
class EncodeCommand extends Image implements ImageInterface
{
    /**
     * Обрабатывает кодирование изображения в указанный формат.
     *
     * @param ImageInterface $image Объект изображения, который нужно закодировать.
     * @param string $format Формат, в который нужно закодировать изображение.
     *
     * @return ImageInterface Возвращает объект изображения после кодирования.
     * @throws ImagickException
     */
    public function execute(ImageInterface $image, string $format): ImageInterface
    {
        // Получаем ресурс ImageFacade
        $imagick = $image->getImageResource();

        // Устанавливаем формат изображения
        $imagick->setImageFormat($format);
        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);
        // Установка MIME-типа изображения
        $image->setMime($imagick->getImageMimeType());
        // Установка расширения файла
        $image->setExtension(strtolower($imagick->getImageFormat()));

        return $image;
    }
}

