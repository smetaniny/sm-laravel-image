<?php

namespace Smetaniny\SmLaravelAdmin\Contracts;

/**
 * Интерфейс для фабричных методов создания объектов
 *
 * Interface ImageFactoryInterface
 */
interface ImageFactoryInterface
{
    /**
     * Создает экземпляр объекта для работы с изображением
     *
     * @param mixed $data - Файл, URL или другой источник изображения
     *
     * @return ImageInterface Созданный объект для работы с изображением
     */
    public static function createImage(mixed $data): ImageInterface;
}
