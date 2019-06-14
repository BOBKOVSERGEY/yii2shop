<?php


namespace app\controllers;


use app\models\Product;
use Yii;

class ProductController extends AppController
{
  public function actionView($id)
  {
    $id = Yii::$app->request->get('id');

    // ленивая загрузка
    $product = Product::findOne($id);
    // жадная загрузка
    //$product = Product::find()->with('category')->where(['id' => $id])->one();
    $hits = Product::find()->where(['hit' => '1'])->limit(6)->all();
    $this->setMeta($product->name, $product->keywords, $product->description);
    return $this->render('view', compact('product', 'hits'));
  }
}