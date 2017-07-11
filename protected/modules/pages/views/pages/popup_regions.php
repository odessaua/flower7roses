<?php
if(!$popup)
	$popup = "city-simple";
?>

<?=Yii::t('main','Recipient City')?>: 
<a href="#" title="" class="drop-link cityName">
	<?php
    $cityPopupInfo = $this->getCurrentCityInfo(true);
    echo $cityPopupInfo->name;
    ?>
</a>
<div class="sort-popup hidden">
    <h2 class="title"><?=Yii::t('main','Send flowers to any city')?></h2>
    <p><?=Yii::t('main','Start typing the name of the city, and we will help')?></p>
    
    <?php 
	$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
		'name'=>$popup,
		'source'=>Yii::app()->createUrl('/site/autocompleteCity'),
		// additional javascript options for the autocomplete plugin
		'options'=>array(
			'minLength' => '2',
			'showAnim'=>'fold',
			 'search' =>'js: function() {
	            var term = this.value.split(/,s*/).pop();
	            if(term.length < 2)
	                return false;
	         }',
	         'change' => 'js: function(event,ui){
	         	var city = ui.item.value;	
				$.ajax({
					type: "GET",
					url: "/site/changeCity",
					data: {city : city, lang : "' . Yii::app()->language .'"},
					dataType: "text",
					success: function(data){
					    var city = data.split("_");
					    if(city.length == 2){
					        document.location.href=city[1];
					    }
					    $(".cityName").text(city[0]);
						$(".sort-popup").addClass("hidden");
					}
				});
	         }',
	        'focus' =>'js: function() {
	            return false;
	         }',
		),
		'htmlOptions' => array(
			'placeholder'=>Yii::t('main','Enter the city of delivery'),
			'title' => Yii::t('main','Recipient City'),
		),
	));
	?>
    
    <div class="h-regions">
        <div class="regions" style="width: 100%;">
            <h2 class="title">
                <?=Yii::t('main','Ukraine')?>
			</h2>
            	<?php
            	$count=0;
            	$cities = Yii::app()->db->createCommand()
				    ->select('c.name as ename,ct.name,ct.object_id,c.id,ct.language_id,ctt.name as eng_name')
				    ->from('city c')
				    ->join('cityTranslate ct', 'c.id=ct.object_id')
				    ->join('cityTranslate ctt', 'c.id=ctt.object_id')
				    ->where('ct.language_id=:id', array(':id'=>$this->language_info->id))
				    ->andWhere('c.show_in_popup=1')
				    ->andWhere('ctt.language_id=:eid', array(':eid'=>9))
					->order('ct.name, id desc')
				    ->queryAll();
                if(!empty($cities)){
                    $parts = 3;
                    if(sizeof($cities) >= $parts){
                        $part_size = ceil((sizeof($cities) / $parts));
                        $cities_chunked = array_chunk($cities, $part_size);
                    }
                    else{
                        $cities_chunked[0] = $cities;
                    }
                    foreach ($cities_chunked as $city_chunk) {
                        ?>
                        <div style="width: <?=(100 / $parts);?>%; float: left;">
                            <ul>
                            <?php
                            foreach ($city_chunk as $city) {
                            ?>
                            <li>
                                <?php // замена пробелов на _ в названиях городов (krivoy rog --> krivoy_rog) ?>
                                <?= CHtml::link($city['name'], Yii::app()->createUrl('/' . strtolower(str_replace(' ', '_', $city['eng_name'])))); ?>
                            </li>
                            <?php
                            }
                            ?>
                            </ul>
                        </div>
                    <?php
                    }
                }
				?>
        </div>
    </div>
	<br>
	<?= CHtml::link(Yii::t('main','Didn\'t find city? Click here!'), Yii::app()->createUrl('/all-cities'), array('class' => 'all-cities')); ?>
</div>
