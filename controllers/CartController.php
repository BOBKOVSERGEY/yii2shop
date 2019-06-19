<?php


namespace app\controllers;

use app\models\Product;
use app\models\Cart;
use app\models\Order;
use app\models\OrderItems;
use Yii;

class CartController extends AppController
{
  public function actionAdd()
  {
    $id = Yii::$app->request->get('id');
    $qty = (int)Yii::$app->request->get('qty');
    $qty = !$qty ? 1 : $qty;

    $product = Product::findOne($id);

    if (empty($product)) return false;

    $session = Yii::$app->session;
    $session->open();

    $cart = new Cart();
    $cart->addToCart($product, $qty);

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

  public function actionCountItems()
  {
    $session = Yii::$app->session;
    $session->open();
    $this->layout = false;
    // Проверка наличия товаров в корзине
    if (isset($session['cart'])) {
      // Если массив с товарами есть
      // Подсчитаем и вернем их количество
      $count = 0;

      return $count = count($session['cart']);
    } else {
      // Если товаров нет, вернем 0
      return 0;
    }
  }

  public function actionView()
  {
    $session = Yii::$app->session;
    $session->open();
    $order = new Order();

    // загружаем данные, которые пришли из формы
    if ( $order->load(Yii::$app->request->post()) ) {
      $order->qty = $session['cart.qty'];
      $order->sum = $session['cart.sum'];

      // сохраняем заказ
      if ($order->save()) {

        // получаем id  сохраненой записи
        $this->saveOrderItems($session['cart'], $order->id);

        Yii::$app->session->setFlash('success', 'Ваш заказ принят, менеджер свяжется с вами в ближайшее время.');

        // отправляем письмо
        Yii::$app->mailer->compose('order', ['session' => $session])
          ->setFrom(['esdipochta@gmail.com' => 'Yii2Shop'])
          // куда отправляем? например заказчику
          ->setTo($order->email)
          // куда отправляем? например менеджеру
          //->setCc('esdicompany@yandex.ru')
          ->setBcc('esdicompany@yandex.ru')
          ->setSubject('Заказ с сайта')
          ->send();

        // если все сохранено почистим корзину
        $session->remove('cart');
        $session->remove('cart.sum');
        $session->remove('cart.qty');

        return $this->refresh();
      } else {
        Yii::$app->session->setFlash('error', 'Ошибка оформления заказа.');
      }
    }

    $this->setMeta('Корзина');
    return $this->render('view', compact('session', 'order'));
  }

  protected function saveOrderItems($items, $order_id)
  {
    foreach ($items as $id => $item) {
      $order_items = new OrderItems();
      $order_items->order_id = $order_id;
      $order_items->product_id = $id;
      $order_items->name = $item['name'];
      $order_items->price = $item['price'];
      $order_items->qty_item = $item['qty'];
      $order_items->sum_item = $item['qty'] * $item['price'];
      $order_items->save();
    }
  }
}