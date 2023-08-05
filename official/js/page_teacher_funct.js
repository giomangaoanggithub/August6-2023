// this javascript program runs all the necessary operations needed on live during the use of the page_teacher.php
// operations like button clicks to request certain data or even a mouse hover to make it responsive

// this button click logs out the user
$("#logout-btn").click(function () {
  $.get(
    current_hosting_url + "php/js-request/current_session_destroy.php",
    function () {
      window.location = current_hosting_url + "pages/page_register_login.php";
    }
  );
});

var timer_count = 0;
function show_loading_prog() {
  if (timer_count < 60) {
    document.getElementById("overlay").innerHTML =
      eta + "<br>" + timer_count + "s";
  } else {
    minutes = Math.floor(timer_count / 60);
    seconds = timer_count % 60;
    document.getElementById("overlay").innerHTML =
      eta + "<br>" + minutes + "m: " + seconds + "s";
  }
  timer_count++;
  if (document.getElementById("overlay").style.display == "block") {
    setTimeout(show_loading_prog, 1000);
  } else {
    timer_count = 0;
  }
}

// this button click publishes a question to the students to answer
$("#post-question").click(function () {
  document.getElementById("overlay").style.display = "block";
  document.getElementById("show-loading").style.display = "block";
  loading_progress = "0%";
  document.getElementById("overlay").innerHTML = loading_progress;
  $.post(
    current_hosting_url + "php/create_question.php",
    {
      question: document.getElementById("post-question-content").value,
      hps: document.getElementById("choose-grade").value,
      due: document.getElementById("due-input").value,
    },
    function (response) {
      $.get(
        current_hosting_url + "php/js-request/page_teacher_start_data.php",
        function (data) {
          data = JSON.parse(data);
          if (data.length > 0) {
            document.getElementById("if-empty-table-question").style.display =
              "none";
            $("#teacher-left-side-table-tr").empty();
            for (i = 0; i < data.length; i++) {
              arr_questions.push(data[i]["question"]);
              arr_collected_links.push(data[i]["collected_links"]);
              arr_time_of_issue.push(data[i]["time_of_issue"]);
              arr_grades.push(data[i]["HPS"]);
              $("#teacher-left-side-table-tr").append(
                "<tr><td>" +
                  data[i]["question"] +
                  "</td><td>" +
                  data[i]["HPS"] +
                  "</td><td>" +
                  data[i]["due_date"] +
                  "</td><td><span class='material-icons'>edit</span><span class='material-icons'>delete</span></td></tr>"
              );
            }
          }
          document.getElementById("overlay").style.display = "none";
          document.getElementById("show-loading").style.display = "none";
          // alert(response);
        }
      );
    }
  );
  show_loading_prog();

  // while (loading_progress != "100%") {
  //   setTimeout(
  //     $.get(
  //       current_hosting_url + "php/js-request/display_loading.php",
  //       function (data) {
  //         loading_progress = data;
  //         document.getElementById("overlay").innerHTML = loading_progress;
  //       }
  //     ),
  //     10000
  //   );
  // }
});

// this button click unblurs or blurs the course code
$("#account-course-code-show").click(function () {
  if (
    document.getElementById("account-course-code-show").innerHTML ==
    "visibility_off"
  ) {
    document.getElementById("account-course-code").style.color = "black";
    document.getElementById("account-course-code").style.textShadow = "none";
    document.getElementById("account-course-code-show").innerHTML =
      "visibility";
  } else {
    document.getElementById("account-course-code").style.color = "transparent";
    document.getElementById("account-course-code").style.textShadow =
      "0 0 8px #000";
    document.getElementById("account-course-code-show").innerHTML =
      "visibility_off";
  }
});

//this button shows the prompt to change the account's username
$("#edit-username").click(function () {
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("insert-title").innerHTML = "Changing Username";
  document.getElementById("green-prompt-content").innerHTML =
    "<h2>Username:</h2><input id='new-username-input' value='" +
    document.getElementById("inserted-name").innerHTML +
    "'><br><br><button onclick='cancel_btn_function()'>CANCEL</button><button onclick='apply_change_username()'>APPLY</button>";
});

// this button click closes the overlay and the prompt form
function cancel_btn_function() {
  document.getElementById("overlay").style.display = "none";
  document.getElementById("green-prompt").style.display = "none";
}

// this button confirms the change of the account's username
function apply_change_username() {
  if (
    document.getElementById("inserted-name").innerHTML ==
    document.getElementById("new-username-input").value
  ) {
    alert("You still have the same Username");
  } else {
    $.post(
      current_hosting_url + "php/js-request/change_username.php",
      {
        username: document.getElementById("new-username-input").value,
        role: 1,
      },
      function (data) {
        alert(data);
        document.getElementById("inserted-name").innerHTML =
          document.getElementById("new-username-input").value;
        cancel_btn_function();
      }
    );
  }
}

