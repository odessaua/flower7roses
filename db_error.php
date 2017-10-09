<?php
/*
 * $event->exception->getMessage()
 * $event->exception->getCode()
 * $event->exception->getFile()
 * $event->exception->getLine()
 *
 * оформляем страницу произвольно
 */
?>
<script>
    // вывод ошибок в консоль браузера
    console.log(
        "DB Error:\n",
        "<?= $event->exception->getCode(); ?> \n",
        "<?= $event->exception->getMessage(); ?> \n",
        "<?= $event->exception->getFile(); ?> \n",
        "<?= $event->exception->getLine(); ?> \n"
    );
</script>
<style>
    .oops {
        margin-top: 50px;
    }
    .oops h2 {
        text-align: center;
        color: #af3583;
    }
</style>
<div class="oops">
    <h2>Oops! We have some problems with our DB now((</h2>
    <h2>Please, try again later!</h2>
</div>