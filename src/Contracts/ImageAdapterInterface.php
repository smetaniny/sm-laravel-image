<?php

namespace Smetaniny\SmLaravelAdmin\Contracts;

/**
 * Интерфейс для адаптера, создающего объект изображения на основе предоставленных данных
 *
 * Interface ImageAdapterInterface
 */
interface ImageAdapterInterface
{
    /**
     * Метод для создания объекта изображения на основе предоставленных данных
     *
     * @return ImageInterface Объект изображения
     */
    public function createImageFromData(): ImageInterface;
}
