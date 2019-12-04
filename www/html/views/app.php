<?php
require('view.php');
class appPage extends View{
    public function build(){
        $stylesheet = "styles/app.css";
        $script = "scripts/app.js";
    ?>
                <div class="layers">   
                </div>
                <button onclick="playButton()">play/stop</button>
                <button onclick="record()">record</button>
                <button onclick="saveLoop()">save current loop</button>
                <div class="keyboardContainer">
                    <ul class="keyboard"></ul>
                </div>
    <?php
        $this->getContent($stylesheet, $script);
    }
}