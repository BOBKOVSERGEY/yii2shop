<?php


namespace app\controllers;

use app\models\Product;
use app\models\Cart;
use Yii;

class CartController extends AppController
{
  public function actionAdd()
  {
    $id = Yii::$app->request->get('id');
    $product = Product::findOne($id);

    if (empty($product)) return false;

    $session = Yii::$app->session;
    $session->open();

    $cart = new Cart();
    $cart->addToCart($product);

    // убираем шаблон
    $this->layout = false;

    return $this->render('cart-model', compact('session'));
  }

  public function actionClear()
  {
    $session = Yii::$app->session;
    $session->open();
    $session->remove('cart');
    $session->remove('cart.qty');
    $session->remove('cart.sum');
    // убираем шаблон
    $this->layout = false;

    return $this->render('cart-model', compact('session'));
  }

  public function actionDelItem()
  {
    $id = Yii::$app->request->get('id');
    $session = Yii::$app->session;
    $session->open();
    $cart = new Cart();
    $cart->recalc($id);
    // убираем шаблон
    $this->layout = false;

    return $this->render('cart-model', compact('session'));
  }

  public function actionShow()
  {
    $session = Yii::$app->session;
    $session->open();
    // убираем шаблон
    $this->layout = false;

    return $this->render('cart-model', compact('session'));
  }
}