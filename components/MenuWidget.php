<?php

namespace app\components;

use app\models\Category;
use yii\base\Widget;
use Yii;

class MenuWidget extends Widget
{
  public $tpl;
  public $model;
  public $data;
  public $tree;
  public $menuHtml;

  // init
  public function init()
  {
    parent::init(); // TODO: Change the autogenerated stub

    if ($this->tpl === null) {
      $this->tpl = 'menu';
    }

    $this->tpl .= '.php';

  }


  // run
  public function run()
  {

    if ($this->tpl == 'menu.php') {
      // попытаемся получить данные из cache
      $menu = Yii::$app->cache->get('menu');

      if ($menu) return $menu;
    }


    // ->asArray - возвращает полученные данные в виде обычного массива
    // ->indexBy - какую колонку использовать для именования ключей массива
    $this->data = Category::find()->indexBy('id')->asArray()->all();
    $this->tree = $this->getTree();
    $this->menuHtml = $this->getMenuHtml($this->tree);

    if ($this->tpl == 'menu.php') {
      // запись в кеш set Cache
      Yii::$app->cache->set('menu', $this->menuHtml, 60);
    }
    return $this->menuHtml;
  }

  protected function getTree(){
    $tree = [];
    foreach ($this->data as $id=>&$node) {
      if (!$node['parent_id'])
        $tree[$id] = &$node;
      else
        $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
    }
    return $tree;
  }

  protected function getMenuHtml($tree, $tab = ''){
    $str = '';
    foreach ($tree as $category) {
      $str .= $this->catToTemplate($category, $tab);
    }
    return $str;
  }

  protected function catToTemplate($category, $tab){
    ob_start();
    include __DIR__ . '/menu_tpl/' . $this->tpl;
    return ob_get_clean();
  }
}