<?php

namespace Smetaniny\LaravelImage\Commands;

use Imagick;
use ImagickDraw;
use ImagickDrawException;
use ImagickException;
use ImagickPixel;
use ImagickPixelException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Image;

/**
 * Команда для добавления текстового наложения на изображение.
 */
class TextOverlayCommand extends Image implements ImageInterface
{
    /**
     * Добавляет текстовое наложение на изображение.
     *
     * @param ImageInterface $image Объект изображения, на которое нужно добавить текст.
     * @param string $text Текст для наложения.
     * @param int $x Положение по оси X.
     * @param int $y Положение по оси Y.
     * @param string $font Путь к файлу шрифта.
     * @param int $fontSize Размер шрифта.
     * @param string $color Цвет текста в формате "#RRGGBB".
     *
     * @return ImageInterface Возвращает объект изображения после добавления текстового наложения.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обработке изображения.
     * @throws ImagickPixelException Исключение, если произошла ошибка Imagick при работе с пикселем.
     * @throws ImagickDrawException Исключение, если произошла ошибка Imagick при работе с рисованием.
     */
    public function execute(ImageInterface $image, string $text, int $x, int $y, string $font, int $fontSize, string $color = '#000000'): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Создаем объект ImagickDraw
        $draw = new ImagickDraw();

        // Устанавливаем шрифт и размер
        $draw->setFont($font);
        $draw->setFontSize($fontSize);

        // Устанавливаем цвет текста
        $draw->setFillColor(new ImagickPixel($color));

        // Добавляем текст на изображение
        $imagick->annotateImage($draw, $x, $y, 0, $text);

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
