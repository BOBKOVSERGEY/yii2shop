<?php
  use yii\helpers\Html;
?>
<section id="advertisement">
  <div class="container">
    <img src="/images/shop/advertisement.jpg" alt="" />
  </div>
</section>

<section>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div class="left-sidebar">
          <h2>Category</h2>
          <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            <ul class="catalog">
              <?php

              echo \app\components\MenuWidget::widget(['tpl' => 'menu']); ?>
            </ul>
          </div><!--/category-productsr-->

          <div class="brands_products"><!--brands_products-->
            <h2>Brands</h2>
            <div class="brands-name">
              <ul class="nav nav-pills nav-stacked">
                <li><a href=""> <span class="pull-right">(50)</span>Acne</a></li>
                <li><a href=""> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                <li><a href=""> <span class="pull-right">(27)</span>Albiro</a></li>
                <li><a href=""> <span class="pull-right">(32)</span>Ronhill</a></li>
                <li><a href=""> <span class="pull-right">(5)</span>Oddmolly</a></li>
                <li><a href=""> <span class="pull-right">(9)</span>Boudestijn</a></li>
                <li><a href=""> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
              </ul>
            </div>
          </div><!--/brands_products-->

          <div class="price-range"><!--price-range-->
            <h2>Price Range</h2>
            <div class="well">
              <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
              <b>$ 0</b> <b class="pull-right">$ 600</b>
            </div>
          </div><!--/price-range-->

          <div class="shipping text-center"><!--shipping-->
            <img src="/images/home/shipping.jpg" alt="" />
          </div><!--/shipping-->

        </div>
      </div>

      <div class="col-sm-9 padding-right">
        <?php if (!empty($products)) { ?>
          <div class="features_items"><!--features_items-->
            <h2 class="title text-center"><?php echo $category->name; ?></h2>
            <?php $i = 0; foreach ($products as $product) { ?>
              <div class="col-sm-4">
                <div class="product-image-wrapper">
                  <div class="single-products">
                    <div class="productinfo text-center">
                      <?php echo Html::img('@web/images/products/' . $product->img, ['alt'=> $product->name]); ?>
                      <h2>$<?php echo $product->price; ?></h2>
                      <p><a href="<?php echo \yii\helpers\Url::to(['product/view', 'id' => $product->id])?>"><?php echo $product->name; ?></a></p>
                      <a href="<?php echo \yii\helpers\Url::to(['cart/add', 'id' => $product->id])?>"  data-id="<?php echo $product->id; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                    </div>
                    <?php if ($product->new) { ?>
                      <?php echo Html::img('@web/images/home/new.png', ['alt'=> 'Новинка', 'class' => 'new']); ?>
                    <?php } ?>
                    <?php if ($product->sale) { ?>
                      <?php echo Html::img('@web/images/home/sale.png', ['alt'=> 'Распродажа', 'class' => 'new']); ?>
                    <?php } ?>

                  </div>
                  <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                      <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                      <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            <?php $i++; ?>
            <?php if ($i % 3 == 0) { ?>
                <div class="clearfix"></div>
            <?php } ?>
            <?php } ?>

            <div class="clearfix"></div>
            <!--<ul class="pagination">
              <li class="active"><a href="">1</a></li>
              <li><a href="">2</a></li>
              <li><a href="">3</a></li>
              <li><a href="">&raquo;</a></li>
            </ul>-->
            <?php
              echo \yii\widgets\LinkPager::widget([
                'pagination' => $pages
              ]);
            ?>
          </div>

        <?php } else { ?>
          <h3>Товаров пока нет</h3>
        <?php } ?>
      </div>
    </div>
  </div>
</section>