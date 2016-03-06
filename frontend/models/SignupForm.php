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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['phone_number', 'filter', 'filter' => 'trim'],
            ['name', 'required', 'message' => "Necesitamos tu nombre para identificar tus cheques"],
            ['role', 'required', 'message' => "Necesitamos el rol que cumples en el sistema"],

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
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $person = new Person();

        $person->name = $this->name;
        $person->phone_number = $this->phone_number;
        $person->fk_user = $this->email;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->role = $this->role;
        $user->registration_date = date('Y-m-d h:m:s');
        $admin_active_users = User::FindOne(['role' => "Administrador" , 'status' => 10]);
        if ($admin_active_users == NULL && $this->role == "Administrador"){
          $user->status = "Activo";
        }
        else{
          $user->status = "Inactivo";
        }
        
        return ($user->save() && $person->save()) ? $user : null;
    }
}
