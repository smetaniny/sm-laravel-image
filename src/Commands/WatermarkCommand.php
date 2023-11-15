<?php

namespace Smetaniny\LaravelImage\Commands;

use Imagick;
use ImagickException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Image;

/**
 * Команда для добавления водяного знака на изображение.
 */
class WatermarkCommand extends Image implements ImageInterface
{
    /**
     * Добавляет водяной знак на изображение.
     *
     * @param ImageInterface $image Объект изображения, на которое нужно добавить водяной знак.
     * @param string $watermarkPath Путь к файлу изображения водяного знака.
     * @param int $x Положение по оси X.
     * @param int $y Положение по оси Y.
     * @param int $opacity Прозрачность водяного знака (от 0 до 100).
     *
     * @return ImageInterface Возвращает объект изображения после добавления водяного знака.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обработке изображения.
     */
    public function execute(ImageInterface $image, string $watermarkPath, int $x, int $y, int $opacity = 50): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Создаем объект Imagick для водяного знака
        $watermark = new Imagick($watermarkPath);

        // Получаем размеры изображения
        $imageWidth = $imagick->getImageWidth();
        $imageHeight = $imagick->getImageHeight();

        // Получаем размеры водяного знака
        $watermarkWidth = $watermark->getImageWidth();
        $watermarkHeight = $watermark->getImageHeight();

        // Устанавливаем прозрачность водяного знака
        $watermark->evaluateImage(Imagick::EVALUATE_MULTIPLY, $opacity / 100, Imagick::CHANNEL_ALPHA);

        // Рассчитываем новые размеры водяного знака, если он слишком большой
        if ($watermarkWidth > $imageWidth || $watermarkHeight > $imageHeight) {
            $watermark->scaleImage($imageWidth, $imageHeight, true);
        }

        // Налагаем водяной знак на изображение
        $imagick->compositeImage($watermark, Imagick::COMPOSITE_OVER, $x, $y);

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
