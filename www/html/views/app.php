<?php
class appPage extends View
{
    public function build($loggedIn)
    {
        $stylesheet = "styles/app.css";
        $script = "scripts/app.js";
    ?>
                <form display="hidden">
                    <input type="hidden" name="route">
                </form>
                <h1>Keyboard Sequencer</h1>
                <a onclick="navigate('aboutPage')" class="left btn btn-light">About</a>
        <?php if($loggedIn){ ?>
                <div class="inputsGroup">
                    <form id="loopToSave">
                        <input type="text" id="loopName" placeholder="enter name of loop" class="form-control">
                    </form>
                    <div onclick="saveLoop()" class="btn btn-light">save current loop</div>
                    <div onclick="navigate('logout')" class="btn btn-light">log out</div>
                    <div class="dropdown">
                        <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            my saved loops
                        </button>
                        <div id="loopList" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            
                        </div>
                    </div>
                </div>
        <? } ?>
                <div id="displayArea"></div>
                <div class="layers">   
                </div>
                <div class="buttonContainer">
                    <button onclick="playButton(this)" class="btn btn-success">start playback</button>
                    <button onclick="record(this)" class="btn btn-danger">start recording</button>
        <?php if(!$loggedIn){ ?>
                <div onclick="navigate('loginPage')"class="btn btn-outline-light">You are not logged in. Click here to log in and gain access to saved loops</div>
        <? } ?>
                </div>
                <div class="keyboardContainer">
                    <ul class="keyboard"></ul>
                </div>
        <?php if($loggedIn){ ?>
            <script type="text/javascript">getLoops();</script>
        <? } ?>
    <?php
        $this->getContent($stylesheet, $script);
    }
}