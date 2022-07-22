<?php
namespace im0rg;

use Bitrix\Main\ORM\Data\DataManager,
    Bitrix\Main\ORM\Fields\FloatField,
    Bitrix\Main\ORM\Fields\IntegerField,
    Bitrix\Main\ORM\Fields\StringField,
    Bitrix\Main\ORM\Fields\Validators\LengthValidator,
    Bitrix\Main\ORM\Fields\Relations\Reference,
    Bitrix\Main\ORM\Query\Join;


class TaskTable extends DataManager
{
    /**
     * Returns DB table name for entity.
     *
     * @return string
     */
    public static function getTableName()
    {
        return 'px_task';
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
            new FloatField(
                'PRICE',
                [
                    'default' => 0,
                    'title' => 'PRICE'
                ]
            ),
            new IntegerField(
                'CLIENT_ID',
                [
                    'required' => true,
                    'title' => 'CLIENT_ID'
                ]
            ),
            new IntegerField(
                'STATUS_ID',
                [
                    'required' => true,
                    'title' => 'STATUS_ID'
                ]
            ),
            (new Reference(
                'STATUS',
                StatusTable::class,
                Join::on('this.STATUS_ID', 'ref.ID')
            ))->configureJoinType('inner'),
            (new Reference(
                'CLIENT',
                ClientTable::class,
                Join::on('this.CLIENT_ID', 'ref.ID')
            ))->configureJoinType('inner')
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
            new LengthValidator(null, 255),
        ];
    }
}