<?php

namespace Smetaniny\LaravelImage\Adapters;

use Imagick;
use ImagickException;
use ImagickPixel;
use Smetaniny\LaravelImage\Contracts\ImageAdapterInterface;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Exception\NotReadableException;
use Smetaniny\LaravelImage\Image;

/**
 * Адаптер для создания объекта изображения на основе данных, полученных по URL-адресу
 *
 * Class UrlImageAdapter
 */
class UrlImageAdapter implements ImageAdapterInterface
{
    protected string $url;

    /**
     * Конструктор класса
     *
     * @param string $url URL-адрес, по которому можно получить изображение
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Метод для создания объекта изображения на основе данных, полученных по URL-адресу
     *
     * @return ImageInterface Объект изображения
     *
     * @throws NotReadableException Выбрасывает исключение, если изображение не может быть прочитано
     */
    public function createImageFromData(): ImageInterface
    {
        try {
            // Создание объекта ImageFacade, который будет представлять изображение
            $image = new Image();
            // Создание объекта Imagick для обработки изображения
            $imagick = new Imagick();

            // Загрузка изображения из данных URL
            $binary = @file_get_contents($this->url, false);

            // Проверка на успешную загрузку изображения, иначе выбрасываем исключение
            if ($binary === false) {
                throw new NotReadableException("Ошибка при загрузке изображения с URL-адреса.");
            }

            // Установка фона изображения как прозрачного
            $imagick->setBackgroundColor(new ImagickPixel('transparent'));
            // Установка разрешения (DPI)
            $imagick->setResolution(600, 600);
            // Чтение изображения из данных URL
            $imagick->readImageBlob($binary);

            // Получение имени файла из URL
            $urlInfo = parse_url($this->url);
            // Получение информации о пути URL
            $pathInfo = pathinfo($urlInfo['path']);

            // Установка MIME-типа изображения
            $image->setMime($imagick->getImageMimeType());
            // Установка базового имени файла в объект изображения
            $image->setBasename($pathInfo['basename']);
            // Установка директории, имени файла и базового имени файла в объект ImageFacade
            $image->setDirname($pathInfo['dirname']);
            // Установка имени файла с расширением в объект изображения
            $image->setFilename($pathInfo['filename']);
            // Установка расширения файла
            $image->setExtension($pathInfo['extension']);
            // Установка ресурса изображения Imagick в объект ImageFacade
            $image->setImageResource($imagick);

            return $image;
        } catch (ImagickException $e) {
            // Обработка исключений Imagick, если возникли проблемы при обработке изображения
            throw new NotReadableException("Ошибка обработки изображения: " . $e->getMessage());
        }
    }
}
