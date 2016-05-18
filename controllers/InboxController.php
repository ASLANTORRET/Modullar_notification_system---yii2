<?php

namespace app\controllers;

use Yii;
use app\models\Inbox;
use app\models\InboxSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;
/**
 * InboxController implements the CRUD actions for Inbox model.
 */
class InboxController extends Controller
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
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'mark-as-read' => ['post']
                ],
            ],
        ];
    }

    /**
     * Lists all Inbox models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InboxSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inbox model.
     * @param integer $id
     * @return mixed
     */
    public function actionView()
    {

        $id = Yii::$app->user->getId();
        $dataProvider = new ActiveDataProvider([
            'query' => Inbox::find()->where(['user_to' => $id, 'nt_id' => 2]),
            'pagination' => [
                'pageSize' => '10'
            ]
        ]);

        return $this->render('view', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionMarkAsRead()
    {
        if( isset($_POST['id'])){

            $id = $_POST['id'];
            $inbox = Inbox::findOne($id);
            $inbox->is_new = 0;
            $inbox->update();

            return "sdsds";
        }
    }

    /**
     * Finds the Inbox model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inbox the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inbox::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
