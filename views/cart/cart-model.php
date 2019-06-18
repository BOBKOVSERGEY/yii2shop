<?php if (!empty($session['cart'])) {
  $countItems = count($session['cart']);
  ?>
  <div class="table-responsive">
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th>Фото</th>
          <th>Наименование</th>
          <th>Кол-во</th>
          <th>Цена</th>
          <th>Действие</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($session['cart'] as $id => $item) { ?>
          <tr>
            <td><?php echo \yii\helpers\Html::img('@web/images/products/' .$item['img'], ['alt' => $item['name'], 'width' => '100']); ?></td>
            <td><?php echo $item['name']?></td>
            <td class="text-center"><?php echo $item['qty']?></td>
            <td class="text-center"><?php echo $item['price']?></td>
            <td class="text-center"><i data-id="<?php echo $id; ?>" class="fa fa-times text-danger del-item"></i></td>
          </tr>
        <?php } ?>
        <tr>
          <td colspan="4">Товаров:</td>
          <td class="text-right"><span id="modal-cart-count"><?php echo $countItems;?></span></td>
        </tr>
      <tr>
        <td colspan="4">Итого: </td>
        <td class="text-right"><?php echo $session['cart.qty']; ?></td>
      </tr>
        <tr>
          <td colspan="4">На сумму: </td>
          <td class="text-right"><?php echo $session['cart.sum']; ?></td>
        </tr>
      </tbody>
    </table>
  </div>
<?php } else { ?>
  <h3 class="text-center">Ваша корзина пуста</h3>
  <span style="display: none;" id="modal-cart-count">0</span>
<?php } ?>