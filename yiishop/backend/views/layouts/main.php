<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '项目商城',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '商品表', 'items'=> [
            ['label'=>'商品列表','url' =>['/goods/index']],
            ['label'=>'商品添加','url' =>['/goods/add']],
            ]
        ],
        ['label' => '品牌表', 'items'=> [
            ['label'=>'品牌列表', 'url' =>['/brand/index']],
            ['label'=>'品牌添加','url' =>['/brand/add']],
            ]
        ],
        ['label' => '文章表', 'items'=> [
            ['label'=>'文章列表','url' => ['/article/index']],
            ['label'=>'文章添加','url' =>['/article/add']],
            ]
        ],
        ['label' => '商品分类', 'items'=> [
            ['label'=>'商品分类列表','url' => ['/goods-category/index']],
            ['label'=>'商品分类添加','url' =>['/goods-category/add2']],
            ]
        ],
        ['label' => '文章分类', 'items'=> [
            ['label'=>'文章文类列表','url'=>['/article-category/index']],
            ['label'=>'文章分类添加','url' =>['/article-category/add']],
            ]
        ],
        ['label' => '修改密码', 'url' =>['/admin/admin-edit']
        ],
        ['label' => '管理员表单', 'items'=>[
            ['label' => '管理员列表','url' =>['/admin/index']],
            ['label' => '管理员添加','url' =>['/admin/add']],
            ],
        ]
    ];
   /* $menuItems = [];
    $menus=\backend\models\Menu::findAll(['parent_id'=>0]);
        foreach($menus as $menu){
            //var_dump($menu);exit;
            $item=[];
                foreach($menu->children as $child){
                   //var_dump($child);exit;
                    //判断该管理员是否有该路由的权限
                    //if(Yii::$app->user->can($child->route)){
                        $items=['label'=>$child->name,'url'=>[$child->route]];
                    //}
                }
            //没有子菜单时  不显示一级菜单
            if(!empty($items)){
                $menuItems[]=['label'=>$menu->name,'url'=>$items];
            }
            //var_dump($menuItems);exit;
        }*/
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '登录', 'url' => ['/admin/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/admin/logout'], 'post')
            . Html::submitButton(
                '注销 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; YII2项目商城 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
