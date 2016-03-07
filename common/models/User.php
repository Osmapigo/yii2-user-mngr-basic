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
 * @property string $activation_code
 * @property string $forgot_password_code
 * @property string $last_date
 * @property string $role
 *
 * @property Person[] $people
 */
class User extends ActiveRecord implements IdentityInterface
{

  const STATUS_INACTIVE = "Inactivo";
  const STATUS_ACTIVE = "Activo";

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
            [['email', 'role', 'status'], 'required'],
            [['registration_date'], 'safe'],
            [['email'], 'string', 'max' => 128],
            [['password_hash', 'activation_code', 'forgot_password_code'], 'string', 'max' => 64],
            [['role', 'status'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Correo electrónico',
            'password_hash' => 'Contraseña',
            'activation_code' => 'Activation Code',
            'forgot_password_code' => 'Forgot Password Code',
            'registration_date' => 'Fecha de registro',
            'role' => 'Rol',
            'status' => 'Estado',
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
        return $this->password_hash = Yii::$app->security->generatePasswordHash($password);
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
