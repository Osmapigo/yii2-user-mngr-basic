<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $user_email
 *
 * @property User $userEmail
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_email'], 'required'],
            [['user_email'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_email' => 'User Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmail()
    {
        return $this->hasOne(User::className(), ['email' => 'user_email']);
    }
}
