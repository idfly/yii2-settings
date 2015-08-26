<?php

namespace idfly\settings;

/**
 * Класс для установки и получения настроек.
 *
 * Работает с файлом config/settings.json;
 */
class Settings
{

    /**
     * Установить значение ключа; сохраняет значение в json-файл
     * config/settings.json. Если передан массив - сохранять только значение
     * для конкретного ключа. Например:
     *
     * Settings::set(['settings', 'key'], 'value');
     *
     * Добавит значение 'value' в ключ 'key' в ассоциативный массив 'settings':
     *
     * ['settings' => ['key' => 'value']]l
     *
     * На все непонятные ситуации выбрасывать исключение. Настройки сохраняются
     * с флагами JSON_UNESCAPED_UNICODE и JSON_PRETTY_PRINT.
     *
     * @param string|array $key
     * @param mixed $value
     */
    public static function set($key, $value)
    {

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

    }

}

// Usage

//Settings::set('mysettings', ["key1" => "value1", "key2" => "value2"]);
//Settings::set(['mysettings', 'key1'], "value"); // array form

//$settings = Settings::get('mysettings');
//$settings = Settings::get('mysettings', ['key' => 'value']);
//$key1 = Settings::get(['mysettings', 'key1']);
