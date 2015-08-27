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
    public static $settingsInstance;
    public static $getSettings = null;
    public static $settings;

    public function __construct()
    {
        $settingsFile = self::getSettingsFile();
        $json = file_get_contents($settingsFile);
        self::$settings = json_decode($json, true);
    }

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
        if(self::$getSettings !== null) {
            $callback = self::$getSettings;
            return $callback();
        }

        if(is_null(self::$settingsInstance)) {
            self::$settingsInstance = new Settings();
        }

        return self::$settings;
    }

    private static function setSettings($settings)
    {
        $settingsFile = self::getSettingsFile();

        self::$settings = $settings;

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

        if(!is_array($key)) {
            $key = [$key];
        }

        $current = &$settings;
        foreach(array_slice($key, 0, sizeof($key) - 1) as $keyPart) {
            $current = &$current[$keyPart];
        }
        $current[$key[sizeof($key) - 1]] = $value;

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

        if(!is_array($key)) {
            $key = [$key];
        }

        $settingValue = $settings;
        foreach($key as $settingKey) {
            if(!is_array($settingValue)) {
                throw new Exception(
                    'Настройка "' . $settingKey . '" не может быть считана.'
                );
            }
            if(empty($settingValue[$settingKey])) {
                return $default;
            }
            $settingValue = $settingValue[$settingKey];
        }

        if(!empty($settingValue)) {
            return $settingValue;
        }

        return $default;
    }

}
