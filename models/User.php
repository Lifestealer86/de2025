<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string $phone
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $role
 *
 * @property Request[] $requests
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'phone', 'email', 'username', 'password'], 'required'],
            [['role'], 'string'],
            ['role', 'default', 'value' => 'user'],
            [['full_name', 'email', 'username'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['password'], 'string', 'max' => 255, 'min' => 6],
            [['username'], 'unique'],
            ['email', 'email'],
            ['username', 'match', 'pattern' => '/^[A-z]\w*$/i'],
            ['full_name', 'match', 'pattern' => '/^[А-яЁё -]*$/u',
                'message' => "Разрешены только кириллица, пробел и тире"],
            ['phone', 'match', 'pattern' => '/^\+?7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Email',
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function isAdmin()
    {
        return $this->role == 'admin';
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['user_id' => 'id']);
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }

    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this->password);
        return parent::beforeSave($insert);
    }
}
