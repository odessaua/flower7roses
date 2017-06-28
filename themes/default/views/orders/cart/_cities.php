<?php
/**
 * Select2 для выбора городов
 */
// информация о текущей языковой версиии
$lang= Yii::app()->language;
if($lang == 'ua')
    $lang = 'uk';
$langArray = SSystemLanguage::model()->findByAttributes(array('code'=>$lang));
// список названий городов
$citiesList = Yii::app()->db->createCommand()
    ->select('object_id, name')
    ->from('cityTranslate')
    ->where('language_id = :lid', array(':lid' => $langArray->id))
    ->order('name ASC')
    ->queryAll();
// текущий город из сессиии
$currentCity = (!empty(Yii::app()->session['_city'])) ? Yii::app()->session['_city'] : Yii::t('main','Kyiv');

if(!empty($citiesList)):
?>
<link href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/select2.min.css" rel="stylesheet" />
<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/select2.min.js"></script>

    <span class="input-title"><span class="req">*</span><?= Yii::t('main','Recipient City'); ?>:</span>
    <select name="orderCity" id="orderCity">
        <?php
        foreach ($citiesList as $orderCity):
            $selected = ($orderCity['name'] === $currentCity) ? 'selected="selected"' : '';
        ?>
        <option value="<?= $orderCity['name']; ?>" <?= $selected; ?>><?= $orderCity['name']; ?></option>
        <?php endforeach; // ($citiesList as $orderCity) ?>
    </select>

<script type="text/javascript">
    // обработка списка городов
    jQuery(document).ready(function ($) {
        $('#orderCity').select2();

        $('#orderCity').on('change', function () {
            var cityName = $('#orderCity').val();
            $.ajax({
                type: "GET",
                url: "/site/changeCity",
                data: {city : cityName, lang : "<?= Yii::app()->language; ?>"},
                dataType: "text",
                success: function(data){
                    var city = data.split("_");
                    if(city.length == 2){
                        $(".cityName").text(city[0]);
                    }
                }
            });
        });
    });
</script>
<?php endif; // (!empty($citiesList)) ?>