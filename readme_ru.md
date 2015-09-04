# yii2-settings

Модуль для сохранения и чтения глобальной конфигурации приложения.

## Установка

1. В файл `composer.json` в секцию `require` добавить:

        "idfly/yii2-settings": "dev-master"

2. В файл `composer.json` в секцию `repositories` добавить:

        {
            "type": "git",
            "url": "git@bitbucket.org:idfly/yii2-settings.git"
        }

3. Выполнить `composer update`.

4. Добавить модуль в конфигурационный файл `config/common.php`:

        $config['modules']['settings'] = ['class' => 'idfly\settings\Module'];

## Настройка

Пример для настройки модуля в админке.

1. Создать файл `@app/config/settings.json`, доступный для записи.

    Примечание: знак нижнего подчёркивания `_` в имени атрибута модели   
    используется для формирования вложенности в json-файле.
    
    Пример: 
    ```
        аттрибут класса-модели: 
        public $myNewSite_firstSettingsItem_SettingItem = 'value';
        
        settings.json : 
        {
            "myNewSite" :
                {
                    "firstSettingsItem" : {
                        "SettingItem" : 'value'
                    }
                }
            ...    
        }
    ```
    

2. Создать контроллер для настроек:

        namespace app\admin\controllers;

        class SettingsController extends \idfly\settings\controllers\Controller
        {
        }

3. Написать классы-модели, которые будут использованы для указания типов
и правил валидации настроек, как при работе с сохранением модели в БД:

        namespace app\models\settings;

        class MyNewSiteSettings extends \idfly\settings\models\Model
        {
            protected $title = 'Класс-пример для модуля настроек';

            public $myNewSite_firstSettingsItem;
            public $myNewSite_secondSettingsItem;

            public function rules()
            {
                return [
                    [
                        [
                            'myNewSite_firstSettingsItem',
                        ],
                        'integer'
                    ],
                    [
                        [
                            'myNewSite_secondSettingsItem',
                        ],
                        'string'
                    ],
                ];
            }

            public static function getFormFields($form, $element)
            {
                return [
                    'myNewSite_firstSettingsItem' => $form->
                        field($element, 'myNewSite_firstSettingsItem')->
                        textInput(),
                    'myNewSite_firstSettingsItem' => $form->
                        field($element, 'myNewSite_firstSettingsItem')->
                        textarea(),
                ];
            }

            public function attributeLabels() {
                return [
                    'myNewSite_firstSettingsItem' =>
                        'Первый параметр для сохранения',
                    'myNewSite_secondSettingsItem' =>
                        'Второй параметр для сохранения',
                ];
            }
        }

4. Открыть страницу `/admin/settings/edit?modelName=app\models\settings\MyNewSiteSettings`
