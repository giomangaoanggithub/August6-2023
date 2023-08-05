<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/page_models_accuracy.css">
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
    <div class="info-placement">
        <div class="info-content">
            <div id="all-file">
                <strong>User: </strong><span>Demo User Account</span><br><strong>User's Files:
                </strong><span id="user-files-content"></span><br><strong>Description: </strong><span>This
                    bar displays different colors and each color in the spectrum represents a context.</span>
            </div>
            <div id="all-model-container">
                <div id="all-model"></div>
            </div>
            <div id="diverse-color-context">
                <div class="diverse-context">
                </div>
                <div class="diverse-context">
                </div>
                <div class="diverse-context">
                </div>
                <div class="diverse-context">
                </div>
                <div class="diverse-context">
                </div>
                <div class="diverse-context">
                </div>
                <div class="diverse-context">
                </div>
            </div>
        </div>
    </div>

    <div class="info-placement">
        <div class="info-content">
            <div id="questions-label"><strong>Questions:</strong></div>
            <div id="list-of-questions">
            </div>
        </div>
    </div>

    <div class="info-placement">
        <div class="info-content">
            <div>
                <strong>Confusion Matrix: </strong>
            </div>
            <div id="confusion-matrix-placement" class="row">
                <div class="confusion-tile col-6">TP</div>
                <div class="confusion-tile col-6">FP</div>
                <div class="confusion-tile col-6">TN</div>
                <div class="confusion-tile col-6">FN</div>
            </div>
        </div>
    </div>
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/@grammarly/editor-sdk?clientId=client_62yhGBCs2fHyAsj5rWRoWu"></script> -->
<script src="../js/page_register_login_struct.js"></script>
<script src="../js/page_models_accuracy.js"></script>

</html>