<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use common\models\Person;
use common\models\PersonSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Person models.
     * @return mixed
     */
    public function actionIndex()
    {
      if ((Yii::$app->user->Identity->role == "Cliente")){
          return "Zona no autorizada para su perfil.";
      }
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
      $model = $this->findModel($id);
      $user = $model->getFkUser($id)->one();
      if(!(Yii::$app->user->Identity->role == "Administrador" || Yii::$app->user->Identity->role == "Agente") && $model->fk_user != Yii::$app->user->Identity->email){
        return "Zona no autorizada para su perfil.";
      }
        return $this->render('view', [
            'user_status'  => User::findBySql("SELECT status FROM user WHERE email = (SELECT fk_user FROM person WHERE person.id = $id)")->one()['status'],
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!(Yii::$app->user->Identity->role == "Administrador")){
            return "Zona no autorizada para su perfil.";
        }
        $model = new Person();
        $user = new User();
        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post())){
            $new_mail = Yii::$app->request->post()['User']['email'];
            if (Person::findBySql("SELECT * FROM person WHERE fk_user = '$new_mail'")->one() == NULL){

                $user->setAttributes(['status' => "Inactivo", 'registration_date' => date ('Y-m-d h:m:s'), 'password_hash' => $user->setPassword(Yii::$app->request->post()['User']['password_hash'])]);
                $model->fk_user = $new_mail;
                if ($user->save() && $model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                  }
            }
        }
        return $this->render('create', [
            'user'  => $user,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
      $model = $this->findModel($id);
      $user = $model->getFkUser($id)->one();
      //Check user role and permissions
      if(!(Yii::$app->user->Identity->role == "Administrador") && $model->fk_user != Yii::$app->user->Identity->email){
        return "Zona no autorizada para su perfil.";
      }
        if ($model->load(Yii::$app->request->post()) ) {
            $new_mail = Yii::$app->request->post()['User']['email'];
            $password_hash = Yii::$app->request->post()['User']['password_hash'];
            if (Person::findBySql("SELECT * FROM person WHERE fk_user = '$new_mail' AND id != '$id'")->one() == NULL){
              $password = strpos($password_hash,'$2y$13$') === 0 ? $password_hash : Yii::$app->security->generatePasswordHash($password_hash);
              $user->setAttributes(['email' => $new_mail, 'password_hash' => $password, 'role' => Yii::$app->request->post()['User']['role']]);
              $user->save();
              $model->save();
              return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
              return $this->render('update', ['message' => "Correo electrónico se encuentra en uso", 'model' => $model, 'user' => $user]);
            }
        } else {
            return $this->render('update', ['message' => null, 'model' => $model, 'user' => $user]);
        }
    }

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!(Yii::$app->user->Identity->role == "Administrador")){
            return "Zona no autorizada para su perfil.";
        }
        $person = $this->findModel($id);
        $user_logged = Yii::$app->user->identity->email;
        $user = User::findOne(['email' => $person->fk_user]);
        if ($user->email != $user_logged){
            $user->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Activate the user.
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id){
        $user = User::findBySql("SELECT * FROM user WHERE email = (SELECT fk_user FROM person WHERE person.id = '$id')")->one();
        $user->status = "Activo";
        $user->save();
        return $this->render('view', [
            'user_status'  => User::findBySql("SELECT status FROM user WHERE email = (SELECT fk_user FROM person WHERE person.id = $id)")->one()['status'],
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Deactivate the user.
     * @param integer $id
     * @return mixed
     */
    public function actionDeactivate($id){
      $user = User::findBySql("SELECT * FROM user WHERE email = (SELECT fk_user FROM person WHERE person.id = '$id')")->one();
      $user->status = "Inactivo";
      $user->save();
      return $this->render('view', [
          'user_status'  => User::findBySql("SELECT status FROM user WHERE email = (SELECT fk_user FROM person WHERE person.id = $id)")->one()['status'],
          'model' => $this->findModel($id),
      ]);
    }
}
