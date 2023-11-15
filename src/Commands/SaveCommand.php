<?php

namespace Smetaniny\LaravelImage\Commands;

use Illuminate\Support\Str;
use ImagickException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Image;

/**
 * Команда для сохранения файла
 *
 * Class SaveCommand
 */
class SaveCommand extends Image implements ImageInterface
{
    /**
     * Выполняет сохранение изображения по указанному пути и с заданным качеством
     *
     * @param ImageInterface $image Объект изображения для сохранения
     * @param string $path Путь для сохранения изображения
     * @param int|null $quality Качество сохранения изображения
     *
     * @throws ImagickException
     */
    public function execute(ImageInterface $image, string $path = "", int $quality = null): ImageInterface
    {
        // Получение данных из конфигурации
        $baseSavePath = config('sm-laravel-image.base_path');
        $defaultQuality = config('sm-laravel-image.default_quality');
        $filenameFilter = config('sm-laravel-image.filename_filter');

        // Если значение $quality не передано явно, получаем его из конфигурации
        if ($quality === null) {
            $quality = $defaultQuality;
        }

        // Применяем фильтрацию имени файла, если в конфигурации указано регулярное выражение
        if (!empty($filenameFilter)) {
            $image->filename = preg_replace($filenameFilter, '', $image->filename);
        }

        // Если в конфигурации установлен параметр 'use_slug' в true, применяем Str::slug
        if (config('sm-laravel-image.use_slug', true)) {
            $image->filename = Str::slug($image->filename);
        }

        // Если путь не пустой и нет названия файла
        if (!empty($path) && pathinfo($path, PATHINFO_EXTENSION) === '') {
            // Построить путь сохранения с учетом настроек конфигурации
            $savePath = $path . '/' . $image->filename . '.' . $image->extension;
        } // Если не пустой и есть название файла
        else if (!empty($path) && pathinfo($path, PATHINFO_EXTENSION) !== '') {
            // Построить путь сохранения с учетом настроек конфигурации
            $savePath = $path . '.' . $image->extension;
        } // Иначе строим все из данных
        else {
            $savePath = $image->filename . '.' . $image->extension;
        }

        // Удаление подряд идущие слеши
        $savePath = preg_replace('#/+#', '/', $savePath);

        $directory = dirname(storage_path($baseSavePath . '/' . $savePath));
        // Создаем директорию, если она не существует
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Добавляем ресурс в Imagick
        $imagick = $image->getImageResource();

        // Устанавливаем качество сохранения
        $imagick->setImageCompressionQuality($quality);

        // Сохраните изображение
        $imagick->writeImage(storage_path($baseSavePath . '/' . $savePath));

        // Пишем путь, где сохранили изображение
        $image->setSavePath($savePath);

        return $image;
    }
}
