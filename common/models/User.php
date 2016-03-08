<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property string $email
 * @property string $password_hash
 * @property string $registration_date
 * @property integer $role
 * @property integer $origin
 * @property integer $status
 *
 * @property Person[] $people
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const ORIGIN_WEB_REGISTER = 1;
    const ORIGIN_FACEBOOK_REGISTER = 0;
    
    const ROLE_ADMINISTRATOR = 0;
    const ROLE_AGENT = 1;
    const ROLE_CUSTOMER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password_hash', 'registration_date'], 'required'],
            [['registration_date'], 'safe'],
            [['role', 'origin', 'status'], 'integer'],
            [['email'], 'string', 'max' => 128],
            [['password_hash'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'registration_date' => 'Registration Date',
            'role' => 'Role',
            'origin' => 'Origin',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['fk_user' => 'email']);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        // return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        // return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

}
