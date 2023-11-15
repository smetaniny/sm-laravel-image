<?php

namespace Smetaniny\LaravelImage\Commands;

use ImagickException;
use Smetaniny\LaravelImage\Contracts\ImageInterface;
use Smetaniny\LaravelImage\Image;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 *
 */
class StreamCommand extends Image implements ImageInterface
{
    /**
     * Выводит изображение в виде потока. Полезен, когда нужно передать большие файлы клиенту по мере их генерации или
     * обработки, минимизируя использование памяти.
     *
     * @param ImageInterface $image Объект изображения.
     * @param array $headers Заголовки ответа.
     *
     * @return StreamedResponse Потоковый HTTP-ответ.
     * @throws ImagickException В случае ошибки Imagick при кодировании изображения.
     */
    public function execute(ImageInterface $image, array $headers = []): StreamedResponse
    {
        // Получаем содержимое изображения в виде строки
        $imageContent = $image->getEncoded();

        // Устанавливаем заголовок Content-Type на основе формата изображения
        $contentType = $image->getMime();

        // Объединяем переданные заголовки с основными заголовками
        $headers = array_merge([
            'Content-Type' => $contentType,
        ], $headers);

        // Регистрация команды

        // Создаем потоковый HTTP-ответ с использованием содержимого изображения
        return response()->stream(
            fn() => print($imageContent),
            200,
            $headers
        );
    }
}
