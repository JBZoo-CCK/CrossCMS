# JBZoo CrossCMS  [![Build Status](https://travis-ci.org/JBZoo/CrossCMS.svg?branch=master)](https://travis-ci.org/JBZoo/CrossCMS)      [![Coverage Status](https://coveralls.io/repos/github/JBZoo/CrossCMS/badge.svg?branch=master)](https://coveralls.io/github/JBZoo/CrossCMS?branch=master)

#### One extention, one code — different CMS!

[![License](https://poser.pugx.org/JBZoo/CrossCMS/license)](https://packagist.org/packages/JBZoo/CrossCMS)
[![Latest Stable Version](https://poser.pugx.org/JBZoo/CrossCMS/v/stable)](https://packagist.org/packages/JBZoo/CrossCMS) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JBZoo/CrossCMS/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JBZoo/CrossCMS/?branch=master)


[RUSSIAN README !](https://github.com/JBZoo/CrossCMS/blob/master/README_RUS.md)


### Description
CrossCMS it's collection of simple helpers, which helps you to create one cross platform extension for Joomla and WordPress. So developer writes code once and runs the same tests for two different CMS.

This library is result of combining different API systems to general appearance concealing the difference within yourself. It is necessary to consider it as a global renaming of the main functions of CMS (though it is a bit more complicated). Moreover, the library does not carry any specific implementations of functions. So, there is little overhead and memory performance for your extension.

CrossCMS was created for [JBZoo CCK](http://jbzoo.com/) (Content Constructor Kit) and it works fine.
You can find project in the repository [JBZoo/JBZoo](https://github.com/JBZoo/JBZoo).


### Testing

For testing we are running same set of unit tests in PHP from v5.4 to v7.0 **without any mocks or stubs!**.
Only real CMS last versions, only hardcore!

```sh
make
make server
make test-all
```


### Support of CMS 

 * Joomla CMS: 3.4.x ... 3.6.x
 * Wordpress: 4.2.x ... 4.5.x


## Documentation

#### Install

Just use the composer
```sh
composer require jbzoo/crosscms
```


#### Main container

[Pimple DI](http://pimple.sensiolabs.org/) contains all helpers. 

Starting to use CrossCMS.  
```php
use JBZoo\CrossCMS\Cms;

require_once './vendor/autoload.php';
$cms = Cms::getInstance(); // Create or Get DI-singleton with helpers. It's ready to use! 
```

#### Autocomplete

We are using [PhpStorm IDE](https://www.jetbrains.com/phpstorm/), so we recommend you to install [plugin for Silex](https://plugins.jetbrains.com/plugin/7809) and copy file `pimple.json` to the root of your project. The file is result of [JBZoo/PimpleDumper](https://github.com/JBZoo/PimpleDumper).


#### Work with cache
CrossCMS uses only CMS drivers and API for caching anything.

```php
$cms = Cms::getInstance();

// Check is cache enabled
$cms['cache']->isEnabled();

// Store variable to cache
$cms['cache']->set($key, $data, $group, $isForce, $ttl);

// Get variable from cache
$cms['cache']->get($key, $group);

// Store output buffer, See http://php.net/manual/ru/ref.outcontrol.php
$cms['cache']->start($key, $data, $group, $isForce, $ttl);

// Get output buffer from cache
$cms['cache']->end($key, $group);
```

Example
```php
$cms = Cms::getInstance();

$myVar = $cms['cache']->get('some-var');
if (!$myVar) {
    $myVar = someHardcoreFunction(); // Too slow code
    $cms['cache']->set('some-var', $myVar);
}

echo $myVar; // Use it!
```

#### General site properties

```php
$cms = Cms::getInstance();

$cms['config']->isDebug(); 
$cms['config']->sitename();
$cms['config']->sitedesc();
$cms['config']->email();   
$cms['config']->dbHost();  
$cms['config']->dbName();  
$cms['config']->dbUser();  
$cms['config']->dbPass();  
$cms['config']->dbPrefix();
$cms['config']->dbType();  
$cms['config']->timezone();
```


#### Database

We recommend you to use [SqlBuilder](https://github.com/JBZoo/SqlBuilder) with the database helper.
This is a simple and secure SQL-queries builder compatible with CrossCMS, Joomla and Wordperss. It's not required. Only if you wish.
If an error occurs, CMS will throw an exception (Joomla), or cause Die (Wordpress).

```php
$cms = Cms::getInstance();

$select = 'SELECT PI() AS pi';

$cms['db']->fetchAll($select);          // [['pi' => '3.141593']] 
$cms['db']->fetchRow($select);          // ['pi' => '3.141593']
$cms['db']->fetchArray($select);        // ['3.141593']
$cms['db']->query($select);             // Result: (int)1 - expected rows
$cms['db']->escape(' abc123-+\'"` ');   // ' abc123-+\\\'\"` ' - Т.е получим безопасную строку для SQL средствами CMS
$cms['db']->insertId();                 // Get last Primary ID after INSERT
$cms['db']->getTableColumns('#__table') // Table columns 
```


#### Dates

Helper allows you to get time in different formats (check timezone and localisation). It support pre defined date formats.
We are using helper [JBZoo/Utils](https://github.com/JBZoo/Utils/blob/master/src/Dates.php) for parse string to date.

```php
$cms = Cms::getInstance();
$time = '2011-12-13 01:02:03';              // Date in some popular format   
$time = '1323738123';                       // or in seconds (timestamp)

$cms['date']->format($time);                // '2011-12-13 01:02:03' (Sql is default)
$cms['date']->format($time, 'timestamp');   // (int)1323738123
$cms['date']->format($time, 'detail');      // 'Tuesday, Dec 13 2011 01:02'
$cms['date']->format($time, 'full');        // 'Tuesday, Dec 13 2011'
$cms['date']->format($time, 'long')         // '13 December, 2011'
$cms['date']->format($time, 'medium')       // 'Dec 13, 2011'
$cms['date']->format($time, 'short');       // '12/13/11'
$cms['date']->format($time, 'time')         // '01:02'
```


#### Environment

```php
$cms = Cms::getInstance();

$cms['env']->getVersion();  // CMS Version
$cms['env']->isAdmin();     // Is control panel (back-end)?
$cms['env']->isSite();      // Is front-end
$cms['env']->isCli();       // Is command line (cron...) ?
$cms['env']->getRootUrl();  // Get frontpage URL
```


#### Events
CrossCMS uses simple and power event manager [JBZoo/Event](https://github.com/JBZoo/Event). This is [Only one file](https://github.com/JBZoo/Event/blob/master/src/EventManager.php).

Примеры
```php
use JBZoo\CrossCMS\AbstractEvents;

$cms = Cms::getInstance();

$noopCallback = function(){ /* some action */};

$cms->on(AbstractEvents::EVENT_INIT, $noopCallback);    // CMS inited
$cms->on(AbstractEvents::EVENT_CONTENT, $noopCallback); // on parse content
$cms->on(AbstractEvents::EVENT_HEADER, $noopCallback);  // before head-tag rendering
$cms->on(AbstractEvents::EVENT_SHUTDOWN, $noopCallback);// before CMS shutdown
```

You can subsribe to back-end of front-end pages.
```php
$cms->on(AbstractEvents::EVENT_INIT.'.admin', $noopCallback);   // Init only for admin-panel 
$cms->on(AbstractEvents::EVENT_INIT.'.site', $noopCallback);    // Init only for front-end 
```

Examples for install (see comments)

 * [For Joomla](https://github.com/JBZoo/CrossCMS/blob/master/src/Joomla/Events.php)
 * [For Wordpress](https://github.com/JBZoo/CrossCMS/blob/master/src/Wordpress/Events.php)


#### Assets
 
```php
$cms = Cms::getInstance();

$cms['header']->setTitle($title);               // Set page title
$cms['header']->setDesc($description);          // Set page description
$cms['header']->setKeywords($keywords);         // Set meta keywords
$cms['header']->addMeta($meta, $value = null);  // Add some meta content (Open Graph, etc)
$cms['header']->noindex();                      // Noindex for Google
$cms['header']->jsFile($file);                  // Include JS-file (url)
$cms['header']->jsCode($code);                  // Some custom JS-code in the head-tag of website. (jQuery-widgets, etc).
$cms['header']->cssFile($file);                 // Include CSS-file (url)
$cms['header']->cssCode($code);                 // Some custom CSS-styles in the head-tag of website. (Dynamic background from PHP-code, etc).
```


#### HTTP-client

```php
$cms = Cms::getInstance();

$response = $cms['http']->request('http://site.com/path');  // Only first argument is required

$response = $cms['http']->request(
    'http://site.com/path',                                 // Url of service
    [                                                       // GET/POST variables
        'var-1' => 'value-1',
        'var-2' => 'value-2',
    ],
    [                                                       // Options
        'timeout'    => 5,                                  // Max wait or connection timeout 
        'method'     => 'GET',                              // HTTP-method (GET|POST|HEAD|PUT|DELETE|OPTIONS|PATCH)  
        'headers'    => [                                   // Custom headers
            'x-custom-header' => '42',
        ],                             
        'response'   => 'full',                             // Format of response (full|body|headers|code) 
        'cache'      => 0,                                  // Enable cache (see $cms['cache']) 
        'cache_ttl'  => 60,                                 // Cache TTL in minutes   
        'user_agent' => 'CrossCMS HTTP Client',             // Custom USER_AGENT  
        'ssl_verify' => 1,                                  // Verify SSL cert 
        'debug'      => 0,                                  // Debug mode on errors (additional debug messages from CMS) 
    ]
);

// Вариант ответа для ['response' => 'full'] 
$response->code;     // HTTPcode, (int)200
$response->headers;  // Array of headers, 'key' => 'value'
$response->body;     // Body, some string
```


#### Localisations

```php
$cms = Cms::getInstance();

echo $cms['lang']->translate('january');                        // "January" | "Январь"
echo $cms['lang']->translate('%s and %s', 'qwerty', 123456));   // "qwerty and 123456" | 'qwerty и 123456'

// Short alias
function _text($message) {
    $cms = Cms::getInstance();
    return call_user_func_array(array($cms['lang'], 'translate'), func_get_args());
}

echo _text('january');                      // "January" | "Январь"
echo _text('%s and %s', 'qwerty', 123456)); // "qwerty and 123456" | 'qwerty и 123456'
```


#### Internal libs
Usually all popular CMS contains popuplar JS-libraries.
It makes no sense to include your jQuery file, while there is built-in one. So we avoid the classic conflicts with other CMS extensions.

```php
$cms = Cms::getInstance();

$cms['libs']->jQuery();             // Include built-in jQuery file
$cms['libs']->jQueryUI();
$cms['libs']->jQueryAutocomplete();
$cms['libs']->jQueryDatePicker();
$cms['libs']->colorPicker();
```


#### Mailer

```php
$cms = Cms::getInstance();
$mail = $cms['mailer'];

$mail->clean(); // Cleanup before new message

$mail->setTo('admin@example.com'); 
$mail->setSubject('Test message subject');
$mail->setBody('<p>Simple test</p>');
$mail->isHtml(false);
$mail->setFrom('no-replay@example.com', 'Website name');

$mail->setHeader('Cc', 'John Smith <john@smith.org>'); 
$mail->setHeaders([
    'Cc'  => 'John Smith <john@smith.org>',
    'Bcc' => 'Mike Smith <mike@smith.org>'
]);

$mail->addAttachment('/full/file/path.zip', 'Some custom name'); 
        
$mail->send(); // return true|false        
```
        
Short alias
```php
$mail->complex('admin@example.com', 'Test message subject', 'Test complex method'); // (return true|false) 
```


#### Filesystem

```php
$cms = Cms::getInstance();

$cms['path']->get('root:');     // Root of website
$cms['path']->get('upload:');   // Uploaded images and other files
$cms['path']->get('tmpl:');     // Templates
$cms['path']->get('cache:');    // FS caches
$cms['path']->get('logs:');     // Logs
$cms['path']->get('tmp:');      // For any temporary data

// Get path to file in tmp directory
$path = $cms['path']->get('tmp:my-file.txt');
$path = $cms['path']->get('tmp:folder/my-file.txt');
```


#### Request

```php
$cms = Cms::getInstance();

$cms['request']->getMethod();                   // Current http-method 
$cms['request']->isGet();                       // Is GET method? 
$cms['request']->isPost();                      // Is POST method?
$cms['request']->isAjax();                      // Is AJAX request? 
$cms['request']->getUri();                      // URL od current page 
$cms['request']->checkToken();                  // Check tocken (XSS) 
$cms['request']->getHeader('x-custom-header');  // Get HTTP-header from request 
 
$cms['request']->set($name, $value);            // Set new value

$cms['request']->get('foo', '42');                       // Get var
$cms['request']->get('foo', null, 'trim');               // Get variable and trim it (See JBZoo/Utils/Filter)
$cms['request']->get('foo', null, 'trim, alias, float'); // Several filters JBZoo/Utils/Filter
$cms['request']->get('foo', null, function ($value) {    // Custom filter (handler) 
    $value = str_replace('124', '789', $value);
    return $value;
}));
```


#### Response 
```php
$cms = Cms::getInstance();

$cms['response']->set404($message);            // Show page 404
$cms['response']->set500($message);            // Show fatal error
$cms['response']->redirect($url, 301);         // Redirect use to new location
$cms['response']->json(array $data = array()); // Send JSON
$cms['response']->text();                      // Send header "Content-Type: plain/text"
$cms['response']->noCache();                   // Send no cache headers
$cms['response']->setHeader($name, $value);    // Send response http-header
```


#### Session
```php
$cms = Cms::getInstance();

$cms['session']->has($key);                                    
$cms['session']->get($key, $default, $group);                  
$cms['session']->set($key, $value, $group);                    
$cms['session']->getGroup($group, $default);                    
$cms['session']->setGroup($group, array $data, $isFullReplace);
$cms['session']->clear($key, $group);                          
$cms['session']->clearGroup($group);                             
$cms['session']->getToken();                                   
```


#### Users

```php
$cms = Cms::getInstance();
$user = $cms['user']->getCurrent();

$user->isGuest();     
$user->isAdmin();     
$user->getEmail();    
$user->getLogin();    
$user->getName();      
$user->getId();       
$user->getAvatar(128);
```


#### Examples
Plugins for Wordpress 

 * [JBZoo 3.x-dev](https://github.com/JBZoo/JBZoo/tree/master/src/wordpress/jbzoo) 
 * [JBZoo 3.x-dev for unit-tests](https://github.com/JBZoo/JBZoo/tree/master/tests/extentions/wp_jbzoophpunit) 
 * [CrossCMS for unit-tests](https://github.com/JBZoo/CrossCMS/tree/master/tests/extentions/wp-plugin) 

Extensions for Joomla!CMS

 * [JBZoo 3.x-dev](https://github.com/JBZoo/JBZoo/tree/master/src/joomla/plg_sys_jbzoocck) 
 * [JBZoo 3.x-dev for unit-tests](https://github.com/JBZoo/JBZoo/tree/master/tests/extentions/j_jbzoophpunit) 
 * [CrossCMS for unit-tests](https://github.com/JBZoo/CrossCMS/tree/master/tests/extentions/joomla-plugin) 


## License

MIT
