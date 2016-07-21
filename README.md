# JBZoo CrossCMS  [![Build Status](https://travis-ci.org/JBZoo/CrossCMS.svg?branch=master)](https://travis-ci.org/JBZoo/CrossCMS)      [![Coverage Status](https://coveralls.io/repos/JBZoo/CrossCMS/badge.svg?branch=master&service=github)](https://coveralls.io/github/JBZoo/CrossCMS?branch=master)

#### Одно расширение, один код — разные CMS!

[![License](https://poser.pugx.org/JBZoo/CrossCMS/license)](https://packagist.org/packages/JBZoo/CrossCMS)
[![Latest Stable Version](https://poser.pugx.org/JBZoo/CrossCMS/v/stable)](https://packagist.org/packages/JBZoo/CrossCMS) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JBZoo/CrossCMS/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JBZoo/CrossCMS/?branch=master)

_English readme is coming soon!_


### Описание
CrossCMS — это набор простых хелперов, который поможет абстрагироваться от фреймворка CMS и разработать свое расширение так, чтобы один и тот же код мог работать одновременно на совершенно разных платформах.
Т.е. разработчику будет все равно в рамках какой системы работает его расширение (код) - он пишет один раз и запускает одинаковый(!) набор тестов для двух разных CMS.
 
По большому счету, библиотека приводит совершенно разное API систем к общему виду, скрывая разницу внутри себя.
Стоит рассматривать это как глобальное переименование основных функций CMS (хотя это чуть сложнее).
Более того, библиотека не несет в себе каких-то конкретных реализаций функций. 99.9% возможностей - это все реализация из CMS.
Таким образом, практически нет оверхеда по памяти и производительности вашего расширения.
 
CrossCMS был создан для расширения [JBZoo CCK](http://jbzoo.ru/) (конструктор контента) 3-й версии и на данный момент прекрасно справляется со своей задачей.
Т.е. буквально один и тот же код одновременно работает в разных CMS.
Проект можно увидеть в репозитории [JBZoo/JBZoo](https://github.com/JBZoo/JBZoo).
Он так же проходит одинаковый набор юнит-тестов для двух разных CMS (без моков, стабов итд) с покрытием около 90%!
 
 
### Тестирование
Чтобы убедиться, что CrossCMS ведет себя одинакового внезависимости от платформы мы запускаем одинаковый набор юнит-тестов на PHP от v5.4 до v7.0
**_В тестах нет моков или стабов!_** Код проверяется внутри реальной CMS последней версии, которая скачивается из официального репозитория. 

Узкие места, которые могут сильно повлиять на производительность сайта, протестированы бенчмарками. Например вызов локализации текстовых констант.
См тесты [BenchmarkTest.php](https://github.com/JBZoo/CrossCMS/blob/master/tests/tests/BenchmarkTest.php) Результат видно в [консоли PHPUnit](https://travis-ci.org/JBZoo/CrossCMS/jobs/141018021#L535) .

**Внимание:** Обычно последняя dev-версия из master не проходит тесты, т.к. там очень часто тестируются новые вещи. [Но все теги (релизы) проверены и работают!](https://travis-ci.org/JBZoo/CrossCMS/branches)  


### Поддержка CMS и версии 
На данный момент библиотека протестирована и работает для

 * Joomla CMS: 3.4.x ... 3.6.x
 * Wordpress: 4.2.x ... 4.5.x


### Панель управления
Полноценное расширение стоит разрабатывать с учетом, что интерфейс панелей управления у CMS разный (CSS, JS, верстка и т.д.)
Для этого рекомендуется использовать подход с [RESTful](https://ru.wikipedia.org/wiki/REST) + [Reactjs](https://facebook.github.io/react/) + [Redux](http://redux.js.org/) (или [Flux](https://facebook.github.io/flux/) ) + [Material-UI](http://www.material-ui.com/). Взамен вы автоматически получаете готовое протестированное API по HTTP и легкость портирования на мобильную платформу (если интерфейс сделан на Material-UI).

Material-UI выбран не случайно. Он позволяет быстро создавать интерфейс панели управления и в данном случае будет очень полезен из-за подхода с инлайн-стилями.
Крайне высокая специфичность инлайн-стилей позволяет изолировать внешний вид расширения от любого CSS-фреймворка в панели управления CMS, таким образом мы избавляемся от конфликтов в CSS/JS.

Все это касается панели управления (back-end), рендеринг страниц для front-end принципиально ничем не отличается и тут все технологии на усмотрение разработчиков расширения.  


### Организация кода
Думаю вы об этом уже подумали. Да, все верно. Т.к. мы предлагаем разрабатывать один и тот же код для разных CMS, то мы в принципе не сможем следовать гайдлайнам этих CMS.
(Примечание автора: В случае с Wordpress - это огромный плюс!). Как вариант, вы можете использовать подход к организации своего кода как в проекте [JBZoo 3.x-dev](https://github.com/JBZoo/JBZoo). Этот нюанс можно рассматривать как обязательную плату за _кроссплатформенность_.


### Примечания, мифы и реальность
 * Не получится просто так взять и портировать любое расширение на другую CMS. Желательно чтобы оно было написано сразу с помощью CrossCMS.
 * На данный момент CrossCMS позволяет избавиться от разницы только для серверной части кода (PHP).
 * Не все хелперы еще реализованы (см TODO), но те что есть уже сейчас позволяют разработать достаточно большое кроссплатформенное решение. 
 * На первых парах ощутимая разница (в PHP) будет чувствоваться в инсталяторе, ссылках к расширению и тестировании. Очень много головной боли уже решено в [JBZoo 3.x-dev](https://github.com/JBZoo/JBZoo) и главное проверено различными тестами.
 * Рекомендуется весь код писать через TDD и покрывать тестами как можно больше. Таким образом вы сэкономите на одинаковом тестировании в разных CMS. 
 

## Документация

#### Установка

Ничем не отличается от любой другой современной библиотеки PHP
```sh
composer require jbzoo/crosscms
```


#### Главный DI-контейнер
По большому счету, библиотека представляет из себя набор хелперов, который хранится и вызывается через DI-контейнер [Pimple](http://pimple.sensiolabs.org/).
Так мы можем сэкономить на инициализации хелперов и легко переопределять, расширять библиотеку.
Каждый хелпер — это группа функций, которая отвечает только за свою область действий: база данных, статика, пользователь, реквест и т.д.

Чтобы начать работать с CrossCMS достаточно подключить composer autoload и получить инстанс приложения.
Свой код можно расположить в плагине CMS, например сразу после инициализации фреймворка. 
 
```php
use JBZoo\CrossCMS\Cms;

require_once './vendor/autoload.php';
$cms = Cms::getInstance(); // Получаем DI-контейнер с хелперами. Он уже полностью проинициализирован.
```

Вам ничего не мешает наследоваться от класса `Cms` или расширять его своими хелперами как обычный контейнер.
Так же среди юнит-тестов вы сможете найти примеры использования библиотеки.


#### Автодополнение кода
Автор для разработки использует [PhpStorm IDE](https://www.jetbrains.com/phpstorm/) (и другим советует). Чтобы не писать код "вслепую" без автодополнения, рекомендуется использовать [плагин для Silex](https://plugins.jetbrains.com/plugin/7809).
Установите его, активируйте и положите файл `pimple.json` в корень проекта. Этот файл - это результат работы библиотеки [JBZoo/PimpleDumper](https://github.com/JBZoo/PimpleDumper).
После этого у вас появится полноценное автодополнение для переменной `$cms`.  


#### Работа с кешем
Используем драйвер кеширования, который предоставляет CMS.

```php
$cms = Cms::getInstance();

// Вкючен ли кеш в настройках CMS
$cms['cache']->isEnabled();

// Сохраняем переменную в кеш
$cms['cache']->set($key, $data, $group, $isForce, $ttl);

// Берем переменную из кеша
$cms['cache']->get($key, $group);

// Сохраняем в кеш буфер вывода - http://php.net/manual/ru/ref.outcontrol.php
$cms['cache']->start($key, $data, $group, $isForce, $ttl);

// Берем буфер вывода из кеша
$cms['cache']->end($key, $group);
```

Пример использования
```php
$cms = Cms::getInstance();

$myVar = $cms['cache']->get('some-var');
if (!$myVar) {
    $myVar = someHardcoreFunction();
    $cms['cache']->set('some-var', $myVar);
}
```

#### Основные настройки сайта
Получаем основные настройки сайта

```php
$cms = Cms::getInstance();

$cms['config']->isDebug();  // Режим отладки включен?
$cms['config']->sitename(); // Название сайта
$cms['config']->sitedesc(); // Описание сайта
$cms['config']->email();    // Главная почта, которой подписывается сайт
$cms['config']->dbHost();   // Хост БД
$cms['config']->dbName();   // Имя БД
$cms['config']->dbUser();   // Пользователь БД
$cms['config']->dbPass();   // Пароль БД
$cms['config']->dbPrefix(); // Префикс для имен таблиц в БД
$cms['config']->dbType();   // Тип драйвера БД
$cms['config']->timezone(); // Часовой пояс сайта
```


#### Работа с базой данных
Совместно с хелпером БД рекомендуем использовать [SqlBuilder](https://github.com/JBZoo/SqlBuilder). Это простой и безопасный билдер SQL-запросов, совместимый с CrossCMS.
Если запрос не смог выполнится, то CMS бросит исключение (Joomla) или вызовет Die (Wordpress).

```php
$cms = Cms::getInstance();

$select = 'SELECT PI() AS pi';

$cms['db']->fetchAll($select);          // [['pi' => '3.141593']] 
$cms['db']->fetchRow($select);          // ['pi' => '3.141593']
$cms['db']->fetchArray($select);        // ['3.141593']
$cms['db']->query($select);             // Result: (int)1 - expected rows
$cms['db']->escape(' abc123-+\'"` ');   // ' abc123-+\\\'\"` ' - Т.е получим безопасную строку для SQL средствами CMS
$cms['db']->insertId();                 // Узнать последний ID после успешного INSERT
$cms['db']->getTableColumns('#__table') // Список колонок в таблице
```


#### Работа с датами
Хелпер позволяет учитывать часовой пояс сайта и особенности локализаций в CMS. Поддерживает готовые форматы вывода даты.
Функция `format()` умеет парсить наиболее популярные форматы даты с помощью [JBZoo/Utils](https://github.com/JBZoo/Utils/blob/master/src/Dates.php), включая стандартные объекты времени PHP. 

```php
$cms = Cms::getInstance();
$time = '2011-12-13 01:02:03';              // Дата в популярном формате   
$time = '1323738123';                       // или в секундах

$cms['date']->format($time);                // '2011-12-13 01:02:03' (Sql is default)
$cms['date']->format($time, 'timestamp');   // (int)1323738123 Формат штампа
$cms['date']->format($time, 'detail');      // 'Tuesday, Dec 13 2011 01:02' - Детальный формат
$cms['date']->format($time, 'full');        // 'Tuesday, Dec 13 2011' - Полный формат
$cms['date']->format($time, 'long')         // '13 December, 2011' - Длинная запись даты
$cms['date']->format($time, 'medium')       // 'Dec 13, 2011' - Средняя длина записи
$cms['date']->format($time, 'short');       // '12/13/11' - Короткий формат
$cms['date']->format($time, 'time')         // '01:02' - Только время
```


#### Проверка окружения, в котором работает сайт и расширение

```php
$cms = Cms::getInstance();

$cms['env']->getVersion();  // Версия CMS
$cms['env']->isAdmin();     // Сайт работает в режиме панели управления (back-end)?
$cms['env']->isSite();      // Сайт работает в обычном режиме (front-end)?
$cms['env']->isCli();       // Сайт запущен из командной строки ?
$cms['env']->getRootUrl();  // Ссылка на главную страницу сайта
```


#### Работа с событиями (триггеры, фильтры)
Для унификации CrossCMS использует простейший и очень легковесный менеджер событий [JBZoo/Event](https://github.com/JBZoo/Event). Минимум кода - [Всего один файл](https://github.com/JBZoo/Event/blob/master/src/EventManager.php).
На данный момент для JBZoo актуален только небольшой набор событий из CMS. Ничего не мешает использовать хелпер для собственных событий.
В JBZoo, например, вызываются около сотни разных триггеров с огромным запасом на будущее. Скорость работы триггров согласно тестированию примерно [2 мили секунды на 1000 $cms->trigger()](https://travis-ci.org/JBZoo/Event/jobs/125544543#L345). Т.е это очень быстрая и оптимизированная вещь! 

Примеры
```php
use JBZoo\CrossCMS\AbstractEvents;

$cms = Cms::getInstance();

$noopCallback = function(){ /* some action */};

$cms->on(AbstractEvents::EVENT_INIT, $noopCallback);    // Инициализация фреймворка
$cms->on(AbstractEvents::EVENT_CONTENT, $noopCallback); // Парсиннг контента, например ищем макросы
$cms->on(AbstractEvents::EVENT_HEADER, $noopCallback);  // Рендеринг блока head
$cms->on(AbstractEvents::EVENT_SHUTDOWN, $noopCallback);// CMS завершила работу
```

С помощью специальных постфиксов можно подписаться на события только для панели управления или только для сайта.
```php
$cms->on(AbstractEvents::EVENT_INIT.'.admin', $noopCallback);   // Инит фрейма ТОЛЬКО для админки 
$cms->on(AbstractEvents::EVENT_INIT.'.site', $noopCallback);    // Инит фрейма ТОЛЬКО для сайта 
```

Пример кода для подключения системных событий к CrossCMS (в комментариях)

 * [Для Joomla](https://github.com/JBZoo/CrossCMS/blob/master/src/Joomla/Events.php)
 * [Для Wordpress](https://github.com/JBZoo/CrossCMS/blob/master/src/Wordpress/Events.php)


#### Работа с тегом HEAD и подключение статики (CSS/JS)
Для работы с большим кол-вом статики рекомендуем использовать [JBZoo/Assets](https://github.com/JBZoo/Assets).
Он поможет подключать файлы в нужном порядке и не следить за зависимостями (например, Timepicker - jQueryUI.Datepicker - jQuery)
 
```php
$cms = Cms::getInstance();

$cms['header']->setTitle($title);               // Устанавливает заголовок страницы
$cms['header']->setDesc($description);          // Новое описание страницы
$cms['header']->setKeywords($keywords);         // Новые ключевые слова (мета тег)
$cms['header']->addMeta($meta, $value = null);  // Произвольный мета тег (например, Open Graph)
$cms['header']->noindex();                      // Закрываем страницу от индексации
$cms['header']->jsFile($file);                  // Подключаем на страницу произвольный JS файл (ссылка)
$cms['header']->jsCode($code);                  // Произвольный JS код в <head> сайта. Например, инициализация виджетов.
$cms['header']->cssFile($file);                 // Подключаем на страницу произвольный файл стилей CSS (ссылка)
$cms['header']->cssCode($code);                 // Произвольный стиль в <head> сайта. Например, динамический цвет фон из PHP переменной.
```


#### HTTP-запросы к сервисам вне сайта
Объединяет сложные реализации HTTP-клиентов и драйверов в один метод, скрывает драйвер запроса и помогает кешировать ответ.

```php
$cms = Cms::getInstance();

$response = $cms['http']->request('http://site.com/path');  // Только первый аргумент обзятельный

$response = $cms['http']->request(
    'http://site.com/path',                                 // Адрес сервиса, можно с GET-параметрами
    [                                                       // GET/POST - переменные
        'var-1' => 'value-1',
        'var-2' => 'value-2',
    ],
    [                                                       // Дополнительные опции
        'timeout'    => 5,                                  // Максимальное время ожидания ответа в секундах. 
        'method'     => 'GET',                              // Типа запроса (GET|POST|HEAD|PUT|DELETE|OPTIONS|PATCH)  
        'headers'    => [                                   // Заголовки запроса
            'x-custom-header' => '42',
        ],                             
        'response'   => 'full',                             // Формат ответа (full|body|headers|code) 
        'cache'      => 0,                                  // Включить кеширование (смотри $cms['cache']) 
        'cache_ttl'  => 60,                                 // Время кеширования в минутах, если включено  
        'user_agent' => 'CrossCMS HTTP Client',             // Добавить свой заголовок USER_AGENT  
        'ssl_verify' => 1,                                  // Проверять ssl сертификат (полезно для Wordpress) 
        'debug'      => 0,                                  // Режим отладки (доп текст сообщений в ошибках, если он есть в CMS) 
    ]
);

// Вариант ответа для ['response' => 'full'] 
$response->code;     // HTTP код. Например, (int)200
$response->headers;  // Массив заголовков в ответе, ключ => значение
$response->body;     // Строка тела ответа
```


#### Работа с локализациями
У каждой платформы используется своя система локализаций (po, ini итд). 
CrossCMS использует их через API. Если значение переменной с помощью [JBZoo/Lang](https://github.com/JBZoo/Lang) не найдено, то ищет уже в CMS.
Это позволяет использовать свои локализации или брать их из CMS.

Т.к. у нас один код для обоих расширений, то мы рекомендуем использовать свои локализации [в любом доступном формате](https://github.com/JBZoo/Data), PHPArray - самый быстрый и надежный.
Это не обязательное условие.

```php
$cms = Cms::getInstance();

echo $cms['lang']->translate('january');                        // "January" | "Январь"
echo $cms['lang']->translate('%s and %s', 'qwerty', 123456));   // "qwerty and 123456" | 'qwerty и 123456'

// Короткая функция
function _text($message) {
    $cms = Cms::getInstance();
    return call_user_func_array(array($cms['lang'], 'translate'), func_get_args());
}

echo _text('january');                      // "January" | "Январь"
echo _text('%s and %s', 'qwerty', 123456)); // "qwerty and 123456" | 'qwerty и 123456'
```


#### Работа со встроенными библиотеками CMS
Обычно во всех популярных CMS есть общий набор JS-библиотек. 
Нет смысла подключать свой jQuery, когда есть встроенный. Так мы избежим классических конфликтов с другими расширениями.

```php
$cms = Cms::getInstance();

$cms['libs']->jQuery();             // Подключает на страницу коробочный jQuery
$cms['libs']->jQueryUI();
$cms['libs']->jQueryAutocomplete();
$cms['libs']->jQueryDatePicker();
$cms['libs']->colorPicker();
```


#### Отправка почтовых сообщений
Враппер над функциями отправки писем. Используется драйвер из CMS.
Ошибки вызывают исключение.

```php
$cms = Cms::getInstance();
$mail = $cms['mailer'];

$mail->clean(); // Чистим состояние перед созданием нового письма

$mail->setTo('admin@example.com');                      // Кому 
$mail->setSubject('Test message subject');              // Название письма
$mail->setBody('<p>Simple test</p>');                   // Текст сообщения
$mail->isHtml(false);                                   // Включить или выключить заголовок HTML в письме
$mail->setFrom('no-replay@example.com', 'Website name'); // От кого

$mail->setHeader('Cc', 'John Smith <john@smith.org>');  // Один произвольный заголовок 
$mail->setHeaders([                                     // Произвольные заголовки
    'Cc'  => 'John Smith <john@smith.org>',
    'Bcc' => 'Mike Smith <mike@smith.org>'
]);

// Добавляем аттач
$mail->addAttachment('/full/file/path.zip', 'Some custom name'); 
        
$mail->send(); // Отправляем подготовленное письмо (return true|false)        
```
        
Короткий вариант
```php
$mail->complex('admin@example.com', 'Test message subject', 'Test complex method');
```


#### Работа с путями CMS
Мы используем виртуальную файловую систему на основе библиотеки [JBZoo/Path](https://github.com/JBZoo/Path).
Идеи взяты из [хелпера path в компонента ZOO](https://github.com/JBZoo/Zoo-Changelog/blob/master/packages/com_zoo/admin/framework/helpers/path.php).
Подход позволяет регистрировать один или несколько файловых путей под ключевым словом и таким образом работать со множествами путей одной командой или переопределять пути в системе "на лету". 
Вы можете не использовать этот подход, а просто получать значения и все. 

**Примечание:** Для Wordpress желательно (но не обязательно) создать в корне `cache|logs|tmp` т.к. там нет аналогов.

```php
$cms = Cms::getInstance();

$cms['path']->get('root:');     // Корень сайта
$cms['path']->get('upload:);    // Место для загрузок файлов
$cms['path']->get('tmpl:');     // Шаблоны
$cms['path']->get('cache:');    // Файловый кеш
$cms['path']->get('logs:');     // Логи сайта
$cms['path']->get('tmp:');      // Временная папка

$cms['path']->get('tmp:my-file.txt');         // Обращение к файлу из временной папки 
$cms['path']->get('tmp:folder/my-file.txt');  // Обращение к файлу из временной папки из вложенной директории 
```


#### Работа с переменными из реквеста ($_GET, $_POST, и т.д.)
CrossCMS никак не обрабатывает переменные из реквеста и по возможности полагается на фильтрацию значений в CMS.
Тем не менее библиотека предоставляет простейшие кастомные фильтры с помощью библиотеки [JBZoo/Utils](https://github.com/JBZoo/Utils/blob/master/src/Filter.php).  

```php
$cms = Cms::getInstance();

$cms['request']->getMethod();                   // Текущий метод запроса 
$cms['request']->isGet();                       // Это GET запрос? 
$cms['request']->isPost();                      // Это POST запрос?
$cms['request']->isAjax();                      // Это AJAX запрос? 
$cms['request']->getUri();                      // Текущий адрес страницы 
$cms['request']->checkToken();                  // Проверить сессионный токен (для форм против XSS) 
$cms['request']->getHeader('x-custom-header');  // Получить значение из HTTP-заголовка 
 
$cms['request']->set($name, $value);            // Установить значение в реквест

$cms['request']->get('foo', '42');                       // Получить переменную из реквеста. Если её нет, то использовать значение по умолчанию.
$cms['request']->get('foo', null, 'trim');               // Использовать фильтр (триммер) из JBZoo/Utils/Filter
$cms['request']->get('foo', null, 'trim, alias, float'); // Использовать несколько фильтров подряд из JBZoo/Utils/Filter
$cms['request']->get('foo', null, function ($value) {    // Своя, особая обработка переменной из реквеста 
    $value = str_replace('124', '789', $value);
    return $value;
}));
```


#### Работа с ответом CMS в браузер 
Хелпер позволяет переопределять формат и заголовки ответа. Например, можно отправить JSON или сделать редирект.
 
```php
$cms = Cms::getInstance();

$cms['response']->set404($message);            // Страница не найдена
$cms['response']->set500($message);            // Фатальная ошибка
$cms['response']->redirect($url, 301);         // Редирект и его код
$cms['response']->json(array $data = array()); // Отправить ответ в JSON-формате
$cms['response']->text();                      // Установить текстовый формат вывода (Content-Type: text)
$cms['response']->noCache();                   // Насильно отключаем кеширование через заголовки
$cms['response']->setHeader($name, $value);    // Устанавливаем произвольный заголовок
```


#### Работа с сессиями
Использует драйвер управления сессиями из CMS (если есть).
По умолчанию работает с группой переменных т.е `$group = 'jbzoo'` (создает свой массив переменных), чтобы не конфликтовать с другими расширениями.

```php
$cms = Cms::getInstance();

$cms['session']->has($key);                                         // Проверяет существование переменной
$cms['session']->get($key, $default, $group);                       // Получить переменную либо значение по умолчанию
$cms['session']->set($key, $value, $group);                         // Установить переменную
$cms['session']->getGroup($group, $default);                        // Получить группу переменных или массив значений по умолчанию 
$cms['session']->setGroup($group, array $data, $isFullReplace);     // Установить несколько переменных (группу)
$cms['session']->clear($key, $group);                               // Удалить переменную
$cms['session']->clearGroup($group);                                // Удалить группу переменных  
$cms['session']->getToken();                                        // Получить токен сессии (для защиты XSS)
```


#### Работа с пользователями
Пользователи в разных CMS - это обычно сущности и их реализация очень сильно разнится.
Сейчас это единственная вещь, которая требует для себя отдельную сущность. Все остальные действия - это вызов методов из хелперов без явного контекста. 
CrossCMS предлагает использовать для работы с пользователями [свою упрощенную сущность](https://github.com/JBZoo/CrossCMS/blob/master/src/Entity/User.php).

Например, получим текущего пользователя и узнаем его свойства 
```php
$cms = Cms::getInstance();
$user = $cms['user']->getCurrent();

$user->isGuest();               // Это аноним?
$user->isAdmin();               // Это главный админ?
$user->getEmail();              // Получить Email из профиля
$user->getLogin();              // Логин для авторизации
$user->getName();               // Имя пользователя 
$user->getId();                 // Его системный ID
$user->$user->getAvatar(128);   // Получить аватар 128*128px на основе сервиса gravatar.com
```


#### Примеры расширений
Примеры плагинов для Wordpress

 * [JBZoo 3.x-dev](https://github.com/JBZoo/JBZoo/tree/master/src/wordpress/jbzoo) 
 * [JBZoo 3.x-dev для юнит-тестов](https://github.com/JBZoo/JBZoo/tree/master/tests/extentions/wp_jbzoophpunit) 
 * [CrossCMS для юнит-тестов](https://github.com/JBZoo/CrossCMS/tree/master/tests/extentions/wp-plugin) 

Примеры плагинов/компонентов для Joomla

 * [JBZoo 3.x-dev](https://github.com/JBZoo/JBZoo/tree/master/src/joomla/plg_sys_jbzoocck) 
 * [JBZoo 3.x-dev для юнит-тестов](https://github.com/JBZoo/JBZoo/tree/master/tests/extentions/j_jbzoophpunit) 
 * [CrossCMS для юнит-тестов](https://github.com/JBZoo/CrossCMS/tree/master/tests/extentions/joomla-plugin) 


## TODO
 * Пример маленького расширения на CrossCMS (соц. кнопки)
 * Работа с правами и уровнями доступа
 * Больше функций для пользователей (авторизация, активация, регистрация, изменения прав итд )
 * Добавить поддержку PageKit CMS
 * Добавить поддержку OctoberCMS
 * Добавить поддержку "NO_CMS", т.е. расширение работает без фреймворка (очень-очень-очень урезанное API)


## О CrossCMS в прессе
 * [Joomlaportal.ru - Превосходство Joomla API над Wordpress](http://joomlaportal.ru/blogs/development/2598-prevoskhodstvo-api-joomla-nad-wordpress)
 * [Joomlaportal.ru - CrossCMS от JBZoo](http://joomlaportal.ru/news/extensions/2743-crosscms-ot-jbzoo)
 * [JBZoo.ru - Краткая презентация CrossCMS на Joomla!Day Moscow 2016](http://jbzoo.ru/blog/joomladay-2016-review) 

## Лицензия

MIT
