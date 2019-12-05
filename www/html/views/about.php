<?php
class aboutPage extends View {
    public function build()
    {
        $stylesheet = "styles/about.css";
        $script = "";
    ?>
        <h1>welcome to the about page</h1>
    <?php
        $this->getContent($stylesheet, $script);
    }
}