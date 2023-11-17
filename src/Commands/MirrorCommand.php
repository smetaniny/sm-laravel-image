<?php

namespace Smetaniny\SmLaravelAdmin\Commands;

use ImagickException;
use Smetaniny\SmLaravelAdmin\Contracts\ImageInterface;
use Smetaniny\SmLaravelAdmin\Image;

/**
 * Команда для зеркального отражения изображения по горизонтали или вертикали.
 */
class MirrorCommand extends Image implements ImageInterface
{
    /**
     * Зеркально отражает изображение по горизонтали или вертикали.
     *
     * @param ImageInterface $image Объект изображения, которое нужно отразить.
     * @param string $mode Режим отражения: 'h' для горизонтального, 'v' для вертикального.
     *
     * @return ImageInterface Возвращает объект изображения после отражения.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при обработке изображения.
     */
    public function execute(ImageInterface $image, string $mode = 'h'): ImageInterface
    {
        // Получаем ресурс изображения
        $imagick = $image->getImageResource();

        // Отражаем изображение в зависимости от режима
        if ($mode === 'h') {
            $imagick->flopImage();
        } elseif ($mode === 'v') {
            $imagick->flipImage();
        }

        // Обновляем ресурс изображения в текущем объекте $image
        $image->setImageResource($imagick);

        return $image;
    }
}
