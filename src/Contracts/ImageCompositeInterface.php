<?php

namespace Smetaniny\SmLaravelAdmin\Contracts;

use Illuminate\Http\UploadedFile;

/**
 * Интерфейс для работы с группами изображений
 *
 * Interface ImageCompositeInterface
 */
interface ImageCompositeInterface
{
    /**
     * Добавляет изображение к группе.
     *
     * @param UploadedFile $image Изображение для добавления к группе
     */
    public function addImage(UploadedFile $image);

    /**
     * Удаляет изображение из группы
     *
     * @param UploadedFile $image Изображение для удаления из группы
     */
    public function removeImage(UploadedFile $image);

    /**
     * Обрабатывает все изображения в группе.
     */
    public function processImages();
}
