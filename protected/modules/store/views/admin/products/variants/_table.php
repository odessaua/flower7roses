<?php



/**
 * Represent attribute row on "Variants" tab
 *
 * @var StoreAttribute $attribute
 */
?>

<table class="variantsTable" id="variantAttribute<?php echo $attribute->id ?>">
	<thead>
	<tr>
		<td colspan="6">
			<h4>
				<?php
					echo CHtml::encode($attribute->title);
					echo CHtml::link(' +', '#', array(
						'rel'=>'#variantAttribute'.$attribute->id,
						'onclick'=>'js: return cloneVariantRow($(this));'
				));
				?>
			</h4>
			<?php
				echo CHtml::link(' Добавить опцию', '#', array(
					'rel'       => $attribute->id,
					'onclick'   => 'js: return addNewOption($(this));',
					'data-name' => $attribute->getIdByName(),
			));
			?>
		</td>
	</tr>
	<tr>
		<td>Значение</td>
		<td>Цена</td>
		<td>Тип цены</td>
		<td>Артикул</td>
		<td>По умолчанию</td>
		<td></td>
	</tr>
	</thead>
	<tbody>
	<?php
	if(!isset($options)):
		?>
	<tr>
		<td>
			<?php
			echo CHtml::dropDownList('variants['.$attribute->id.'][option_id][]', null, CHtml::listData($attribute->options, 'id', 'value'), array('class'=>'options_list'));
			?>
		</td>
		<td>
			<input type="text" class="price" name="variants[<?php echo $attribute->id ?>][price][]">
		</td>
		<td>
			<?php echo CHtml::dropDownList('variants['.$attribute->id.'][price_type][]', null, array(0=>'Фиксированная', 1=>'Процент')); ?>
		</td>
		<td>
			<input type="text" name="variants[<?php echo $attribute->id ?>][sku][]">
		</td>
		<td> 
			<input type="radio" class="default" name="default" value="" />
		</td>
		<td>
			<a href="#" onclick="return deleteVariantRow($(this));">Удалить</a>
		</td>
	</tr>
		<?php
	endif;
	?>
	<?php
	if(isset($options)):
		foreach($options as $o):
			?>
		<tr>
			<td>
				<?php
				echo CHtml::dropDownList('variants['.$attribute->id.'][option_id][]', $o->option->id, CHtml::listData($attribute->options, 'id', 'value'), array('class'=>'options_list'));
				?>
			</td>
			<td>
				<input type="text" class="price" name="variants[<?php echo $attribute->id ?>][price][]" value="<?php echo $o->price ?>">
			</td>
			<td>
				<?php echo CHtml::dropDownList('variants['.$attribute->id.'][price_type][]', $o->price_type, array(0=>'Фиксированная', 1=>'Процент')); ?>
			</td>
			<td>
				<input type="text" name="variants[<?php echo $attribute->id ?>][sku][]" value="<?php echo $o->sku ?>">
			</td>
			<td> 
				<input type="radio" class="default" name="default" value="<?=$o->option->id?>" style="margin-left: 40px;" <?= ($o->default > 0) ? 'checked="checked"' : ''; ?> />
			</td>
			<td>
				<a href="#" onclick="return deleteVariantRow($(this));">Удалить</a>
			</td>
		</tr>
			<?php
		endforeach;
	endif;
	?>
	</tbody>
</table>

<script type="text/javascript">
$(document).ready(function(){
	
	$(".default").click(function(){
		
		var def = $(this).parent().parent().find('.options_list').val();
		$("#StoreAttribute_flowers_qty").val(def);
		
		var price = $(this).parent().parent().find('.price').val();
		//alert(price);
		$("#StoreProduct_price").val(price);
	});
	
	var value = $("#StoreAttribute_flowers_qty").val();
	$(".default[value="+value+"]").prop('checked', true);
	
	//alert($("#StoreAttribute_flowers_qty").val());
	
	//$(".default").val($("#StoreAttribute_flowers_qty").val()).attr('selected', 'selected');
	
});
</script>