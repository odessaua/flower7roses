<?php $slider=SSystemSlider::model()->active()->orderByPosition()->findAll();

if(!empty($data['city_seo'])){
    $this->pageKeywords = (!empty($city_seo['keywords'])) ? $city_seo['keywords'] : '';
    $this->pageDescription = (!empty($city_seo['description'])) ? $city_seo['description'] : '';
    $this->pageTitle = (!empty($city_seo['title'])) ? $city_seo['title'] : '';
}
else{
    unset($city_seo);
    if(!empty($main_page)){
        $this->pageKeywords = (!empty($main_page['meta_keywords'])) ? $main_page['meta_keywords'] : '';
        $this->pageDescription = (!empty($main_page['meta_description'])) ? $main_page['meta_description'] : '';
        $this->pageTitle = (!empty($main_page['meta_title'])) ? $main_page['meta_title'] : '';
    }
}
// var_dump($slider);
?>
<div class="g-clearfix">
	<!-- col-1 (begin) -->
	<div class="col-1">
        <?php if(empty($data['h1_header'])): ?>
	    <div class="slider">
	        <div id="slider">
	            <ul>
                        <?php foreach ($slider as $one) { ?>
                            <li>
                                <a href="<?= Yii::app()->createUrl($one['url']); ?>" title="<?=$one['name']?>">
                                    <img width="812" height="282" src="<?= '/uploads/slider/'.$one['photo'] ?>" alt="<?=$one['name']?>"/>
                                </a>
                            </li>
                        <?php } ?>
	            </ul>
	        </div>
	    </div>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $("#slider").easySlider({
                    auto: <?= (Yii::app()->settings->get('core', 'sliderAutoRotate') > 0) ? 'true' : 'false';?>
                });
            });
        </script>
        <?php else: ?>
        <h1 style="margin: 20px 0 30px;"><?= $data['h1_header']; ?></h1>
        <?php endif; ?>
	
	    <?php //$this->renderFile(Yii::getPathOfAlias('pages.views.pages.left_sidebar').'.php'); ?>
	
	    <!-- col-1 (begin)  -->
	    <div class="col-1">
	
	        <!-- products (begin) -->
	        <div class="products g-clearfix">
	        	<?php
                shuffle($popular);
                $lang= Yii::app()->language;
                if($lang == 'ua')
                    $lang = 'uk';
                $langArray = SSystemLanguage::model()->findByAttributes(array('code'=>$lang));
					foreach($popular as $p)
						$this->renderPartial('_product', array('data'=>$p, 'langArray' => $langArray));
				?>
	        </div>
	        <!-- products (end) -->
	
	        <!-- b-page-text (begin) -->
	        <div class="b-page-text text ">
	            <?php
                if(!empty($city_seo['text'])){
                    echo $city_seo['text'];
                }
                elseif(!empty($mainContent->full_description)){
                    echo $mainContent->full_description;
                }
                ?>
	        </div>
	        <!-- b-page-text (end) -->
	    </div>
	    <!-- col-1 (end) -->
	</div>
	<!-- col-1 (end) -->
	
	<!-- col-22 (begin) -->
	<div class="col-22">
        <?php
        // поле `name` является идентификатором, по которому выводится баннер на данную позицию
        // в этом случае идентификатором является значение 'SPA', в другом – может быть такое же, а может быть другое
        // выбирается одна запись, у которой `active` = 1 AND `name` = 'SPA'
        $banner =  SSystemBaner::model()->active()->find("name = :name", array(':name' => 'SPA'));
        if(!empty($banner)):
        ?>
	    <div class="action">
	        <a href="<?= Yii::app()->createUrl($banner->url); ?>" title="<?= $banner->name; ?>">
	            <img width="218" heigth="282" src="<?= '/uploads/baners/'.$banner->photo; ?>" alt="<?= $banner->url; ?> Banner" />
	        </a>
	    </div>
        <?php endif; ?>

	    <!-- b-comments (begin) -->
	    <div class="b-comments">
	        <h3 class="title">
                <a href="<?=Yii::app()->createUrl('/reviews'); ?>">
                    <?=Yii::t('main','Customer reviews')?>
                </a>
            </h3>
	        <ul>
	        	<?php foreach ($comments as $key => $value): ?>
	            <li>
	            	
	                <div class="visual">
	                    <img src="<?php echo Yii::app()->theme->baseUrl ?>/assets/img/avatar01.jpg" alt="Reviews"/>
	                </div>
	                <div class="info">
	                    <div class="name"><?=$value['name']?></div>
	                    <p>
	                        <?=$value['text']?>
	                    </p>
	                </div>
	            
	            </li>
	            <?php endforeach;?>
	        </ul>
	    </div>
	    <!-- b-comments (end) -->
	
	    <!-- b-socials (begin) -->
	    <div class="b-socials">
	        <h3 class="title"><?=Yii::t('main','We are in social networks')?></h3>
	        <div>
			<a class="go" href="https://plus.google.com/u/1/109628640430677109024" title="Google+"></a>
	             <!--<a class="fb" href="#" title="Facebook"></a>	            
	            <a class="ok" href="#" title="Одноклассники"></a>-->
	        </div>
	    </div>
	    <!-- b-socials (end) -->
	</div>
	<!-- col-22 (end) -->
</div>