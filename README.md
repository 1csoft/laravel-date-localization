# Локализация дат в Laravel
Локализацию можно устроить 2 способами.
1) setlocale(LC_TIME, 'ru_RU.UTF-8') и тогда carbon должен понимать все на русском. Но это если на серваке установлены соответствующие локали в ОС.
2) Когда нет возможности или желания возиться с установнокй локалей, то можно ставить этот пакет.

```shell script
composer require soft1c/laravel-date-localization
```

После установки можно юзать как

```php
Soft1c\Date\Date::today()->format('j F Yг.'); // -> 6 мартa 2020г.
```

Класс наследуется от Illuminate\Support\Carbon и потому в нем доступны все методы стандартного Carbon.

Можно вписать еще и фасадом в config/app.php

```php
'Date' => Soft1c\Date\Date::class,
```

## Поддерживаемые языки
* Albanian
* Arabic
* Azerbaijani
* Bangla
* Basque
* Belarusian
* Bosnian
* Brazilian Portuguese
* Bulgarian
* Catalan
* Croatian
* Chinese Simplified
* Chinese Traditional
* Czech
* Danish
* Dutch
* English
* Esperanto
* Estonian
* Finnish
* French
* Galician
* Georgian
* German
* Greek
* Hebrew
* Hindi
* Hungarian
* Icelandic
* Indonesian
* Italian
* Japanese
* Kazakh
* Korean
* Latvian
* Lithuanian
* Macedonian
* Malay
* Norwegian
* Nepali (नेपाली)
* Polish
* Portuguese
* Persian (Farsi)
* Romanian
* Russian
* Thai
* Serbian (latin)
* Serbian (cyrillic)
* Slovak
* Slovenian
* Spanish
* Swedish
* Turkish
* Turkmen
* Ukrainian
* Uzbek
* Vietnamese
* Welsh

## Пример использования
```php
use Soft1c\Date\Date;
Date::setLocale('nl');
echo Date::now()->format('j F Yг.'); // -> 6 мартa 2020г.
echo Date::parse('-1 day')->diffForHumans(); // -> 1 день назад
echo Date::parse('-6 day')->diffForHumans(); // -> 6 дней назад
echo Date::parse('-16 day')->diffForHumans(); // -> 2 недели назад
echo Date::parse('-2 hour')->diffForHumans(); // -> 2 часа назад
```

Carbon-это библиотека, на которой основан класс Date. 

Все операции доступны как в оригинальном Carbon, посмотрите https://github.com/briannesbitt/Carbon для получения дополнительной информации.
