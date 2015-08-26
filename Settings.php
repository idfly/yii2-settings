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
    private static function getSettingsFile()
    {
        $path = \Yii::getAlias('@app');
        $settingsFile = $path . '/config/settings.json';

        if(!file_exists($settingsFile)) {
            throw new Exception(
                'Файл "' . $settingsFile . '" с настройками не найден.'
            );
        }

        return $settingsFile;
    }

    private static function getSettings()
    {
        $settingsFile = self::getSettingsFile();

        $json = file_get_contents($settingsFile);
        return json_decode($json, true);
    }

    private static function setSettings($settings)
    {
        $settingsFile = self::getSettingsFile();

        file_put_contents(
            $settingsFile,
            json_encode($settings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
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
     * Настройки сохраняются с флагами JSON_UNESCAPED_UNICODE и
     * JSON_PRETTY_PRINT.
     *
     * @param string|array $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {
        $settings = self::getSettings();

        if(is_array($key)) {
            $current = &$settings;
            foreach(array_slice($key, 0, sizeof($key) - 1) as $keyPart) {
                $current = &$current[$keyPart];
            };
            $current[$key[sizeof($key) - 1]] = $value;
        } else {
            $settings->$key = $value;
        }

        self::setSettings($settings);
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
                if(empty($settingValue[$settingKey])) {
                    throw new Exception(
                        'Настройка "' . $settingKey . '" не найдена.'
                    );
                }
                $settingValue = $settingValue[$settingKey];
            }
        } else {
            $settingValue = $settings[$key];
        }

        if(!empty($settingValue)) {
            return $settingValue;
        }

        return $default;
    }

}
