<?php

namespace app\models;

use Yii;

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
class User extends \yii\db\ActiveRecord
{
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
            [['email', 'role'], 'required'],
            [['last_date'], 'safe'],
            [['email'], 'string', 'max' => 128],
            [['password_hash', 'activation_code', 'forgot_password_code'], 'string', 'max' => 64],
            [['role'], 'string', 'max' => 45]
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
            'activation_code' => 'Activation Code',
            'forgot_password_code' => 'Forgot Password Code',
            'last_date' => 'Last Date',
            'role' => 'Role',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['fk_user' => 'email']);
    }
}
