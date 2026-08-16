<?php
/*
|--------------------------------------------------------------------------
| CodeIgniter Entry Point - Perpustakaan Digital
|--------------------------------------------------------------------------
|
| Pastikan folder 'system' dari CodeIgniter 3.x sudah ditempatkan
| di sejajar folder 'application' ini.
|
| Struktur folder:
| perpustakaan-digital/
|   ├── application/
|   ├── system/           <-- Copy dari CodeIgniter 3.x
|   ├── assets/
|   ├── database/
|   ├── index.php         <-- File ini
|   └── .htaccess
|
*/
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

switch (ENVIRONMENT)
{
    case 'development':
        error_reporting(E_ALL & ~E_DEPRECATED);
        ini_set('display_errors', 1);
    break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
    break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        exit('The application environment is not set correctly.');
}

/*
|--------------------------------------------------------------------------
| SYSTEM FOLDER NAME
|--------------------------------------------------------------------------
*/
$system_path = 'system';

/*
|--------------------------------------------------------------------------
| APPLICATION FOLDER NAME
|--------------------------------------------------------------------------
*/
$application_folder = 'application';

/*
|--------------------------------------------------------------------------
| VIEW FOLDER NAME
|--------------------------------------------------------------------------
*/
$view_folder = '';

/*
|--------------------------------------------------------------------------
| Custom Config
|--------------------------------------------------------------------------
*/
if (defined('STDIN'))
{
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE)
{
    $system_path = $_temp.DIRECTORY_SEPARATOR;
}
else
{
    $system_path = strtr(
        rtrim($system_path, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
    ).DIRECTORY_SEPARATOR;
}

if ( ! is_dir($system_path))
{
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3);
}

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_path);
define('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);
define('SYSDIR', basename(BASEPATH));

if (is_dir($application_folder))
{
    if (($_temp = realpath($application_folder)) !== FALSE)
    {
        $application_folder = $_temp;
    }
    else
    {
        $application_folder = strtr(
            rtrim($application_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        );
    }
}
elseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))
{
    $application_folder = BASEPATH.strtr(
        trim($application_folder, '/\\'),
        '/\\',
        DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
    );
}
else
{
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
    exit(3);
}

define('APPPATH', $application_folder.DIRECTORY_SEPARATOR);

if ( ! empty($view_folder))
{
    if (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
    {
        if (($_temp = realpath(APPPATH.$view_folder)) !== FALSE)
        {
            $view_folder = $_temp;
        }
        else
        {
            $view_folder = APPPATH.strtr(
                trim($view_folder, '/\\'),
                '/\\',
                DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
            );
        }
    }
    elseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))
    {
        $view_folder = APPPATH.strtr(
            trim($view_folder, '/\\'),
            '/\\',
            DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR
        );
    }
    else
    {
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;
        exit(3);
    }

    define('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);
}
else
{
    define('VIEWPATH', APPPATH.'views'.DIRECTORY_SEPARATOR);
}

require BASEPATH.'core/CodeIgniter.php';