function click_tr_question(num) {
  recent_selection = num;
  $.post(
    current_hosting_url + "php/js-request/page_teacher_fetch_question_data.php",
    { question_id: num },
    function (data) {
      // alert(data);
      data = JSON.parse(data);
      arr_raw_grades = [];
      for (i = 0; i < data.length; i++) {
        arr_raw_grades.push(data[i]["grades"]);
      }
      document.getElementById("show-current-question").style.display = "none";
      $("#teacher-right-side-table-tr").empty();
      if (data.length > 0) {
        arr_stud_grades = [];
        arr_stud_answer_address = [];
        for (i = 0; i < data.length; i++) {
          arr_stud_answer_address.push(data[i]["answer_id"]);
          arr_grade = data[i]["grades"].split("<&,&>");
          word_count = data[i]["answers"].split(" ").length;

          if (arr_grade[2] == 1) {
            calculated_grade = Math.floor(
              ((word_count - arr_grade[1]) / word_count) *
                (arr_grade[0] / 100) *
                data[i]["HPS"]
            );
            arr_stud_grades.push(calculated_grade + "/" + data[i]["HPS"]);
            $("#teacher-right-side-table-tr").append(
              "<tr><td colspan = '3' id='stud_answer_" +
                i +
                "'><strong>Time of Submission: </strong> " +
                data[i]["time_of_submission"] +
                "<br><strong>Grade: </strong>" +
                calculated_grade +
                " / " +
                data[i]["HPS"] +
                "<br><strong>User: </strong>" +
                data[i]["username"] +
                "<br><br>" +
                data[i]["answers"] +
                '</td><td><span class="material-icons" onclick="manualizing_grade(' +
                i +
                ')">edit</span></td></tr>'
            );
          } else {
            arr_stud_grades.push("0/" + data[i]["HPS"]);
            $("#teacher-right-side-table-tr").append(
              "<tr><td colspan = '3' id='stud_answer_" +
                i +
                "'><strong>Time of Submission: </strong> " +
                data[i]["time_of_submission"] +
                "<br><strong>Grade: </strong>0 / " +
                data[i]["HPS"] +
                "<br><strong>User: </strong>" +
                data[i]["username"] +
                "<br><br>" +
                data[i]["answers"] +
                '</td><td><span class="material-icons" onclick="manualizing_grade(' +
                i +
                ')">edit</span></td></tr>'
            );
          }
        }
      } else {
        document.getElementById("show-current-question").style.display =
          "table-cell";
      }
    }
  );
}

function disconnect_function(input) {
  confirming_disconnection = input;
  chosen_connection =
    arr_connections[arr_connections_id.indexOf(input.toString())];
  student = arr_connections[arr_connections_id.indexOf(input.toString())];
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("insert-title").innerHTML = "Disconnect?";
  document.getElementById("green-prompt-content").style.height = "5vh";
  document.getElementById("green-prompt-content").innerHTML =
    "Do you want to disconnect Teacher <strong>" +
    student +
    "</strong>?<br>You can reconnect via course code, if it is a mistake later on.<br><button onclick='cancel_btn_function()'>CANCEL</button><button onclick='confirm_disconnection()'>YES</button>";
}

function confirm_disconnection() {
  $.post(
    current_hosting_url + "php/js-request/user_disconnect.php",
    {
      connection_id: confirming_disconnection,
      connection_name: chosen_connection,
    },
    function (data) {
      alert(data);
      window.location = current_hosting_url + "pages/page_teacher.php";
    }
  );
}

function show_edit_question_prompt(input_id) {
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("insert-title").innerHTML = "Edit Mode (coming soon)";
  question = arr_questions[arr_questions_id.indexOf(input_id.toString())];
  links =
    arr_collected_links[arr_questions_id.indexOf(input_id.toString())].split(
      "<&,&>"
    );
  links_spanners = "";
  for (i = 0; i < links.length; i++) {
    links_spanners +=
      "<span class='highlightable-sources'><span class='delete-source material-icons'>delete</span>• " +
      links[i] +
      "</span><br>";
  }
  links_spanners =
    "<div id='linkspanner_scrollable'>" + links_spanners + "</div>";
  document.getElementById("green-prompt-content").innerHTML =
    "<span>" +
    question +
    "</span><br><br><input type='text' id='rewrite-question' placeholder='Rewrite question here...'><br><br>Sources:<div style='width: 100%; border: 2px solid #379683'></div><br>" +
    links_spanners +
    "<br><br><div style='width: 100%; border: 2px solid #379683'></div><button onclick='cancel_btn_function()'>CANCEL</button>";
}

