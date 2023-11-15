<?php

namespace Smetaniny\LaravelImage\Adapters;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\UploadedFile;
use Imagick;
use ImagickException;
use ImagickPixel;
use Smetaniny\LaravelImage\Contracts\ImageAdapterInterface;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Exception\NotReadableException;
use Smetaniny\LaravelImage\Image;

/**
 * Адаптер для создания объекта изображения на основе данных, предоставленных UploadedFile
 *
 * Class UploadedFileImageAdapter
 */
class UploadedFileImageAdapter implements ImageAdapterInterface
{
    protected UploadedFile $file;

    /**
     * Конструктор класса.
     *
     * @param UploadedFile $file UploadedFile, представляющий загруженный файл
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Метод для создания объекта изображения на основе данных UploadedFile.
     *
     * @return ImageInterface Объект изображения.
     *
     * @throws NotReadableException|FileNotFoundException Исключение, если изображение не может быть прочитано или
     *     обработано.
     */
    public function createImageFromData(): ImageInterface
    {
        try {
            // Создание нового экземпляра объекта ImageFacade
            $image = new Image();
            // Создание нового экземпляра объекта Imagick
            $imagick = new Imagick();

            // Устанавливаем фон изображения как прозрачный
            $imagick->setBackgroundColor(new ImagickPixel('transparent'));
            // Установка разрешения (DPI)
            $imagick->setResolution(600, 600);
            // Чтение изображения из загруженного файла
            $imagick->readImageBlob($this->file->get());

            // Получение расширения файла из UploadedFile
            $extension = $this->file->getClientOriginalExtension();
            // Получение имени файла из UploadedFile
            $originalName = pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME);

            // Установка MIME-типа изображения
            $image->setMime($imagick->getImageMimeType());
            // Установка базового имени файла в объект изображения
            $image->setBasename(basename($this->file->path()));
            // Установка пустой директории в объект изображения
            $image->setDirname("");
            // Установка имени файла
            $image->setFilename($originalName);
            // Установка расширения файла
            $image->setExtension($extension);
            // Установка изображения в объект изображения
            $image->setImageResource($imagick);

            return $image;
        } catch (ImagickException $e) {
            // Обрабатываем исключения Imagick, если возникли проблемы при обработке изображения
            throw new NotReadableException("Ошибка обработки изображения: " . $e->getMessage());
        }
    }
}
