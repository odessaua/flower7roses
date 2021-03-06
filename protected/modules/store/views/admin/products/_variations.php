<?php

/**
 * Product update.
 * Options tab.
 */

if ($model->type)
{
	$chosen = array(); // Array of ids to enable chosen
	$attributes = $model->type->storeAttributes;

	if(empty($attributes))
		echo Yii::t('StoreModule.admin', 'Список свойств пустой');
	else
	{
		foreach($attributes as $a)
		{
			// Repopulate data from POST if exists
			if(isset($_POST['StoreAttribute'][$a->name]))
				$value = $_POST['StoreAttribute'][$a->name];
			else
				$value = $model->getEavAttribute($a->name);

			$a->required ? $required = ' <span class="required">*</span>' : $required = null;

			if($a->type == StoreAttribute::TYPE_DROPDOWN)
			{
				$chosen[] = $a->getIdByName();

				$addOptionLink = CHtml::link(' +', '#', array(
					'rel'       => $a->id,
					'data-name' => $a->getIdByName(),
					'onclick'   => 'js: return addNewOption($(this));',
					'class'     => 'bold',
					'title'     => Yii::t('StoreModule.admin', 'Создать опцию')
				));

			}else
				$addOptionLink = null;

			echo CHtml::openTag('div', array('class'=>'row', 'style'=>'display:none'));
			echo CHtml::label($a->attr_translate->title.$required, $a->name, array('class'=> $a->required ? 'required' : ''));
			echo '<div class="rowInput eavInput" style="width:350px">'.$a->renderField($value).'</div>';
			echo CHtml::closeTag('div');
		}
	}

	// Enable chosen
	$this->widget('application.modules.admin.widgets.schosen.SChosen', array('elements'=>$chosen));

}
?>

<?php
/**
 * @var StoreProduct $model
 */

 
$this->widget('admin.widgets.schosen.SChosen', array(
	'elements'=>array()
));

Yii::app()->getClientScript()->registerScriptFile($this->module->assetsUrl.'/admin/products.variations.js', CClientScript::POS_END);

?>

<div class="variants">
	<div class="row">
		<label>Добавить атрибут</label>
		<?php
			if($model->type)
			{
				$attributes = $model->type->storeConfigurableAttributes;
				echo CHtml::dropDownList('variantAttribute', null, CHtml::listData($attributes, 'id', 'name'));
			}
		?>
		<a href="#" id="addAttribute">Добавить</a>
	</div>

	<hr>


	<div id="variantsData">
		<?php
			foreach($model->processVariants() as $row)
			{
				$this->renderPartial('variants/_table', array(
					'attribute'=>$row['attribute'],
					'options'=>$row['options']
				));
			}
		?>
	</div>
</div>