function demonstration_page() {
  window.location = current_hosting_url + "pages/page_test.php";
}

function open_machine_knowledge() {
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("insert-title").innerHTML = "Your References";
  output = "";
  for (i = 0; i < arr_teacher_filenames.length; i++) {
    output +=
      `<span class='delete-source material-icons' onclick='delete_file("` +
      current_user +
      `","` +
      arr_teacher_filenames[i] +
      `", ` +
      i +
      `)'>delete</span><span class='highlightable-sources' onclick='open_file("` +
      current_user +
      `","` +
      arr_teacher_filenames[i] +
      `")'>• ` +
      arr_teacher_filenames[i] +
      "</span><br>";
  }

  output = "<div id='referencespanner_scrollable'>" + output + "</div>";
  document.getElementById("green-prompt-content").innerHTML =
    `<span>This is where you put all your <strong>references</strong> for the machine to <strong>read 
  and learn</strong>, in order for the machine to <strong>check essays</strong> for you. More references, the better.
  </span> Keep in mind, make sure your questions can be <strong>found</strong> from one of your references.<button onclick='demonstration_page()'>DEMO</button><br><br>
  Upload your reference here: <input type="file" name="fileToUpload" id="fileToUpload"><button id="upload-file" onclick='upload_file_function()'>UPLOAD</button><img id="loading-upload" src="../imgs/loading.gif" style="width: 3%; height: 5%; display: none;"><br><br>
  Sources:<div style='width: 100%; border: 2px solid #379683'></div>` +
    output +
    `<div style='width: 100%; border: 2px solid #379683'></div><br><input type="text" id="teacher-context-input" style="width: 50%;"><button id="simulate-btn" onclick="show_context_relations()">SIMULATE</button><img id="loading-graph" src="../imgs/loading.gif" style="width: 3%; height: 5%; display: none;">` +
    `<div id="compilation-time">Compilation-Time: </div>` +
    `<canvas style="display: none;" id="myChart" style="width:100%;max-width:1000px"></canvas>` +
    `<br>` +
    `<div id="possible-answers-sign" style="display: none"><h2>Possible Answers:</h2></div><br><div id="please-insert-sample" style="text-align: center;">Please input a sample question...</div><div id="stringify_data_phrases" style="display: none; background-color: white; padding: 10px;"></div>` +
    `<br><button onclick='cancel_btn_function()'>BACK</button><br><br>`;
  if (string_graph != "") {
    document.getElementById("myChart").style.display = "block";
    document.getElementById("please-insert-sample").style.display = "none";
    document.getElementById("possible-answers-sign").style.display = "block";
    document.getElementById("stringify_data_phrases").style.display = "block";
    document.getElementById("teacher-context-input").value =
      string_simulate_input;
    document.getElementById("stringify_data_phrases").innerHTML =
      string_ranked_context;
    eval(string_graph);
  }
}

function show_context_relations() {
  $.get(
    current_hosting_url + "php/js-request/check_userfile.php",
    function (data) {
      if (data == "Please upload your references first before simulating...") {
        alert(data);
      } else {
        document.getElementById("myChart").style.display = "block";
        document.getElementById("please-insert-sample").style.display = "none";
        document.getElementById("possible-answers-sign").style.display =
          "block";
        document.getElementById("stringify_data_phrases").style.display =
          "block";
        document.getElementById("loading-upload").style.display = "inline";
        document.getElementById("loading-graph").style.display = "inline";
        document.getElementById("simulate-btn").style.display = "none";
        document.getElementById("upload-file").style.display = "none";
        question_input = document.getElementById("teacher-context-input").value;
        $.post(
          current_hosting_url + "php/show_context_relations.php",
          { question: question_input },
          function (data) {
            stemmed_context = data;
            // alert(stemmed_context);
            $.post(
              current_hosting_url +
                "php/js-request/display_machine_knowledge.php",
              { sc: stemmed_context },
              function (data) {
                // decode data
                data = data.split("<,>");
                graph_output = data[0];
                stringify_data_phrases = data[1];
                xValues = data[2].split(",");
                document.getElementById("stringify_data_phrases").innerHTML =
                  stringify_data_phrases;
                graph_code =
                  `new Chart("myChart", {
                  type: "line",
                  data: {
                    labels: xValues,
                    datasets: [
                      ` +
                  graph_output +
                  `
                    ],
                  },
                  options: {
                    legend: { display: true, position: 'right'},
                  },
                });`;
                // alert(graph_code);
                string_simulate_input = question_input;
                string_graph = graph_code;
                string_ranked_context = stringify_data_phrases;
                eval(graph_code);
                document.getElementById("loading-upload").style.display =
                  "none";
                document.getElementById("loading-graph").style.display = "none";
                document.getElementById("simulate-btn").style.display =
                  "inline";
                document.getElementById("upload-file").style.display = "inline";
                document.getElementById("compilation-time").innerHTML =
                  "Compilation-Time: " + Math.round(data[3], 2) + " seconds";
              }
            );
          }
        );

        return;
      }
    }
  );
}

