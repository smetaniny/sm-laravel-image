<?php

namespace Smetaniny\LaravelImage;

use BadMethodCallException;
use Imagick;
use ImagickException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Exception\NotReadableException;
use Smetaniny\LaravelImage\Factories\ImageFactory;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

/**
 * Класс ImageFacade представляет изображение и методы для работы с ним.
 *
 * Class ImageFacade
 * @package Smetaniny\LaravelImage
 */
class Image implements ImageInterface
{
    // Резервная копия
    protected ?Imagick $backup = null;
    // Ресурс изображения Imagick
    protected ?Imagick $imageResource = null;
    // MIME-тип изображения
    protected string $mime = '';
    // Директория, в которой находится изображение
    protected string $dirname = '';
    // Имя файла изображения
    protected string $filename = '';
    // Имя файла без расширения
    protected string $basename = '';
    // Расширение файла
    protected string $extension = '';
    // Путь, где сохранили изображение.
    protected string $savePath = '';
    protected array $userCommands = [];

    /**
     * Регистрирует пользовательскую команду.
     *
     * @param string $commandName Название команды (например, 'myCustomCommand').
     * @param string $commandClass Класс команды (например, '\App\Http\Controllers\MyCustomCommand').
     */
    public function registerCommand(string $commandName, string $commandClass): void
    {
        $this->userCommands[$commandName] = $commandClass;
    }

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
    public static function make(mixed $data): ImageInterface
    {
        // Вызывает метод createImage фабрики для создания объекта изображения.
        return ImageFactory::createImage($data);
    }

    /**
     * Магический метод для вызова динамических методов.
     *
     * @param string $method Имя вызываемого метода
     * @param array $arguments Аргументы метода
     *
     * @return mixed
     * @throws ImagickException
     */
    public function __call(string $method, array $arguments)
    {
        // Проверяем, существует ли класс команды среди пользовательских команд
        if (isset($this->userCommands[$method]) && class_exists($this->userCommands[$method])) {
            // Создаем объект команды и передаем в нее текущий объект изображения и аргументы
            $command = new $this->userCommands[$method];
            return $command->execute($this, ...$arguments);
        }

        // Формируем имя команды
        $commandClassName = '\Smetaniny\LaravelImage\Commands\\' . ucfirst($method) . 'Command';

        // Проверяем, существует ли класс стратегии
        if (class_exists($commandClassName)) {
            // Создаем объект стратегии и передаем в нее текущий объект изображения и аргументы
            $strategy = new $commandClassName;
            return $strategy->execute($this, ...$arguments);
        }

        // Если класс команды и стратегии не найдены, выбрасываем исключение
        throw new BadMethodCallException("Команда {$method}() не существует в " . static::class);
    }

    /**
     * Обрабатывает статические вызовы методов, создавая объект изображения через ImageFactory.
     *
     * @param string $method Имя вызываемого метода.
     * @param array $arguments Аргументы, переданные методу.
     *
     * @return ImageInterface Возвращает объект изображения.
     *
     * @throws FileNotFoundException|NotReadableException Исключение, если изображение не может быть прочитано или
     *     обработано
     */
    public static function __callStatic(string $method, array $arguments)
    {
        return ImageFactory::createImage(...$arguments);
    }

    /**
     * Получает ресурс изображения Imagick
     *
     * @return Imagick Ресурс изображения Imagick
     */
    public function getImageResource(): Imagick
    {
        return $this->imageResource;
    }

    /**
     * Устанавливает ресурс изображения Imagick
     *
     * @param Imagick $imageResource Ресурс изображения Imagick
     *
     * @return ImageInterface
     */
    public function setImageResource(Imagick $imageResource): ImageInterface
    {
        $this->imageResource = $imageResource;
        return $this;
    }

    /**
     * Устанавливает MIME-тип изображения
     *
     * @param string $mime MIME-тип изображения
     *
     */
    public function setMime(string $mime): ImageInterface
    {
        $this->mime = $mime;
        return $this;
    }

    /**
     * Получает MIME-тип изображения
     *
     * @return string
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * Получает директорию, в которой находится изображение
     *
     * @return string   Директория изображения
     */
    public function getDirname(): string
    {
        return $this->dirname;
    }

    /**
     * Устанавливает директорию, в которой находится изображение
     *
     * @param string $dirname Директория изображения
     */
    public function setDirname(string $dirname): void
    {
        $this->dirname = $dirname;
    }

    /**
     * Получает имя файла изображения
     *
     * @return string   Имя файла изображения
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Устанавливает имя файла изображения
     *
     * @param string $filename Имя файла изображения
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * Получает базовое имя файла изображения (без расширения)
     *
     * @return string   Базовое имя файла
     */
    public function getBasename(): string
    {
        return $this->basename;
    }

    /**
     * Устанавливает базовое имя файла изображения (без расширения)
     *
     * @param string $basename Базовое имя файла
     */
    public function setBasename(string $basename): void
    {
        $this->basename = $basename;
    }

    /**
     * Получение расширения файла
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * Изменение расширения файла
     *
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }


    /**
     * Получить путь, где сохранили изображение
     *
     * @return string
     */
    public function getSavePath(): string
    {
        return $this->savePath;
    }

    /**
     * Изменить путь, где сохранили изображение
     *
     * @param string $savePath
     */
    public function setSavePath(string $savePath): void
    {
        $this->savePath = $savePath;
    }

    /**
     * Создает резервную копию изображения.
     */
    public function backup(): void
    {
        // Используйте копирование по значению, чтобы сохранить резервную копию
        $this->backup = ($this->imageResource !== null) ? clone $this->imageResource : null;
    }

    /**
     * Восстанавливает изображение из резервной копии.
     * @throws ImagickException
     */
    public function reset(): void
    {
        if ($this->backup !== null) {
            // Используйте копирование по значению, чтобы восстановить изображение
            $this->imageResource = clone $this->backup;
            $this->mime = $this->imageResource->getImageMimeType();
            $this->extension = strtolower($this->imageResource->getImageFormat());
            $this->savePath = "";
        }
    }

    /**
     * Очищает ресурсы, и уничтожает объект изображения
     *
     * После вызова этого метода объект изображения больше не может быть использован для манипуляций
     * и требуется создание нового объекта изображения для проведения дополнительных операций
     */
    public function destroy(): void
    {
        // Резервная копия
        $this->backup = null;
        // Ресурс изображения Imagick
        $this->imageResource = null;
        // MIME-тип изображения
        $this->mime = '';
        // Директория, в которой находится изображение
        $this->dirname = '';
        // Имя файла изображения
        $this->filename = '';
        // Имя файла без расширения
        $this->basename = '';
        // Расширение файла
        $this->extension = '';
        // Путь, где сохранили изображение.
        $this->savePath = '';
    }

    /**
     * Возвращает содержимое изображения в виде строки.
     *
     * @return string
     * @throws ImagickException
     */
    public function getEncoded(): string
    {
        // Получаем ресурс изображения
        $imagick = $this->getImageResource();

        // Получаем содержимое изображения в формате JPEG
        return $imagick->getImageBlob();
    }
}
