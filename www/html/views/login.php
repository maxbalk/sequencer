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
        <br>
        <div>
            <div class="formContainer">
                <form id="loginForm" method="post">
                    <input type="hidden" name="route">
                    <input type="text" name="username" placeholder="enter username">
                    <input type="text" name="password" placeholder="enter password">
                </form>
                <button onclick="processForm('doLogin')" class="btn btn-light">Log in</button>
                <div id="displayArea"></div>
            </div>
        </div>
    <?php
        $this->getContent($stylesheet, $script);
    }
}