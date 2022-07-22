<?php
namespace im0rg;

use Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\ORM\Fields\Validators\LengthValidator;


class StatusTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'px_task_status';
    }

    /**
     * Returns entity map definition.
     *
     * @return array
     */
    public static function getMap()
    {
        return [
            new IntegerField(
                'ID',
                [
                    'primary' => true,
                    'autocomplete' => true,
                    'title' => 'ID'
                ]
            ),
            new StringField(
                'NAME',
                [
                    'required' => true,
                    'validation' => [__CLASS__, 'validateName'],
                    'title' => 'NAME'
                ]
            ),
            new StringField(
                'CODE',
                [
                    'required' => true,
                    'validation' => [__CLASS__, 'validateCode'],
                    'title' => 'CODE'
                ]
            )
        ];
    }

    /**
     * Returns validators for NAME field.
     *
     * @return array
     */
    public static function validateName()
    {
        return [
            new LengthValidator(null, 50),
        ];
    }

    /**
     * Returns validators for CODE field.
     *
     * @return array
     */
    public static function validateCode()
    {
        return [
            new LengthValidator(null, 1),
        ];
    }
}