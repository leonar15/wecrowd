<!DOCTYPE html>
<html>
    <head>
        <title>WeCrowd</title>
        <?=HTML::style("content/css/bootstrap.css")?>
        <?=HTML::style("content/css/bootstrap-responsive.css")?>
        <?=HTML::style("content/css/wecrowd.css")?>
        <?=HTML::style("content/css/introjs-nassim.css")?>
    </head>
    <body>
       <?=$header?>
        <div class="container">
            <?=$content?>
        </div>
        <?=HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js')?>
        <?=HTML::script('/content/js/bootstrap.js')?>
        <?=HTML::script('/content/js/intro.js')?>
    </body>
</html>