<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'urokichtenija1');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'PZIr{;i+%ykR=)~f)[i!Z,(3gT/P8dtqn#Ip]r {s;?9Q`xNq5Ya1xwzae{#bY%,');
define('SECURE_AUTH_KEY',  'H|kn#l4q8%9?<Z,54YnPFkriiriz3grA2I2ty_WK:zP7#>G*k3E 4A%9 Lcyn2 o');
define('LOGGED_IN_KEY',    '-<2/;g9DI_[Sviwq,W~)b0w_g=<}R2nRsH*hiLDv%#$}1[Y(gLVvx`]upN&;,a:{');
define('NONCE_KEY',        '.+!z!UN,Gf#,/-;p8LcDWx8%&3(`}P)acnTNuBTc87el~Zn/$b#CZ^r&3{$Vw)_$');
define('AUTH_SALT',        '4@8ZEYRUR.H52p-toUUFnk(.;zw&wKMid^L:fa]Jn}MzP#!k)<<s|z;F{wzk)KKl');
define('SECURE_AUTH_SALT', 'IzW$*AO^yHiY)?!<F^6,PEYWZKA(zv,s4?.|Xsp$i$I}J!!weLC#Sab}JQ51*ILv');
define('LOGGED_IN_SALT',   '26*g<$ cIVK]&T.nArOC*ow/6=3((rS1pw&$!Z/ighJ]8?<>[|K@1yla. vnoR(k');
define('NONCE_SALT',       'c+UjqTI|w:/#nc@mI*nXpd>k(LNuv-jNm?N%meA{$(.=Rst;m1_X8:x2}&z$DVcJ');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
