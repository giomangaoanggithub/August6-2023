<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/page_test.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/tw-cen-mt-condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.ico">

    <title>DEMO</title>
</head>

<body>
    <div id="overlay"></div>
    <div id="show-loading"><img src="../imgs/loading.gif" alt="" style="width: 10%"></div>
    <div id="user_files" class="row">
        <div class="display-user-style col-sm-6">
            <div>
                User1
            </div>
            <div>
                <strong>files: </strong><span id="user1-files"></span>
            </div>
        </div>
        <div class="display-user-style col-sm-6">
            <div>
                User2
            </div>
            <div>
                <strong>files: </strong><span id="user2-files"></span>
            </div>
        </div>
    </div>
    <div>
        <div id="write-a-question" class="display-user-style">
            <div id="label-write-a-question">Write a Question:</div>
            <input id="input-question" type="text"><br><br>
            <button onclick="show_eta()">SUBMIT</button>
        </div>
    </div>
    <div class="row">
        <div class="display-user-style col-sm-6">
            <div id="num-of-contexts1" class="context-label"><strong>User1 Contexts:</strong></div>
            <div id="user-context1"></div>
        </div>
        <div class="display-user-style col-sm-6">
            <div id="num-of-contexts2" class="context-label"><strong>User2 Contexts:</strong></div>
            <div id="user-context2"></div>
        </div>
    </div>
    <div>
        <div style="padding: 1vh;" class="display-user-style ">
            <div id="label-curr-question" class="display-curr-question"></div>
            <div id="input-curr-question" class="display-curr-question">
                <grammarly-editor-plugin id="grammarlyapi">
                    <textarea id="textarea-answer" onkeyup="count_words()"></textarea>
                </grammarly-editor-plugin>
            </div>
            <div><span>You have </span><span id="count-words">0</span><span> / 50</span></div>
            <div style="text-align: center;"><button onclick="check_num_words()">SUBMIT</button></div>
        </div>
    </div>
    <div class="row">
        <div class="display-user-style col-sm-6">
            <div class="context-label"><strong>User1 Evaluation:</strong></div>
            <div id="user-score1"><strong>Score: </strong>Please answer the current question...</div>
        </div>
        <div class="display-user-style col-sm-6">
            <div class="context-label"><strong>User2 Evaluation:</strong></div>
            <div id="user-score2"><strong>Score: </strong>Please answer the current question...</div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@grammarly/editor-sdk?clientId=client_62yhGBCs2fHyAsj5rWRoWu"></script>
<script src="../js/page_register_login_struct.js"></script>
<script src="../js/page_test_data.js"></script>
<script src="../js/page_test_struct.js"></script>

</html>