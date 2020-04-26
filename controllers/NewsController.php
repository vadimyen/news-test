<?php

namespace app\controllers;

use app\models\Topic;
use Yii;
use app\models\News;
use app\models\NewsSearch;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{


    private function getTopics()
    {
        return Topic::find()
            ->orderBy('id ASC')
            ->all();
    }

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->view->params['topics'] = $this->getTopics();

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

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = News::find()->where(['favorite' => 1]);
        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $query->count(),
        ]);

        $favoriteNews = News::find()->where(['favorite' => 1])
            ->orderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('favorite', [
            'news' => $favoriteNews,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Lists all News models.
     * @param string $search
     * @return mixed
     */
    public function actionDefault(?string $search = null)
    {
        $query = News::find();
        if (!empty($search)) {
            $query->where('MATCH(title, body) AGAINST (:search IN BOOLEAN MODE)', [':search' => $search]);
        }
        $newsCount = $query->count();
        $pagination = $this->createPagination($newsCount);

        $news = $query->orderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('default', [
            'search' => $search,
            'newsCount' => $newsCount,
            'news' => $news,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Lists News by Topic.
     * @return mixed
     */
    public function actionTopic($id)
    {
        $query = News::find()->where(['topic_id' => $id]);
        $newsCount = $query->count();
        $pagination = $this->createPagination($newsCount);

        $news = $query->orderBy('id DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $topic = $news[0]->topic;

        return $this->render('default', [

            'newsCount' => $newsCount,
            'news' => $news,
            'topic' => $topic,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $news = $this->findModel($id);
        $topic = $news->topic;

        $similarNews = News::find()->where(['topic_id' => $topic->id])
            ->andWhere(['!=', 'id', $id])
            ->orderBy('id DESC')
            ->all();

        return $this->render('view', [
            'topic' => $topic,
            'news' => $news,
            'similarNews' => $similarNews,
        ]);
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function createPagination(int $totalCount, int $pageSize = 9): Pagination
    {
        return $pagination = new Pagination([
            'defaultPageSize' => $pageSize,
            'totalCount' => $totalCount,
        ]);
    }
}
