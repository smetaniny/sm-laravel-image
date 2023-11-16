<?php

namespace Smetaniny\LaravelImage\Contracts;

use Imagick;
use ImagickException;
use Smetaniny\LaravelImage\Exception\NotReadableException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Smetaniny\LaravelImage\Image;

/**
 * Интерфейс для объекта изображения.
 *
 * @method Image save(string $path = "", int $quality = null): Image Сохраняет изображение в указанный путь с заданным
 *     качеством.
 *
 * @method Image flip(string $mode = 'h'): Image Обрабатывает отражение изображения по горизонтали или
 *     вертикали. Режим отражения: 'h' для горизонтального, 'v' для вертикального.
 *
 * @method Image crop(int $width, int $height, ?int $x = null, ?int $y = null): Image Обрезает изображение до
 *     указанных размеров с возможностью установки координат верхнего левого угла.
 *
 * @method Image encode(string $format): Image Кодирует изображение в определенный формат.
 *
 * @method Image resize(?int $width, ?int $height): Image Изменяет размер изображения на заданную ширину и
 *     высоту сохраняя пропорции.
 *
 * @method Image orientate(): Image Изменяет ориентацию изображения. Автоматически повернет изображение так,
 *     чтобы оно было правильно отображено.
 *
 * @method Image response(array $headers = []): Response Создает HTTP-ответ на основе изображения. Полезно, когда нужно
 *     вернуть изображение как ответ на запрос.
 *
 * @method Image stream(array $headers = []): StreamedResponse Выводит изображение в виде потока. Полезен, когда нужно
 *     передать большие файлы клиенту по мере их генерации или обработки, минимизируя использование памяти.
 *
 * @method Image rotate(int $angle): Image Поворачивает изображение на заданный угол.
 *
 * @method Image optimize(): Image Выполняет оптимизацию, уменьшая размер файла изображения, сохраняя при этом
 *     его визуальное качество.
 *
 * @method Image mirror(string $mode = 'h'): Image Зеркально отражает изображение по горизонтали или
 *     вертикали. Режим отражения: 'h' для горизонтального, 'v' для вертикального.
 *
 * @method Image blur(float $radius = 5, float $sigma = 1): Image Применяет размытие к изображению.
 *
 * @method Image brightness(float $brightness): Image Регулирует яркость изображения.
 *     Уровень яркости (0 - оригинал,
 *     > 0 - увеличить, < 0 - уменьшить).
 *
 * @method Image contrast(float $contrast): Image Регулирует контраст изображения.
 *     Уровень контраста (0 - оригинал,
 *     > 0 - увеличить, < 0 - уменьшить).
 *
 * @method Image grayscale(): Image Преобразует изображение в черно-белый (оттенки
 *     серого).
 *
 * @method Image sharpen(float $amount = 2, float $radius = 1, float $sigma = 0.5):
 *     Image Применяет эффект заточки к изображению.
 *
 * @method Image textOverlay(string $text, int $x, int $y, string $font, int $fontSize, string $color = '#000000'):
 *     Image Добавляет текстовое наложение на изображение.
 *
 * @method Image watermark(string $watermarkPath, int $x, int $y, int $opacity = 50):
 *     Image Добавляет водяной знак на изображение.
 *
 */
interface ImageInterface
{
    /**
     * Создает объект изображения
     *
     * @param mixed $data Данные для создания изображения (локальный файл, UploadedFile, URL-адрес)
     *
     * @return ImageInterface Объект изображения
     *
     * @throws NotReadableException|FileNotFoundException Исключение, если изображение не может быть прочитано или
     *     обработано.
     */
    public static function make(mixed $data): ImageInterface;

    /**
     * Получает имя файла изображения
     *
     * @return string - Имя файла изображения
     */
    public function getFilename(): string;

    /**
     * Устанавливает ресурс изображения
     *
     * @param Imagick $imageResource - Ресурс изображения
     *
     * @return ImageInterface - Возвращает экземпляр изображения
     */
    public function setImageResource(Imagick $imageResource): ImageInterface;

    /**
     * Устанавливает MIME-тип изображения
     *
     * @param string $mime - MIME-тип изображения
     *
     * @return ImageInterface - Возвращает экземпляр изображения
     */
    public function setMime(string $mime): ImageInterface;

    /**
     * Получает MIME-тип изображения
     *
     * @return string
     */
    public function getMime(): string;

    /**
     * Получает ресурс изображения
     *
     * @return Imagick - Ресурс изображения
     */
    public function getImageResource(): Imagick;

    /**
     * Получает имя директории
     *
     * @return string - Имя директории
     */
    public function getDirname(): string;

    /**
     * Устанавливает имя директории
     *
     * @param string $dirname - Имя директории
     */
    public function setDirname(string $dirname): void;

    /**
     * Устанавливает имя файла
     *
     * @param string $filename - Имя файла
     */
    public function setFilename(string $filename): void;

    /**
     * Получает базовое имя файла
     *
     * @return string - Базовое имя файла
     */
    public function getBasename(): string;

    /**
     * Устанавливает базовое имя файла
     *
     * @param string $basename - Базовое имя файла
     */
    public function setBasename(string $basename): void;

    /**
     * Получить путь, где сохранили изображение
     *
     * @return string
     */
    public function getSavePath(): string;

    /**
     * Изменить путь, где сохранили изображение
     *
     * @param string $savePath
     */
    public function setSavePath(string $savePath): void;

    /**
     * Возвращает содержимое изображения в виде строки.
     *
     * @return string
     * @throws ImagickException
     */
    public function getEncoded(): string;
}
