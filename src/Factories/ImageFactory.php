<?php

namespace Smetaniny\LaravelImage\Factories;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Smetaniny\LaravelImage\Adapters\FilePathImageAdapter;
use Smetaniny\LaravelImage\Adapters\UploadedFileImageAdapter;
use Smetaniny\LaravelImage\Adapters\UrlImageAdapter;
use Smetaniny\LaravelImage\Contracts\ImageFactoryInterface;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Exception\NotReadableException;

/**
 * Фабрика для создания экземпляра класса ImageFacade на основе предоставленных данных (файла, URL и т. д.)
 *
 * Class ImageFactory
 */
class ImageFactory implements ImageFactoryInterface
{
    /**
     * Создает экземпляр класса ImageFacade на основе предоставленных данных (файла, URL и т. д.)
     *
     * @param mixed $data Данные для создания изображения, такие как файл, URL и т. д
     *
     * @return ImageInterface Возвращает экземпляр класса ImageFacade
     *
     * @throws NotReadableException|FileNotFoundException Исключение, если изображение не может быть прочитано или
     *     обработано.
     */
    public static function createImage(mixed $data): ImageInterface
    {
        // Проверка, является ли переданный путь к файлу валидным
        if (is_string($data) && str_contains($data, "\\")) {
            throw new NotReadableException("Неверный формат пути к файлу.");
        }

        // Определяет адаптер на основе типа предоставленных данных, и создает объект ImageFacade.
        $adapterClass = match (true) {
            // Используется адаптер для загруженных файлов
            $data instanceof UploadedFile => new UploadedFileImageAdapter($data),
            // Используется адаптер для локальных файлов
            is_string($data) && is_file($data) => new FilePathImageAdapter($data),
            // Используется адаптер для URL
            is_string($data) && filter_var($data, FILTER_VALIDATE_URL) !== false => new UrlImageAdapter($data),
            // Выбрасываем исключение, если нельзя прочитать источник изображения
            default => throw new NotReadableException("Невозможно прочитать источник изображения"),
        };

        // Создает экземпляр ImageFacade и передает адаптер
        return $adapterClass->createImageFromData();
    }
}
