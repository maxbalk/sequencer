<?php
abstract class View {    
    public function __construct(){
        error_reporting(E_ALL - E_NOTICE);
        ob_start();     
    }

    protected function getContent($stylesheet, $script){
        $content = ob_get_clean();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Sequencer</title>
            <script src=<?= $script ?>></script>
            <link rel="stylesheet" type="text/css" href="styles/styles.css">
            <link rel="stylesheet" type="text/css" href=<?=$stylesheet?>>
        </head>
        <body>
            <div class="mainContainer">
            <?= $content ?>
            </div>
        </body>
        <?php
    }
}