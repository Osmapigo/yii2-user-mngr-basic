<?php
namespace frontend\models;

use common\models\User;
use common\models\Person;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $name;
    public $phone_number;
    public $email;
    public $password;
    public $role;
    public $origin;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone_number', 'filter', 'filter' => 'trim'],
            ['name', 'required', 'message' => "Necesitamos tu nombre para identificar tus cheques"],
            ['role', 'required', 'message' => "Necesitamos el rol que cumples en el sistema"],

            [['role', 'origin'], 'integer'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 128],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Esta dirección de correo ya ha sido registrada.'],

            ['password', 'required', 'message' => 'Tienes que usar una contrañeña mayor a 6 caracteres para proteger tu cuenta'],
            ['password', 'string', 'min' => 6, 'message' => 'Tienes que usar una contrañeña mayor a 6 caracteres para proteger tu cuenta', ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Nombre completo',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'phone_number' => 'Número de teléfono',
            'role' => 'Rol',
            'origin' => 'Origen'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup($origin)
    {
        $user_exists = User::findOne(['email' => $this->email]);
        if ($user_exists != NULL){
            return $user_exists;
        }
        if (!$this->validate()) {
            return null;
        }
        else {
        $user = new User(['email' => $this->email, 'password_hash' => Yii::$app->security->generatePasswordHash($this->password), 'registration_date' => date('Y-m-d h:m:s'), 'status' => User::STATUS_INACTIVE, 'origin' => $origin]);
        $person = new Person(['name' => $this->name, 'phone_number' => $this->phone_number, 'fk_user' => $this->email]);
        
        return ($user->save() && $person->save()) ? $user : null;
        }
        
    }
}
