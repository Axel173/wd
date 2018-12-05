<?php

function debug($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function dd($arr)
{
    echo '<pre>' . print_r($arr, true) . '</pre>';
    die();
}

function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    }
    header("Location: $redirect");
    exit;
}

function clear($var)
{

    return addslashes(trim($var));
}

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function generateSalt()
{
    $salt = '';
    $saltLength = 18; //длина соли
    for ($i = 0; $i < $saltLength; $i++) {
        $salt .= chr(mt_rand(33, 126)); //символ из ASCII-table
    }
    return $salt;
}

function GetIP()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function __($key)
{
    echo \fw\core\base\Lang::get($key);
}

function is_active($r_url, $arr_url = array(), $class_name = false, $class = 'active')
{
    if ($class_name) {
        if (!empty($arr_url)) {
            foreach ($arr_url as $item) {
                if ($r_url === $item) {
                    return $class;
                }
            }
        }
    }
    if (!empty($arr_url)) {
        foreach ($arr_url as $item) {
            if ($r_url === $item) {
                return ' class="' . $class . '"';
            }
        }
    }

    return false;

}

function getAgent()
{
    if (getenv('HTTP_USER_AGENT') && strcasecmp(getenv('HTTP_USER_AGENT'), 'unknown'))
        return text_filter(getenv('HTTP_USER_AGENT'));
    elseif (!empty($_SERVER['HTTP_USER_AGENT']) && strcasecmp($_SERVER['HTTP_USER_AGENT'], 'unknown'))
        return text_filter($_SERVER['HTTP_USER_AGENT']);
    else
        return false;
}

/******** использование **********/
//$SourceFile = '/home/user/www/images/image1.jpg';
//$DestinationFile = '/home/user/www/images/image1-watermark.jpg';
//$WaterMarkText = 'Ваш копирайт';
//watermarkImage ($SourceFile, $WaterMarkText, $DestinationFile);
function watermarkImage($SourceFile, $WaterMarkText, $DestinationFile)
{
    list($width, $height) = getimagesize($SourceFile);
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($SourceFile);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
    $black = imagecolorallocate($image_p, 0, 0, 0);
    $font = 'arial.ttf';
    $font_size = 10;
    imagettftext($image_p, $font_size, 0, 10, 20, $black, $font, $WaterMarkText);
    if ($DestinationFile <> '') {
        imagejpeg($image_p, $DestinationFile, 100);
    } else {
        header('Content-Type: image/jpeg');
        imagejpeg($image_p, null, 100);
    }
    imagedestroy($image);
    imagedestroy($image_p);
}

# Функция для загрузки и ресайза изображений
function LoadAndResize($url, $original_path)
{
    /*
     * $url - ссылка на изображение
     * $preview_path - папка, куда сохраняем превьюшки
     * $original_path - папка, куда сохраняем оригинал
     * $size - размер большей строны (в пикселях)
    */

    # Допустимые расширения
    $enabled = array('png', 'gif', 'jpeg');

    # Получаем изображение. Если функция не отработала
    if ($image = file_get_contents($url)) {
        # Генерируем имя tmp-изображения
        $tmp_name = 'tmp' . DIRECTORY_SEPARATOR . time();

        # Сохраняем изображение
        file_put_contents($tmp_name, $image);

        # Очищаем память
        unset($image);

        # Если getimagesize вернула массив
        if ($info = getimagesize($tmp_name)) {
            # Вычисляем тип изображения
            $type = trim(strrchr($info['mime'], '/'), '/');

            # Если тип не подходит
            if (!in_array($type, $enabled)) die($type . ' - Недопустимый тип файла');

            # Исходя из типа формируем названия функций
            $imagecreate = 'imagecreatefrom' . $type;
            $imagesave = 'image' . $type;
            $imagename = md5(time() . rand()) . '.' . $type;

            # Сохраняем оригинал
            if (!copy($tmp_name, $original_path . $imagename)) {
                return '';
            }

            unlink($tmp_name);

            # Возвращаем
            return $imagename;
        }
        return '';
    }
}

function object_to_array($data)
{
    if (is_array($data) || is_object($data))
    {
        $result = array();
        foreach ($data as $key => $value)
        {
            $result[$key] = object_to_array($value);
        }
        return $result;
    }
    return $data;
}