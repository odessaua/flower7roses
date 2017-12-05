<div>
    <!-- breadcrumbs (begin) -->
    <ul class="breadcrumbs">
        <li><a href="/"><?=Yii::t('main','Home page')?></a></li>
        <li>&nbsp;/&nbsp;</li>
        <li><?=Yii::t('main','About Delivery')?></li>
    </ul>
    <!-- breadcrumbs (end) -->


    <h1 class="page-title"><?=$model->title?></h1>

    <div class="g-clearfix">
        <div class="content-img">
            <img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/img/delivery.jpg" alt="7Roses delivery"/>
        </div>
        <div class="content-text delivery-content-text">
            <?php echo $model->full_description; ?>
       
            <h2><?=Yii::t('main','Payment')?></h2>
            <p><strong><?=Yii::t('main','Payment')?>:</strong></p>
            
        </div>
    </div>
</div>
