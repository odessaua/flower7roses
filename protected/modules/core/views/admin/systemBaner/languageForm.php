<?php

/**
 * Create/update language form 
 */

return array(
	'id'=>'languageUpdateForm',
    'enctype'=>'multipart/form-data',
	'elements'=>array(
		'name'=>array(
            'type'=>'text',
            'hint'=>Yii::t('StoreModule.admin', 'Название является идентификатором для установки баннеров на определённые позиции в коде.<br>Может быть несколько баннеров с одинаковым Названием – но активным будет только один из них!')
        ),
		'url'=>array(
            'type'=>'text',
            ),
        'photo'=>array(
            'type'=>'file',
        ),
        'active'=>array(
            'type'=>'dropdownlist',
            'items'=>array(
                1=>'Да',
                0=>'Нет'
            ),
            'hint'=>Yii::t('StoreModule.admin', '«Да» – автоматически снимает активность со всех других баннеров с таким же Названием!<br>Выбирая «Нет» – не забудьте активировать другой баннер с таким же названием, иначе на месте баннера будет пустота.')
        ),
	),
);

