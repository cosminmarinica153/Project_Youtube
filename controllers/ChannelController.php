<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use app\models\channel\UploadForm;
use app\models\channel\UpdateForm;
use app\models\channel\DB_Videos;

class ChannelController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex()
    {
        $user_id = Yii::$app->user->identity->getId();
        $videos = DB_Videos::find()->where(['user_id' => $user_id])->all();

        return $this->render('index', ['videos' => $videos]);
    }

    public function actionCreate()
    {

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->video_file = UploadedFile::getInstance($model, 'video_file');
            if($model->upload()){
                $user_id = Yii::$app->user->identity->getId();
                $videos = DB_Videos::find()->where(['user_id' => $user_id])->all();
                return $this->render('index', ['videos' => $videos]);
            }
        }    

        return $this->render('create', ['model' => $model]);
    }

    public function actionDelete()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user_id = Yii::$app->user->identity->getId();
        $videos = DB_Videos::find()->where(['user_id' => $user_id])->all();

        return $this->render('delete', ['videos' => $videos]);
    }

    public function actionDelete_video($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $video = DB_Videos::findById($id);
        $path = 'C:/wamp64/www/Youtube 2.0/web/'.$video->video_path;

        if(DB_videos::deleteVideo($id))
        {
            FileHelper::unlink($path);

            $user_id = Yii::$app->user->identity->getId();
            $videos = DB_Videos::find()->where(['user_id' => $user_id])->all();

            return $this->render('delete', ['videos' => $videos]);
        }
    }

    public function actionUpdate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user_id = Yii::$app->user->identity->getId();
        $videos = DB_Videos::find()->where(['user_id' => $user_id])->all();

        return $this->render('update', ['videos' => $videos]);
    }

    public function actionUpdate_form($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $video = DB_Videos::findOne($id);
        $model = new UpdateForm();

        if ($model->load(Yii::$app->request->post())) {
            if($model->updateVideo($id))
                return $this->goBack();
        }

        return $this->render('update_form', ["model" => $model, 'video' => $video]);
    }
}
