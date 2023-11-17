<?php

namespace Smetaniny\SmLaravelAdmin\Commands;

use Illuminate\Http\Response;
use ImagickException;
use Smetaniny\SmLaravelAdmin\Contracts\ImageInterface;

/**
 * Команда для возврата изображения как HTTP-ответ.
 */
class ResponseCommand
{
    /**
     * Создает HTTP-ответ на основе изображения. Полезно, когда нужно вернуть изображение как ответ на запрос.
     *
     * @param ImageInterface $image Объект изображения.
     * @param array $headers Заголовки ответа.
     *
     * @return Response HTTP-ответ.
     * @throws ImagickException В случае ошибки Imagick при кодировании изображения.
     */
    public function execute(ImageInterface $image, array $headers = []): Response
    {
        // Получаем содержимое изображения в виде строки
        $imageContent = $image->getEncoded();

        // Устанавливаем заголовок Content-Type на основе формата изображения
        $contentType = $image->getMime();
        // Объединяем переданные заголовки с основными заголовками
        $headers = array_merge([
            'Content-Type' => $contentType,
        ], $headers);

        // Создаем HTTP-ответ с использованием содержимого изображения
        return response($imageContent, 200, $headers);
    }
}

