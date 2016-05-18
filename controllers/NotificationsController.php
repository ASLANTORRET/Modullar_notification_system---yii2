<?php

namespace app\controllers;

use app\models\Articles;
use dektrium\user\models\User;
use Yii;
//use app\models\Articles;
use app\models\Notifications;
use app\models\NotificationsSearch;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
/**
 * NotificationsController implements the CRUD actions for Notifications model.
 */
class NotificationsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['*'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'get-inserts' => ['post']
                ],
            ],
        ];
    }

    /**
     * Displays a single Notifications model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Lists all Notifications models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NotificationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetInserts(){

        if( isset($_POST["event_code"]) ){

            $event_code = $_POST["event_code"];
            $text  = "Доступные вставки: ";
            $class_name = 'app\models\\' . explode("::", $event_code)[0];

            $inserts = array_values((new $class_name())->attributes());

            array_walk($inserts, function(&$value, $key){
                $value = "{" . $value . "},";
            });

            echo '<div class="alert alert-info" role="alert">'. $text .'<b>' . implode('', $inserts) . '</b></div>';
        }
        else{

            echo 'Не найдено вставок';

        }
    }
    /**
     * Creates a new Notifications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Notifications();

        if(Yii::$app->request->post()){

            $raw_arr = Yii::$app->request->post();

            $notifications = $raw_arr['Notifications'];

            if(count($notifications['nt_id']) == 0 ){

                die("ERROR. NT_ID VALUE IS NOT SET");

            }


            if(count($notifications['nt_id']) == 1 ){

                if ($model->load($raw_arr) && $model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
            else{

                $rows = [$notifications, $notifications];

                $first_nt_id = $rows[0][ 'nt_id' ][0];                //first notification type id
                $sec_nt_id = $rows[0][ 'nt_id' ][1];                  //second notification type id

                $rows[0][ 'nt_id' ] = $first_nt_id;
                $rows[1][ 'nt_id' ] = $sec_nt_id;

                $rows[0][ 'created_at' ] = time();
                $rows[1][ 'created_at' ] = time();

                //Batch insert operation
                $attributes = $model->attributes();
                unset($attributes[0]);

                Yii::$app->db->createCommand()->batchInsert(Notifications::tableName(), $attributes, $rows)->execute();
                \Yii::$app->getSession()->setFlash('create_message','Уведомление создана удачно.');
                return $this->redirect(['index']);

            }


        }

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } */else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Notifications model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);

        } else {

            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Notifications model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Notifications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notifications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notifications::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
