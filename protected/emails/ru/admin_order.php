<?php
header("Content-type: text/plain");
	echo "New order #: ".$order->id." to ".$order->receiver_city."\r\n\r\n";
    echo "Delivery Date: ".$order->datetime_del."\r\n\r\n";
    echo "Name: ".$order->receiver_name."\r\n";
    echo "Address: ".$order->user_address."\r\n";
    echo "Phone #1: ".$order->phone1."\r\n";
    echo "Phone #2: ".$order->phone2."\r\n\r\n";
    echo "Additional Info: ".$order->user_comment."\r\n\r\n";
    echo "Greeting Card: ".$order->card_text."\r\n\r\n";
    echo "Info about sender \r\n\r\n";
    echo "Name: ".$order->user_name."\r\n";
    echo "Email: ".$order->user_email."\r\n";
    echo "Country: ".$order->country."\r\n";
    echo "City : ".$order->city."\r\n";
    echo "Phone: ".$order->user_phone."\r\n\r\n";
    echo "Info about order \r\n\r\n"; 
	echo "Delivery Fee: ".$model->delivery_price." USD\r\n";
	if ($order->doPhoto == 1)	echo "Photo of the delivery: paid \n";
		else echo "Photo of the delivery: not paid \n";
	if ($order->do_card == 1)	echo "Greeting card: paid \n";
		else echo "Greeting card: not paid \n\r\n";
	 foreach($model->getOrderedProducts()->getData() as $product): 
	 
      $pro_model = StoreProduct::model()->findByPk($product->product_id);
		echo $product->getRenderFullName(false);   echo " - ".$product->price."\n";
     endforeach;
	 echo "Total Price: ".$order->total_price."\r\n\r\n";
?>
