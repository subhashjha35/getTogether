<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="./css/font-awesome.css">
    <link rel="stylesheet" href="./css/bootstrap.css">
    <script src="./js/jquery.min.js"></script>
    <script src="./js/pubnub.min.js"></script>
    <script src="./js/webrtc.js"></script>
    <script src="https://cdn.pubnub.com/webrtc/rtc-controller.js"></script>


    <script src="./js/bootstrap.js"></script>
    <script>
        var video_out = document.getElementById("vid-box");
        var vid_thumb = document.getElementById("vid-thumb");
        function login(form) {
            var video_out = document.getElementById("vid-box");
            var vid_thumb = document.getElementById("vid-thumb");
            var phone = window.phone = PHONE({
                number        : form.username.value || "Anonymous", // listen on username line else Anonymous
                publish_key   : 'pub-c-ff12495e-f77a-444c-9619-b8610dae5a33',
                subscribe_key : 'sub-c-cdc1341e-15de-11e7-a9ec-0619f8945a4f',
            });

            var ctrl = window.ctrl = CONTROLLER(phone);
            ctrl.ready(function(){
                form.username.style.background="#55ff5b"; // Turn input green
                form.login_submit.hidden="true";	// Hide login button
                ctrl.addLocalStream(vid_thumb);		// Place local stream in div
            });
            // Called when ready to receive call
            ctrl.receive(function(session){
                session.connected(function(session){ video_out.appendChild(session.video); });
                session.ended(function(session) { ctrl.getVideoElement(session.number).remove(); });
            });

            return false; //prevents form from submitting

        }
        function makeCall(form){
            if (!window.phone) alert("Login First!");
            else ctrl.dial(form.number.value);
            return false;
        }
        function mute(){
            var audio = ctrl.toggleAudio();
            if (!audio) $("#mute").html("Unmute");
            else $("#mute").html("Mute");
        }

        function pause(){
            var video = ctrl.toggleVideo();
            if (!video) $('#pause').html('Unpause');
            else $('#pause').html('Pause');
        }
        function end(){
            ctrl.hangup();
        }
    </script>
</head>
<body>
<?php include "header.php";?>
<div class="container ">
    <div class="row col-md-6 col-md-offset-3">
        <div class="form-group">
            <form name="loginForm" id="login" action="#" onsubmit="return login(this);">
                <div class="input-group">
                    <input type="text" name="username" id="username" value="<?=$_SESSION['username'];?>" class="form-control" readonly/>
                    <div class="input-group-btn">
                        <input type="submit" name="login_submit" value="Log In" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>

        <div class="form-group">
            <form name="callForm" id="call" action="#" onsubmit="return makeCall(this);">
                <div class="input-group">
                    <input type="text" name="number" class="form-control" />
                    <div class="input-group-btn">
                        <input type="submit" value="Call" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>

        <div id="inCall" class="btn-group btn-group-justified"> <!-- Buttons for in call features -->
            <div class="btn-group">
                <button class="btn btn-danger" id="end" onclick="end()">End</button>
            </div>
            <div class="btn-group">
                <button class="btn btn-info" id="mute" onclick="mute()">Mute</button>
            </div>
            <div class="btn-group">
                <button class="btn btn-warning" id="pause" onclick="pause()">Pause</button>
            </div>

        </div>
    </div>
        <div class="container">
            <div id="vid-box"></div>
        </div>
        <div class="container">
            <div id="vid-thumb" class="col-md-2 col-md-offset-5"></div>
        </div>
    </div>
</div>
</body>
</html>