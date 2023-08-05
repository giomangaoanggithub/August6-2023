<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essay Speed Checker</title>
    <link rel="stylesheet" href="../css/page_student.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/tw-cen-mt-condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.ico">
</head>

<body class="p-4">
    <div id="current-time">
        <?php echo date('Y-m-d H:i:s', strtotime("+ 6 hours")); ?>
    </div>
    <div id="overlay"></div>
    <div id="show-loading"><img src="../imgs/loading.gif" alt=""></div>
    <div id="green-prompt">
        <div id="insert-title-div"><span id="insert-title">Title Here...</span></div>
        <div id="green-prompt-content"></div><br>
        <div id="answering-area" style="z-index: 2">
            <grammarly-editor-plugin id="grammarlyapi">
                <!-- grammarly_stopper() -->
                <textarea cols="30" rows="10" id="textarea-answer" style="opacity: 100%" spellcheck="false"
                    onkeyup="count_words()" onclick="grammarly_stopper()"></textarea>

                <button onclick="cancel_btn_function()">CANCEL</button>
                <button onclick="check_num_words()">SUBMIT</button>
                <span>You have </span><span id="count-words">0</span><span> / 50</span>

            </grammarly-editor-plugin>
        </div>
    </div>
    <div id="show-username">
        <span>Name: </span><span id="inserted-name"></span>
        <span id="edit-username" class="material-icons">edit</span>
    </div>
    <div class="row">
        <div class="course-code-input col-sm-6"><input type="text" id="course-code-input"
                placeholder="Search Course Code" size="30">
        </div>
        <div class="student-navbar col-sm-6 row">
            <div class="col-2 d-inline"><button id="enter-course-code">ENTER</button></div>
            <div class="col-7 d-inline"></div>
            <div class="col-3 d-inline"><button id="logout-btn">LOGOUT</button></div>
        </div>
    </div>
    <div class="table-of-tasks">
        <div>
            <h1>TASKS</h1>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th style="width:30%">Teacher</th>
                        <th style="width:40%">Question</th>
                        <th style="width:10%">Status</th>
                        <th style="width:10%">Grade & HPS</th>
                        <th style="width:10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="show-no-publish">
                        <td colspan="5" style="background-color: rgb(155, 157, 151);">No published questions yet...</td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div class="student-table-scrollable">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width:30%; opacity: 0%"></th>
                                            <th style="width:40%; opacity: 0%"></th>
                                            <th style="width:10%; opacity: 0%"></th>
                                            <th style="width:10%; opacity: 0%"></th>
                                            <th style="width:10%; opacity: 0%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="student-table-content">

                                    </tbody>
                                </table>
                            </div>

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>


    </div>
    <div class="table-of-entered-courses">
        <div>
            <h1>COURSE</h1>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th style="width:80%">Teacher</th>
                        <th style="width:20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="show-no-course">
                        <td colspan="2" style="background-color: rgb(155, 157, 151);">No entered course yet...</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="student-table-scrollable">
                                <table>
                                    <thead>
                                        <tr>
                                            <th style="width:80%; opacity: 0%"></th>
                                            <th style="width:20%; opacity: 0%"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-connected-teachers">
                                    </tbody>
                                </table>
                            </div>

                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/@grammarly/editor-sdk?clientId=client_62yhGBCs2fHyAsj5rWRoWu"></script>
<script id="page_register_login_struct" src="../js/page_register_login_struct.js"></script>
<script id="page_student_struct" src="../js/page_student_struct.js"></script>
<script id="page_student_funct" src="../js/page_student_funct.js"></script>

</html>