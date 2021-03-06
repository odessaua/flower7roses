<?php

/**
 * View page
 * @var Page $model
 */

// Set meta tags
$this->pageTitle       = ($model->meta_title) ? $model->meta_title : $model->title;
$this->pageKeywords    = $model->meta_keywords;
$this->pageDescription = $model->meta_description;
?>

<div>
    <!-- breadcrumbs (begin) -->
    <ul class="breadcrumbs">
        <li><a href="/" title=""><?=Yii::t('main','Home')?></a></li>
        <li>&nbsp;/&nbsp;</li>
        <li><?php echo $model->title; ?></li>
    </ul>
    <!-- breadcrumbs (end) -->

    <h1 class="page-title"><?php echo $model->title; ?></h1>

    <div class="g-clearfix">
        <div class="content-img">
            <img src="img/delivery.jpg" alt=""/>
        </div>
        <div class="content-text delivery-content-text">
            <h2>Доставка</h2>
            <p>
                Цветы и выбранные вами подарки будут доставлены точно в указанный вами день. Мы делаем все возможное, чтобы удовлетворить наших заказчиков. Попробуйте воспользоваться нашими услугами один раз и вы потом не променяете нас ни на кого другого :)!
            </p>
            <p>
                Вот некоторые детали, которые вам необходимо знать.
            </p>
            <p>
                Когда вы закончили покупки, нажмите кнопку "Оплатить заказ". В открывшейся форме, заполните, пожалуйста, все поля, и нажмите кнопку "Send".
            </p>
            <p>
                <em>
                    <span>
                    ВАЖНО: Если вы не находите ваш населенный пункт в выпадающем списке, ВПЕЧАТАЙТЕ его в окошко. Это значит, что наш агент поедет туда из ближайшего города и стоимость доставка в него изменится и будет зависеть от расстояния до этого места от нашего ближайшего магазина. Наш администратор сообщит стоимость доставки в ваш населенный пункт после расчета расстояния и выяснения возможности поездки нашего агента туда.
                    </span>
                </em>
            </p>
            <p>
                Не забудьте указать номер телефона получателя. Мы должны обязательно связаться с ним/ней перед выездом с тем, чтобы доставка состоялась. Иногда наши заказчики просят ехать без предупреждения. Это на самом деле не так хорошо для самого заказчика, как ему может казаться. Дело в том, что если мы не застанем дома получателя, деньги за этот заказ не возвращаются. Цветы, продукты и т.п. сдать назад в магазин невозможно.
            </p>
            <h3>Города, где есть наши представители</h3>
            <p>
                Представители компании " 7 РОЗ " есть во всех крупных и средних городах Украины. Список таких городов ниже. Это значит, что все, что вы хотите ваш заказ будет там с любовью собран. Наши представители созвонятся с получателем и спросят о наиболее
                удобном времени и месте встречи с ним или ею. Иногда получатель желает получить поздравление на работе, в ресторане (если там происходит вечеринка), или где-либо еще. Также получатель говорит нам, в какое время ему или ей было бы удобнее всего получить подарки. Поэтому мы всегда спрашиваем об этом с тем, чтобы не приехать в неудобное время или место и чтобы получатель был наиболее счастлив.
            </p>
            <p>
                В этих городах стоимость нашей работы стандартна и равно $15.00.
            </p>
            <p>
                Мы также можем доставить подарки в другие маленькие города или деревни. В этом случае наш представитель выедет туда из ближайшего города. В зависимости от расстояния, будет определена дополнительная стоимость выезда. Мы вам сообщим и вы решите, хотите ли вы оставлять ваш заказ и оплачивать его.
            </p>
            <p>
                <strong>Вот список городов, где есть наши представители:</strong>
            </p>
            <ul style="color: #7a1c4a; font-style: italic;">
                <li style="display: inline-block; vertical-align: top; margin-right: 45px;">
                    <ul>
                        <li>Винница</li>
                        <li>Бердянск</li>
                        <li>Белая Церковь</li>
                        <li>Горловка</li>
                        <li>Донецк</li>
                        <li>Днепропетровск</li>
                        <li>Евпатория</li>
                        <li>Житомир</li>
                        <li>Запорожье</li>
                        <li>Ивано-Франковск</li>
                        <li>Измаил</li>
                        <li>Керчь</li>
                        <li>Кривой Рог</li>
                        <li>Кременчуг</li>
                        <li>Кировоград</li>
                        <li>Киев</li>
                    </ul>
                </li>
                <li style="display: inline-block; vertical-align: top; margin-right: 45px;">
                    <ul>
                        <li>Луганск</li>
                        <li>Луцк</li>
                        <li>Львов</li>
                        <li>Мариуполь</li>
                        <li>Мелитополь</li>
                        <li>Николаев</li>
                        <li>Одесса</li>
                        <li>Полтава</li>
                        <li>Ровно</li>
                        <li>Симферополь</li>
                        <li>Сумы</li>
                        <li>Севастополь</li>
                        <li>Тернополь</li>
                        <li>Ужгород</li>
                        <li>Харьков</li>
                        <li>Хмельницкий</li>
                    </ul>
                </li>
                <li style="display: inline-block; vertical-align: top; margin-right: 45px;">
                    <ul>
                        <li>Херсон</li>
                        <li>Черкассы</li>
                        <li>Чернигов</li>
                        <li>Черновцы</li>
                        <li>Ялта</li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="content-text payment-content-text">
            <h2>Оплата</h2>
            <p><strong>Способы оплаты:</strong></p>
            <ol>
                <li>
                    Наличными из рук в руки - вы можете передать деньги нашему представителю в вашем городе. Для этого выберите этот способ оплаты при составлении заказа, оставьте свой телефон
                    и мы свяжемся с вами по телефону или е-мейлу, чтобы договориться о передаче денег.
                </li>
                <li>
                    <img src="img/payment-visa.jpg" width="68" height="34" style="margin-right: 15px;" alt=""/>
                    <strong>Visa</strong>
                </li>
                <li>
                    <img src="img/payment-paypal.jpg" width="68" height="34" style="margin-right: 15px;" alt=""/>
                    <strong>Paypal</strong>
                </li>
                <li>
                    <img src="img/payment-webmoney.jpg" width="68" height="34" style="margin-right: 15px;" alt=""/>
                    <strong>Webmoney</strong>
                </li>
                <li>
                    <img src="img/payment-yamoney.jpg" width="68" height="34" style="margin-right: 15px;" alt=""/>
                    <strong>Яндекс деньги</strong>
                </li>
                <li>
                    <img src="img/payment-qiwi.jpg" width="68" height="34" style="margin-right: 15px;" alt=""/>
                    <strong> Qiwi</strong>
                </li>
                <li>
                    <img src="img/payment-card.jpg" width="68" height="34" style="margin-right: 15px;" alt=""/>
                    <strong>Банковский перевод</strong>
                </li>
            </ol>
        </div>
    </div>
</div>
