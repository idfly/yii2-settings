# yii2-settings

The module for saving and reading the global application configuration.

## Set

1. To the project file `composer.json` add to the `require` section:

      `"idfly/yii2-settings": "dev-master"`

2. To the `repositories` section:
      ```
      {
           "type": "git",
           "url": "git@bitbucket.org:idfly/yii2-settings.git"
      }
      ```

3. Run `composer update`

4. Add this module to the project's configuration list:

      `$config['modules']['settings'] = ['class' => 'idfly\settings\Module'];`

## Example

Module setting example in the admin's panel.

1. Create a file `@app/config/settings.json`. Give it write permission.

    Note: 
    The sign underscore `_` in the model attribute name is used to form an 
    enclosure in json-file.
    
        Example: 
        ```
            model attribute: 
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

2. Create a controller for settings:

        namespace app\admin\controllers;

        class SettingsController extends \idfly\settings\controllers\Controller
        {
        }

3. Create class-models which will be used to indicate the types and rules of  
validation settings, as like as working with model saving in the DB:

        namespace app\models\settings;

        class MyNewSiteSettings extends \idfly\settings\models\Model
        {
            protected $title = 'Class-example for setting module';

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
                        'The first parameter for saving',
                    'myNewSite_secondSettingsItem' =>
                        'The second parameter for saving',
                ];
            }
        }

4. Open page `/admin/settings/edit?modelName=app\models\settings\MyNewSiteSettings`
