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
            <img src="cookies.jpg">
            <img src="mydudes.jpg">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/0rLjj52vtA4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    <?php
        $this->getContent($stylesheet, $script);
    }
}