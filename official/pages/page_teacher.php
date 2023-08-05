<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essay Speed Checker</title>
    <link rel="stylesheet" href="../css/page_teacher.css">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/tw-cen-mt-condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../imgs/favicon.ico">
</head>

<body class="p-3 bg-info">
    <div id="overlay"></div>
    <div id="show-loading"><img src="../imgs/loading.gif" alt="" style="width: 10%"></div>
    <div id="green-prompt">
        <div id="insert-title-div"><span id="insert-title">Title Here...</span></div>
        <div id="green-prompt-content"></div>
    </div>
    <div class="row">
        <div class="teacher-left-side col-sm-6">
            <div id="show-username">
                <span>Name: </span><span id="inserted-name"></span>
                <span id="edit-username" class="material-icons">edit</span><br><span id="account-course-code">Course
                    Code: </span><span class="material-icons" id="account-course-code-show">visibility_off</span>
            </div>
            <div id="teacher-left-side-title" class="row">
                <div class="col-10"><span style="font-size: 65px">Write a Question...</span><span
                        class="prompt-data-insertion material-icons" style="position: relative"
                        onclick="open_machine_knowledge()">psychology</span></div>
                <div class="col-2" id="logout-area"><button id="logout-btn">LOGOUT</button></div>

            </div>
            <div id="teacher-left-side-input-question">
                <input type="text" size="70" id="post-question-content" placeholder="Write question here..."><br>
                Due Date: <input type="datetime-local"
                    value="<?php echo date('Y-m-d', strtotime(' + 4 days')); ?>T23:59" name="" id="due-input">
                HPS: <input type="number" name="" min="5" id="choose-grade" value="5">
                <button id="post-question">POST</button>
            </div>
            <div id="teacher-left-side-table">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 35%">
                                Question
                            </th>
                            <th style="width: 10%">
                                HPS
                            </th>
                            <th style="width: 30%">
                                Due Date
                            </th>
                            <th style="width: 25%">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <div id="teacher-left-side-table-scrollable">
                                    <table>
                                        <tr>
                                            <th style="width: 35%; opacity: 0%;"></th>
                                            <th style="width: 10%; opacity: 0%;"></th>
                                            <th style="width: 30%; opacity: 0%;"></th>
                                            <th style="width: 25%; opacity: 0%;"></th>
                                        </tr>
                                        <tbody id="teacher-left-side-table-tr">

                                        </tbody>
                                    </table>
                                </div>

                            </td>
                        </tr>

                        <tr id="if-empty-table-question">
                            <td colspan="4" style="background-color: rgb(0, 0, 0, 0.3);">Please
                                write a question...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="teacher-student-left-side-table">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 40%">
                                Name
                            </th>
                            <th style="width: 35%">
                                Email
                            </th>
                            <th style="width: 25%">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3">
                                <div id="teacher-student-left-side-table-scrollable">
                                    <table>
                                        <tr>
                                            <th style="width: 40%; opacity: 0%;"></th>
                                            <th style="width: 35%; opacity: 0%;"></th>
                                            <th style="width: 25%; opacity: 0%;"></th>
                                        </tr>
                                        <tbody id="teacher-student-left-side-table-tr">


                                        </tbody>
                                    </table>
                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td id="no-show-students" colspan="3" style="background-color: rgb(0, 0, 0, 0.3);">
                                No students yet...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class='teacher-right-side col-sm-6'>
            <div id="teacher-left-side-table">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 35%">

                            </th>
                            <th style="width: 10%">
                                Answers
                            </th>
                            <th style="width: 30%">

                            </th>
                            <th style="width: 25%">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="show-current-question" colspan="4" style="background-color: rgb(0, 0, 0, 0.3);">
                                No one answered yet...
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div id="teacher-right-side-table-scrollable">
                                    <table>
                                        <tr>
                                            <th style="width: 35%; opacity: 0%;"></th>
                                            <th style="width: 10%; opacity: 0%;"></th>
                                            <th style="width: 30%; opacity: 0%;"></th>
                                            <th style="width: 25%; opacity: 0%;"></th>
                                        </tr>
                                        <tbody id="teacher-right-side-table-tr">
                                            <!-- <tr>
                                                <td>2023-06-13 07:48:11<br><br>
                                                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quae, eum.
                                                    Minus architecto possimus sequi voluptas? Nulla, quas. Sint aliquam
                                                    iusto error ea ad possimus voluptatem? Tempora quae repellat vel
                                                    maxime.</td>
                                                <td>2</td>
                                                <td>John Duncnan L. Snow</td>
                                                <td><span class="material-icons">edit</span></td>
                                            </tr> -->

                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script src="../js/page_register_login_struct.js"></script>
<script src="../js/page_teacher_struct.js"></script>
<script src="../js/page_teacher_funct.js"></script>


</html>