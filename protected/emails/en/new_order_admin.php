<html>
<body>
<p>From:  <?=$name?></p>
<p>Email: <?=$email?></p>
<p>Phone Number:  <?=$phone?></p>
<p>Product ID: <?=$id?></p>
<?=$quantity?>
<p>Product name: <?php $model=StoreProduct::model()->findByAttributes(array('id'=>$id)); echo $model->name;?></p>


</body>
</html>