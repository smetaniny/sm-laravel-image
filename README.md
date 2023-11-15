## Пакет sm-laravel-image

### Лицензия

Этот проект лицензирован в соответствии с MIT License.

### Requirements (Требования):

- **PHP >= 8.1**
- **phpunit/phpunit: ~9.0**
- **illuminate/support: ~9**
- **orchestra/testbench: ~7**

### Supported SMImage Libraries (Поддерживаемые библиотеки):

- **Imagick PHP extension (>= 3.7.0)**

### Описание:

Проект sm-laravel-image – это современная и мощная библиотека для обработки изображений в Laravel. Она объединяет
различные компоненты и интерфейсы, предоставляя гибкую архитектуру для эффективной работы с изображениями.
Взаимодействие с библиотекой Imagick дает возможность проводить разнообразные манипуляции с изображениями. Этот проект
обеспечивает команду разработчиков мощными инструментами для управления изображениями в Laravel, а также позволяет
создавать индивидуальные решения для обработки изображений в рамках вашего проекта.

## Установка

Используйте [Composer](https://getcomposer.org/) для установки библиотеки:

```php
composer require smetaniny/sm-laravel-image
```

```php
# Конфигурация
return [
    // Базовая директория для сохранения файлов.
    'base_path' => 'app/public',
    // Качество сохранения изображения по умолчанию.
    'default_quality' => 90,
    // Следует ли применять Str::slug к имени файла.
    'use_slug' => true,
    // Оставит только буквы, цифры, символы тире и нижнее подчеркивание.
    'filename_filter' => '/[^a-zA-ZА-я\d\-_]/u', // Если пусто, то не применяется
];
```

## Функциональность:

* [`make()`](#make---создает-объект-изображения) - Создает объект изображения.
* [`save()`](#save---сохранение-изображения) - Сохранение изображения.
* [`destroy()`](#destroy---очищает-ресурсы-и-уничтожает-объект-изображения) - Очищает ресурсы, и уничтожает объект
  изображения.
* [`resize()`](#resize---изменяет-размер-изображения-сохраняя-пропорции) - Изменяет размер изображения сохраняя
  пропорции.
* [`crop()`](#crop---обрезает-изображение-по-заданным-размерам) - Обрезает изображение по заданным размерам.
* [`encode()`](#encode---кодирует-изображение-в-определенный-формат) - Кодирует изображение в определенный формат.
* [`orientate()`](#orientate---изменяет-ориентацию-изображения) - Изменяет ориентацию изображения.
* [`rotate()`](#rotate---поворачивает-изображение-на-заданный-угол) - Поворачивает изображение на заданный угол.
* [`mirror()`](#mirror---зеркально-отражает-изображение-по-горизонтали-или-вертикали) - Зеркально отражает изображение
  по горизонтали или вертикали.
* [`blur()`](#blur---применяет-размытие-к-изображению) - Применяет размытие к изображению.
* [`brightness()`](#brightness---регулирует-яркость-изображения) - Регулирует яркость изображения.
* [`contrast()`](#contrast---регулирует-контраст-изображения) - Регулирует контраст изображения.
* [`grayscale()`](#grayscale---преобразует-изображение-в-черно-белый-оттенки-серого) - Преобразует изображение в
  черно-белый (оттенки серого).
* [`sharpen()`](#sharpen---применяет-эффект-заточки-к-изображению) - Применяет эффект заточки к изображению.
* [`textOverlay()`](#textoverlay---добавляет-текстовое-наложение-на-изображение) - Добавляет текстовое наложение на
  изображение.
* [`watermark()`](#watermark---добавляет-водяной-знак-на-изображение) - Добавляет водяной знак на изображение.
* [`backup()`](#backup---создает-резервную-копию-изображения) - Создает резервную копию изображения.
* [`reset()`](#reset---восстанавливает-изображение-из-резервной-копии) - Восстанавливает изображение из резервной копии.
* [`response()`](#response---создает-http-ответ-на-основе-изображения) - Создает HTTP-ответ на основе изображения.
* [`stream()`](#stream) - Выводит изображение в виде потока.
* [`Создание пользовательских команд`](#создание-пользовательских-команд) - Создайте собственную команду и обработайте
  изображение по своему усмотрению.

## make() - Создает объект изображения.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Создает объект изображения.
 *
 * @param mixed $data Данные для создания изображения (локальный файл, UploadedFile, URL-адрес).
 * 
 * @return Image Возвращает объект изображения.
 */
@method make(mixed $data): Image

// Создание объекта изображения на основе локального файла.
$img = SMImage::make('C:/file.jpg');
// Создание объекта изображения на основе данных, полученных по URL-адресу.
$img = SMImage::make('https://file.jpg');
// Создание объекта изображения на основе данных, предоставленных UploadedFile.
$img = SMImage::make($request->file('file'));

/**
* Свойства объекта изображения
 */
// **MIME-тип изображения**
    - Геттер: $img->getMime()
    - Сеттер: $img->setMime($newMime)

// **Директория, в которой находится изображение**
    - Геттер: $img->getDirname()
    - Сеттер: $img->setDirname($newDirname)

// **Имя файла изображения**
    - Геттер: $img->getFilename()
    - Сеттер: $img->setFilename($newFilename)

// **Имя файла без расширения**
    - Геттер: $img->getBasename()
    - Сеттер: $img->setBasename($newBasename)

// **Расширение файла**
    - Геттер: $img->getExtension()
    - Сеттер: $img->setExtension($newExtension)

// **Путь**
    - Геттер: $img->getSavePath()
    - Сеттер: $img->setSavePath($newSavePath)
```

## save() - Сохранение изображения.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

/**
 * Выполняет сохранение изображения по указанному пути и с заданным качеством.
 *
 * @param string $path Путь для сохранения изображения
 * @param int|null $quality Качество сохранения изображения
 * 
 * @return Image Возвращает объект изображения.
 */
@method save(string $path = "", int $quality = null): Image

// Создание объекта изображения на основе данных, предоставленных UploadedFile.
$img = SMImage::make($request->file('file'));
// Сохранить изображение по указанному пути test/file.jpg с качеством 90.
$img->save('test/file.jpg', 90);
// Сохранить изображение по указанному пути test/file.jpg с максимальным качеством (по умолчанию 100).
$img->save('test/file.jpg');
// Сохранить изображение в соответствии с настройками конфигурации.
$img->save();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->save('file.jpg');
```

## destroy() - Очищает ресурсы, и уничтожает объект изображения.

```php
/**
 * Очищает ресурсы, и уничтожает объект изображения.
 *
 * После вызова этого метода объект изображения больше не может быть использован для манипуляций.
 * Требуется создание нового объекта изображения для проведения дополнительных операций.
 */
@method destroy(): void
```

## resize() - Изменяет размер изображения сохраняя пропорции.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Изменяет размер изображения сохраняя пропорции.
 *
 * @param int|null $width Новая ширина изображения.
 * @param int|null $height Новая высота изображения.
 * 
 * @return Image Возвращает объект изображения.
 */
@method resize(?int $width, ?int $height): Image

// Создание объекта изображения на основе данных, предоставленных UploadedFile.
$img = SMImage::make($request->file('file'));
// Изменение размера изображения на ширину 500 и высоту 400 пикселей.
$img->resize(500, 400);
// Изменение размера изображения по ширине на 400 пикселей, сохраняя пропорции.
$img->resize(null, 400);
// Изменение размера изображения по высоте на 500 пикселей, сохраняя пропорции.
$img->resize(500, null);
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath()
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->resize(500, null)
    ->save()
    ->destroy();
```

## crop() - Обрезает изображение по заданным размерам.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Обрезает изображение по заданным размерам.
 *
 * @param int $width Ширина обрезанного изображения.
 * @param int $height Высота обрезанного изображения.
 * @param int|null $x X-координата верхнего левого угла обрезки.
 * @param int|null $y Y-координата верхнего левого угла обрезки.
 * 
 * @return Image Возвращает объект изображения.
 */
@method crop(int $width, int $height, ?int $x = null, ?int $y = null): Image

// Создание объекта изображения на основе данных, предоставленных UploadedFile.
$img = SMImage::make($request->file('file'));
// Вызываем метод обрезки с указанными параметрами.
$img->crop(500, 500, 25, 50);
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath()
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->crop(500, 500, 25, 50)
    ->save()
    ->destroy();
```

## encode() - Кодирует изображение в определенный формат.

```php
use Smetaniny\LaravelImage\Facades\SMImage;
use Imagick;

/**
 * Кодирует изображение в определенный формат.
 *
 * @param string $format Формат, в который нужно закодировать изображение.
 * 
 * @return Image Возвращает объект изображения.
 */
@method encode(string $format): Image

// Получаем список форматов с которыми можем работать.
$imagickFormats = Imagick::queryFormats();

$img = SMImage::make($request->file('file'));
// Сохраняем оригинальный размер.
$img->save();

// Или более краткий вариант
SMImage::make($request->file('file'))->save();

// Кодирование в формат JPEG.
$img->encode('JPEG');
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();

// Кодирование в формат PNG.
$img->encode('PNG');
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();

// Кодирование в формат WebP.
$img->encode('WebP');
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();

// Кодирование в формат SVG.
$img->encode('SVG');
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

```

## orientate() - Изменяет ориентацию изображения.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

/**
 * Изменяет ориентацию изображения. Автоматически повернет изображение.
 * 
 * @return Image Возвращает объект изображения.
 */
@method orientate(): Image Изменяет ориентацию изображения.
Автоматически повернет изображение так, чтобы оно было правильно отображено.

// Создаем объект изображения.
$img = SMImage::make($img);
// Изменяет ориентацию изображения
$img->orientate();
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->orientate()
    ->save()
    ->getSavePath()
    ->destroy();
```

## rotate() - Поворачивает изображение на заданный угол.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

/**
 * Поворачивает изображение на заданный угол.
 *
 * @param int $angle Угол поворота в градусах.
 * 
 * @return Image Возвращает объект изображения.
 */
@method rotate(int $angle): Image

// Создаем объект изображения.
$img = SMImage::make($img);
// Поворачиваем изображение.
$img->rotate(45);
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->rotate(45)
    ->save()
    ->getSavePath()
    ->destroy();
```

## mirror() - Зеркально отражает изображение по горизонтали или вертикали.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Зеркально отражает изображение по горизонтали или вертикали.
 *
 * @param string $mode Режим отражения: 'h' для горизонтального, 'v' для вертикального.
 * 
 * @return Image Возвращает объект изображения.
 */
@method mirror(string $mode = 'h'): Image
    
// Создаем объект изображения.
$img = SMImage::make($img);
// Зеркально отражаем изображение.
$img->mirror();
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->mirror()
    ->save()
    ->getSavePath()
    ->destroy();
```

## blur() - Применяет размытие к изображению.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Применяет размытие к изображению.
 *
 * @param float $radius Радиус размытия (чем больше, тем сильнее размытие).
 * @param float $sigma Стандартное отклонение для гауссова размытия.
 */
@method blur(float $radius = 5, float $sigma = 1): Image
    
// Создаем объект изображения.
$img = SMImage::make($img);
// Размываем изображение.
$img->blur();
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->blur()
    ->save()
    ->getSavePath()
    ->destroy();
```

## brightness() - Регулирует яркость изображения.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Регулирует яркость изображения.
 *
 * @param float $brightness Уровень яркости (0 - оригинал, > 0 - увеличить, < 0 - уменьшить).
 */
@method brightness(float $brightness): Image
    
// Создаем объект изображения.
$img = SMImage::make($img);
// Регулируем яркость
$img->brightness(-25);
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->brightness(-25)
    ->save()
    ->getSavePath()
    ->destroy();
```

## contrast() - Регулирует контраст изображения.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Регулирует контраст изображения.
 *
 * @param float $contrast Уровень контраста (0 - оригинал, > 0 - увеличить, < 0 - уменьшить).
 * 
 * @return Image Возвращает объект изображения.
 */
@method contrast(float $contrast): Image
    
// Создаем объект изображения.
$img = SMImage::make($img);
// Регулируем контраст
$img->contrast(25);
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->contrast(25)
    ->save()
    ->getSavePath()
    ->destroy();
```

## grayscale() - Преобразует изображение в черно-белый (оттенки серого).

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Преобразует изображение в черно-белый (оттенки серого).
 * 
 * @return Image Возвращает объект изображения.
 */
@method grayscale(float $contrast): Image
    
// Создаем объект изображения.
$img = SMImage::make($img);
// Регулируем контраст
$img->grayscale();
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->grayscale()
    ->save()
    ->getSavePath()
    ->destroy();
```

## sharpen() - Применяет эффект заточки к изображению.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Применяет эффект заточки к изображению.
 *
 * @param float $amount Уровень заточки (чем больше, тем сильнее резкость).
 * @param float $radius Радиус заточки.
 * @param float $sigma Стандартное отклонение для гауссова заточки.
 * 
 * @return Image Возвращает объект изображения.
 */
@method sharpen(float $amount = 2, float $radius = 1, float $sigma = 0.5): Image
    
// Создаем объект изображения.
$img = SMImage::make($img);
// Регулируем контраст
$img->sharpen(50, 25, 20.5);
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make(
    $request->file('file'))
    ->sharpen(50, 25, 20.5)
    ->save()
    ->getSavePath()
    ->destroy();
```

## textoverlay() - Добавляет текстовое наложение на изображение.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Добавляет текстовое наложение на изображение.
 *
 * @param string $text Текст для наложения.
 * @param int $x Положение по оси X.
 * @param int $y Положение по оси Y.
 * @param string $font Путь к файлу шрифта.
 * @param int $fontSize Размер шрифта.
 * @param string $color Цвет текста в формате "#RRGGBB".
 * 
 * @return Image Возвращает объект изображения.
 */
@method textOverlay(
    string $text, 
    int $x, 
    int $y,
    string $font, 
    int $fontSize, 
    string $color = '#000000'
): Image
    
// Создаем объект изображения.
$img = SMImage::make($img);
$text = 'Пример текста';
$text2 = 'Пример текста 2';
// Путь до шрифта
$font = public_path('/ArialRegular.ttf');
// Устанавливаем текст
$img->textOverlay($text, 300, 300, $font, 44, '#FF0000');
// Устанавливаем текст 2
$img->textOverlay($text2, 300, 350, $font, 44, '#FF0000');
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->textOverlay($text, 300, 300, $font, 44, '#FF0000')
    ->textOverlay($text2, 300, 350, $font, 44, '#FF0000')
    ->save()
    ->getSavePath()
    ->destroy();
```

## watermark() - Добавляет водяной знак на изображение.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

/**
 * Добавляет водяной знак на изображение.
 *
 * @param string $watermarkPath Путь к файлу изображения водяного знака.
 * @param int $x Положение по оси X.
 * @param int $y Положение по оси Y.
 * @param int $opacity Прозрачность водяного знака (от 0 до 100).
 * 
 * @return Image Возвращает объект изображения.
 */
@method watermark(string $watermarkPath, int $x, int $y, int $opacity = 50): Image
    
// Создаем объект изображения.
$img = SMImage::make($img);
// Путь к файлу водяного знака
$watermarkPath = public_path('/watermark.png');
// Добавление водяного знака
$img->watermark($watermarkPath, 50, 100, 90);
// Сохраняем.
$img->save();
// Получаем путь.
$img->getSavePath();
// Очищаем.
$img->destroy();

// Или более краткий вариант
SMImage::make($request->file('file'))
    ->watermark($watermarkPath, 50, 100, 90)
    ->save()
    ->getSavePath()
    ->destroy();
```

## backup() - Создает резервную копию изображения.

```php
 /**
 * Создает резервную копию изображения.
 */
@method backup(): void

```

## reset() - Восстанавливает изображение из резервной копии.

```php
/**
 * Восстанавливает изображение из резервной копии.
 */
@method reset(): void
```

### Пример с командами backup() и reset()

```php
use Smetaniny\LaravelImage\Facades\SMImage;

$img = SMImage::make($request->file('file'));
// Создаем резервную копию.
$img->backup();
// Теперь проводим какие-то изменения.
$img->resize(300, null);
// Меняем имя файла.
$img->setFilename("thumb_300");
// Сохраняем
$img->save();
// Получаем путь
$img->getSavePath()
// Восстанавливаем изображение из резервной копии.
$img->reset();
// Меняем имя файла.
$img->setFilename("all");
// Сохраняем оригинальный размер.
$img->save();
// Получаем путь.
$img->getSavePath()
// Очищаем.
$img->destroy();
```

## response() - Создает HTTP-ответ на основе изображения.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

/**
 * Создает HTTP-ответ на основе изображения. Полезно, когда нужно вернуть изображение как ответ на запрос.
 *
 * @param array $headers Заголовки ответа.
 * 
 * @return Response HTTP-ответ.
 */
@method response(array $headers= []): Response

// Создаем объект изображения.
$img = SMImage::make($img);
// Создаем HTTP-ответ с использованием метода response.
$response = $img->response(['Content-Type' => 'image/jpeg']);
```

## stream() - Выводит изображение в виде потока.

```php
use Smetaniny\LaravelImage\Facades\SMImage;

 /**
 * Выводит изображение в виде потока. 
 * Полезен, когда нужно передать большие файлы клиенту минимизируя использование памяти.
 *
 * @param array $headers Заголовки ответа.
 * 
 * @return StreamedResponse Потоковый HTTP-ответ.
 */
@method stream(array $headers = []): StreamedResponse

// Создаем объект изображения.
$img = SMImage::make($img);
// Создаем HTTP-ответ с использованием метода stream.
$response = $img->stream(['Content-Type' => 'image/jpeg']);
```

### Создание пользовательских команд

```php
// Создаем класс команды. Данная команда реализована в пакете и несет информационный характер.
namespace App\Http\Controllers;

use ImagickException;
use Smetaniny\LaravelImage\Contracts\Image;
use Smetaniny\LaravelImage\Image;
use Smetaniny\LaravelImage\Facades\SMImage;

class FlipCommand extends Image implements Image
{
    /**
     * Обрабатывает отражение изображения по горизонтали или вертикали.
     *
     * @param string $mode Режим отражения: 'h' для горизонтального, 'v' для вертикального.
     *
     * @return Image Возвращает объект изображения после отражения.
     * @throws ImagickException Исключение, если произошла ошибка Imagick при кодировании изображения.
     */
    public function execute(string $mode = 'h'): Image
    {
        // Получаем ресурс изображения.
        $imagick = $image->getImageResource();

        // Отражаем изображение в зависимости от режима.
        if ($mode === 'h') {
            $imagick->flopImage();
        } elseif ($mode === 'v') {
            $imagick->flipImage();
        }

        // Обновляем ресурс изображения в текущем объекте $image.
        $image->setImageResource($imagick);

        return $image;
    }
}

# Применение пользовательской команды.
namespace App\Http\Controllers;
use Smetaniny\LaravelImage\Facades\SMImage;

class MainController
{
    public function index()
    {
        # Создание объекта изображения на основе данных, предоставленных UploadedFile.
        $img = SMImage::make($request->file('file'));
        # Регистрируем команду.
        $img->registerCommand('flip', '\App\Http\Controllers\FlipCommand');
        # Применяем команду.
        $img->flip();
       // Сохраняем.
        $img->save();
        // Получаем путь.
        $img->getSavePath();
        // Очищаем.
        $img->destroy();
    }
}
```

## Семантическое Версионирование

Версии проекта имеют формат X.Y.Z, где:

- **X (Мажорная версия):** Мажорная версия увеличивается, когда внесены изменения, которые могут нарушить обратную
  совместимость.

- **Y (Минорная версия):** Минорная версия увеличивается, когда добавлены новые возможности с обратной совместимостью.

- **Z (Патч):** Патч увеличивается, когда внесены исправления без изменения обратной совместимости.

Пример изменения версии 1.2.3:

- **1 (Мажорная версия):** Основные изменения, возможно, несовместимые с предыдущими версиями.

- **2 (Минорная версия):** Добавление новых функций, совместимых с предыдущей версией.

- **3 (Патч):** Исправление ошибок, совместимое с предыдущей версией.

Если у вас остались вопросы, вы можете задать их в [телеграм](https://t.me/sm_sergey_v)


