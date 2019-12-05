<?php
class loginPage extends View {
    public function build()
    {
        $stylesheet = "styles/login.css";
        $script = "scripts/login.js";
    ?>
        <h1>Login Page</h1>
        <a onclick="navigate('')" class="left btn btn-light">back to home page</a>
        <form  display="hidden">
            <input type="hidden" name="route" value="homePage">
        </form>
        <div>
            <form id=""></form>
        </div>
    <?php
        $this->getContent($stylesheet, $script);
    }
}