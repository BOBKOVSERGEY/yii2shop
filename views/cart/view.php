<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="container" id="cart_items">
  <?php if( Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo Yii::$app->session->getFlash('success'); ?>
    </div>
  <?php endif;?>

  <?php if( Yii::$app->session->hasFlash('error') ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <?php echo Yii::$app->session->getFlash('error'); ?>
    </div>
  <?php endif;?>
<?php if (!empty($session['cart'])) {

  ?>
  <div class="table-responsive cart_info">
    <table class="table table-hover table-striped cart_info">
      <thead>
      <tr class="cart_menu">
        <th>Фото</th>
        <th>Наименование</th>
        <th>Кол-во</th>
        <th>Цена</th>
        <th>Сумма</th>
        <th>Действие</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($session['cart'] as $id => $item) { ?>
        <tr>
          <td><?php echo \yii\helpers\Html::img('@web/images/products/' .$item['img'], ['alt' => $item['name'], 'width' => '100']); ?></td>
          <td><a href="<?php echo Url::to(['product/view', 'id' => $id])?>"><?php echo $item['name']?></a></td>
          <td class="text-center"><?php echo $item['qty']?></td>
          <td class="text-center"><?php echo $item['price']?></td>
          <td class="text-center"><?php echo $item['price'] * $item['qty']; ?></td>
          <td class="text-center"><i data-id="<?php echo $id; ?>" class="fa fa-times text-danger del-item"></i></td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="5">Итого: </td>
        <td class="text-right"><?php echo $session['cart.qty']; ?></td>
      </tr>
      <tr>
        <td colspan="5">На сумму: </td>
        <td class="text-right"><?php echo $session['cart.sum']; ?></td>
      </tr>
      </tbody>
    </table>
  </div>
  <div id="do_action">
    <div class="chose_area">
      <?php $form = ActiveForm::begin();?>
      <?php echo $form->field($order, 'name'); ?>
      <?php echo $form->field($order, 'email'); ?>
      <?php echo $form->field($order, 'phone'); ?>
      <?php echo $form->field($order, 'address'); ?>
      <?php echo Html::submitButton('Заказать', ['class' => 'btn btn-success']) ?>
      <?php ActiveForm::end();?>
    </div>
  </div>

<?php } else { ?>
  <h3 class="text-center">Ваша корзина пуста</h3>
  <span style="display: none;" id="modal-cart-count">0</span>
<?php } ?>
</div>
