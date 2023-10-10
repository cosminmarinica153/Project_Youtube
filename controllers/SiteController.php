<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\user\LoginForm;
use app\models\user\RegisterForm;
use app\models\user\DB_User;
use app\models\channel\DB_Videos;
use app\models\channel\DB_Comments;
use app\models\channel\CommentForm;
use app\models\channel\FeedSearch;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    public function actionPhpinfo()
    {
        return $this->render('phpinfo');
    }

    public function actionIndex()
    {
        $videos = DB_Videos::find()->all();

        return $this->render('index', ['videos' => $videos]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', ['model' => $model]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->goBack();
        }

        return $this->render('register', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSearch()
    {
        $model = new FeedSearch();

        if($model->load(Yii::$app->request->post()))
        {
            $videos = $model->searchVideo();
            if($videos)
            {
                return $this->render('search',
                    ['model' => $model, 'found' => true, 'videos' => $videos, ]);
            }else
            {
                return $this->render('search',
                    ['model' => $model, 'found' => false]);
            }
        }
        return $this->render('search', ['model' => $model]);
    }

    public function actionWatch($id)
    {
        $video = DB_Videos::findOne($id);
        $comments = DB_Comments::find()->where(['video_id' => $id])->all();
        $model = new CommentForm();
    
        $login = new LoginForm();
        
        if ($model->load(Yii::$app->request->post())) {
            if (Yii::$app->user->isGuest) {
                return $this->render('login', ['model' => $login]);
            }
            $model->addComment($id, Yii::$app->user->identity->id);
            $comments = DB_Comments::find()->where(['video_id' => $id])->all();
            $model->contents = null;
            return $this->refresh();
        }
        DB_Videos::incrementViews($video);

        return $this->render('watch', [
            'video' => $video,
            'comments' => $comments,
            'model' => $model
        ]);
    }

    public function actionDelete_comment($comment_id, $video_id)
    {
        if(DB_Comments::deleteComment($comment_id))
        {
            return $this->actionWatch($video_id);
        }
    }
}
