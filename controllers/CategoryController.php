<?php


namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;

class CategoryController extends AppController
{
  public function actionIndex()
  {
    $this->setMeta('E Shopper');
    $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
    return $this->render('index', compact('hits'));
  }

  public function actionView($id)
  {
    //$id = Yii::$app->request->get('id');

    $category = Category::findOne($id);

    if (empty($category)) {
      throw new HttpException(404, 'Такой категории не существует');
    }

    //$products = Product::find()->where(['category_id' => $id])->all();
    $query = Product::find()->where(['category_id' => $id]);

    $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);

    $products = $query->offset($pages->offset)->limit($pages->limit)->all();



    $this->setMeta($category->name, $category->keywords, $category->description);

    return $this->render('view', compact('products', 'pages', 'category'));

  }

  public function actionSearch()
  {
    $q = trim(Yii::$app->request->get('q'));
    if (!$q) return $this->render('search');
    $query = Product::find()->where(['like', 'name', $q]);

    $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 3, 'forcePageParam' => false, 'pageSizeParam' => false]);

    $products = $query->offset($pages->offset)->limit($pages->limit)->all();

    $this->setMeta('Поиск по запросу ' . $q);

    return $this->render('search', compact('products', 'pages', 'q'));
  }
}