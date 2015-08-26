<?php

namespace idfly\settings;

use yii\base\Exception;

/**
 * Класс для установки и получения настроек.
 *
 * Работает с файлом config/settings.json;
 */
class Settings
{
    public static $settingsFile = '/config/settings.json';

    private static function getSettings()
    {
        $path = \Yii::getAlias('@app');
        $settingsFile = $path . self::$settingsFile;

        if(!file_exists($settingsFile)) {
            throw new Exception(
                'Файл "' . $settingsFile . '" с настройками не найден.'
            );
        }

        $json = file_get_contents($settingsFile);
        return json_decode($json);
    }

    /**
     * Установить значение ключа; сохраняет значение в json-файл
     * config/settings.json. Если передан массив - сохранять только значение
     * для конкретного ключа. Например:
     *
     * Settings::set(['settings', 'key'], 'value');
     *
     * Добавит значение 'value' в ключ 'key' в ассоциативный массив 'settings':
     *
     * ['settings' => ['key' => 'value']]
     *
     * На все непонятные ситуации выбрасывать исключение. Настройки сохраняются
     * с флагами JSON_UNESCAPED_UNICODE и JSON_PRETTY_PRINT.
     *
     * @param string|array $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        $settings = self::getSettings();
        if(is_array($key)) {
            $resultKey = implode('->', $key);
            var_dump($settings->{'key->key1->key2->key3'});
            var_dump($settings->{$resultKey});die;
        } else {
            $settings->$key = $value;
        }

        $path = \Yii::getAlias('@app');
        $settingsFile = $path . self::$settingsFile;

        file_put_contents(
            $settingsFile,
            json_encode($settings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    /**
     * Получить значение конфигурации; ищет значение конфигурации в json-файле
     * config/settings.json и возвращает его; если значение не найдено, тогда
     * возвращает $default. Если в $key передан массив, тогда $key используется
     * как путь в ассоциативном массиве. Например:
     *
     * Settings::get(['settings', 'key'])
     *
     * Вернёт значение 'value' из ассоциативного массива
     * ['settings' => ['key' => 'value']].
     *
     * @param  string|array $key
     * @param  mixed $default
     * @return [type]
     */
    public static function get($key, $default = null)
    {
        $settings = self::getSettings();

        if(is_array($key)) {
            $settingValue = $settings;
            foreach($key as $settingKey) {
                if(empty($settingValue->$settingKey)) {
                    throw new Exception(
                        'Настройка "' . $settingKey . '" найдена.'
                    );
                }
                $settingValue = $settingValue->$settingKey;
            }
        } else {
            $settingValue = $settings->$key;
        }

        if(!empty($settingValue)) {
            return $settingValue;
        }

        return $default;
    }

}

// Usage

//Settings::set('mysettings', ["key1" => "value1", "key2" => "value2"]);
//Settings::set(['mysettings', 'key1'], "value"); // array form

//$settings = Settings::get('mysettings');
//$settings = Settings::get('mysettings', ['key' => 'value']);
//$key1 = Settings::get(['mysettings', 'key1']);
