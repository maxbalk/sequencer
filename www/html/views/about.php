<?php
class aboutPage extends View {
    public function build()
    {
        $stylesheet = "styles/about.css";
        $script = "";
    ?>
        <h1>welcome to the about page</h1>
        <a onclick="navigate('')" class="left btn btn-light">back to home page</a>
        <form display="hidden">
            <input type="hidden" name="route" value="homePage">
        </form>
        <br>
        <div>
            this is the part where i link pictures and video
        </div>
    <?php
        $this->getContent($stylesheet, $script);
    }
}