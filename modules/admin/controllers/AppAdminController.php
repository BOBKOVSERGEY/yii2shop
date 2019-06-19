<?php


namespace app\modules\admin\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class AppAdminController extends Controller
{

  public function behaviors()
  {
    // ограничиваем доступ
    return [
      'access' => [
      'class' => AccessControl::class,
      'rules' => [
        [
          'allow' => true,
          'roles' => ['@']
        ]

      ]
      ]
    ];
  }

}