function open_file(input1, input2) {
  window.open(current_hosting_url + "user_files/" + input1 + "/" + input2);
}

function delete_file(input1, input2, input3) {
  $.post(
    current_hosting_url + "php/js-request/delete_teacher_file.php",
    { user_folder: input1, user_file: input2 },
    function (data) {
      alert(data);

      index = arr_teacher_filenames.indexOf(arr_teacher_filenames[input3]);
      if (index > -1) {
        // only splice array when item is found
        arr_teacher_filenames.splice(index, 1); // 2nd parameter means remove one item only
      }

      document.getElementsByClassName("delete-source")[input3].style.display =
        "none";
      document.getElementsByClassName("highlightable-sources")[
        input3
      ].style.display = "none";
      $.get(current_hosting_url + "php/nlp_all_steps.php", function () {
        load_references();
      });
    }
  );
}

function upload_file_function() {
  document.getElementById("overlay").style.display = "block";
  document.getElementById("loading-upload").style.display = "inline";
  document.getElementById("loading-graph").style.display = "inline";
  document.getElementById("simulate-btn").style.display = "none";
  document.getElementById("upload-file").style.display = "none";
  variable = document.getElementById("fileToUpload").value;
  variable = variable.replace("C:\\fakepath\\", "");
  // alert(variable);
  arr_filetypes = [".docx", ".doc", ".pdf", ".txt"];
  outcome = 0;
  for (i = 0; i < arr_filetypes.length; i++) {
    if (
      document.getElementById("fileToUpload").value.includes(arr_filetypes[i])
    ) {
      outcome++;
    }
  }
  if (outcome > 0) {
    // alert("upload");

    let formData = new FormData();
    formData.append("file", document.getElementById("fileToUpload").files[0]);
    fetch(current_hosting_url + "php/js-request/upload_teacher_file.php", {
      method: "POST",
      body: formData,
    }).then(function () {
      document.getElementById("overlay").style.display = "block";
      document.getElementById("show-loading").style.display = "block";
      $.get(current_hosting_url + "php/nlp_all_steps.php", function () {
        load_references();
        alert("you uploaded a file.");
        location.reload();
      });
      show_loading_prog();
    });
  } else {
    alert("Sorry, this website does not support that kind of file");
  }
  document.getElementById("loading-upload").style.display = "none";
  document.getElementById("loading-graph").style.display = "none";
  document.getElementById("simulate-btn").style.display = "inline";
  document.getElementById("upload-file").style.display = "inline";
}

function manualizing_grade(selected_answer) {
  extracted_score = "";
  max_score = "";
  // alert(arr_stud_grades[selected_answer]);
  for (
    i = 0;
    arr_stud_grades[selected_answer][i] != "/" &&
    i < arr_stud_grades[selected_answer].length;
    i++
  ) {
    extracted_score += arr_stud_grades[selected_answer][i];
  }
  for (
    i = arr_stud_grades[selected_answer].indexOf("/") + 1;
    i < arr_stud_grades[selected_answer].length;
    i++
  ) {
    max_score += arr_stud_grades[selected_answer][i];
  }
  extracted_score = parseFloat(extracted_score);
  max_score = parseFloat(max_score);
  document.getElementById("insert-title").innerText = "Update Student Grade";
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("green-prompt-content").innerHTML =
    document.getElementById("stud_answer_" + selected_answer).innerHTML +
    `<br><br>Update Current Grade: <input id='new-updated-grade' type='number' value='` +
    extracted_score +
    `' min='0' max='` +
    max_score +
    `'><button id='manual-update-grade' onclick='new_grade_update(` +
    selected_answer +
    `)'>UPDATE</button><br><br><button onclick='cancel_btn_function()'>CANCEL</button>`;
}

function new_grade_update(answer_id) {
  hold_data = arr_raw_grades[answer_id].split("<&,&>");
  extracted_score = document.getElementById("new-updated-grade").value;
  hold_output =
    (extracted_score / max_score) * 100 +
    "<&,&>0<&,&>" +
    extracted_score / max_score;
  // alert(hold_output);
  $.post(
    current_hosting_url + "php/js-request/update_student_grade.php",
    { answer_id: arr_stud_answer_address[answer_id], grade: hold_output },
    function (data) {
      alert(data);
      click_tr_question(recent_selection);
      document.getElementById("green-prompt").style.display = "none";
      document.getElementById("overlay").style.display = "none";
    }
  );
}
