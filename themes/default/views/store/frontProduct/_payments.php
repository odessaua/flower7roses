<?php
$payments = StorePaymentMethod::model()->findAll(array(
    'condition' => 'active = 1',
    'order' => 'position ASC',
));
?>
<style>
    .payment-row-name{
        text-transform: uppercase;
        color: #7a1c4a;
        font-size: 18px;
        margin: 25px 0 20px;
        font-weight: bold;
    }
    .payment-row-description h2,
    .payment-row-description h3{
        font-size: 16px;
        color: #29a943;
    }
</style>
<div class="title"><?=Yii::t('StoreModule.core', 'Payment methods'); ?></div>
<div class="content-text">
    <?php
    if(!empty($payments)):
        foreach($payments as $payment):
    ?>
    <div class="payment-row">
        <div class="payment-row-name"><?=$payment->name; ?></div>
        <div class="payment-row-description"><?=$payment->description; ?></div>
    </div>
    <?php
        endforeach;
    endif;
    ?>
</div>
