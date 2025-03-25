<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $service_id
 * @property string $address
 * @property string $contact_phone
 * @property string $desired_datetime
 * @property string|null $custom_service_description
 * @property string $payment_method
 * @property string|null $status
 * @property string|null $cancellation_reason
 *
 * @property Service $service
 * @property User $user
 */
class Request extends \yii\db\ActiveRecord
{
    public $other_request;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'address', 'contact_phone', 'desired_datetime', 'payment_method'], 'required'],
            [['user_id', 'service_id'], 'integer'],
            [['desired_datetime'], 'safe'],
            [['payment_method', 'status'], 'string'],
            [['address', 'contact_phone', 'custom_service_description', 'cancellation_reason'], 'string', 'max' => 255],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::class, 'targetAttribute' => ['service_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            ['status', 'default', 'value' => 'new'],
            ['contact_phone', 'match', 'pattern' => '/^\+?7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'service_id' => 'Сервис',
            'address' => 'Адрес',
            'contact_phone' => 'Номер телефона',
            'desired_datetime' => 'Желаемое дата и время',
            'custom_service_description' => 'Ваша услуга',
            'payment_method' => 'Предпочтительный тип оплаты',
            'status' => 'Статус',
            'cancellation_reason' => 'Причина отмены',
            'other_request' => 'Иная услуга'
        ];
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
