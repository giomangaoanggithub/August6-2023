// this javascript program runs all the necessary operations needed on live during the use of the page_student.php
// operations like button clicks to request certain data or even a mouse hover to make it responsive

$("#logout-btn").click(function () {
  $.get(
    current_hosting_url + "php/js-request/current_session_destroy.php",
    function () {
      window.location = current_hosting_url + "pages/page_register_login.php";
    }
  );
});

$("#edit-username").click(function () {
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("insert-title").innerHTML = "Changing Username";
  document.getElementById("green-prompt-content").innerHTML =
    "<h2>Username:</h2><input id='new-username-input' value='" +
    document.getElementById("inserted-name").innerHTML +
    "'><br><br><button onclick='cancel_btn_function()'>CANCEL</button><button onclick='apply_change_username()'>APPLY</button>";
});

function cancel_btn_function() {
  document.getElementById("overlay").style.display = "none";
  document.getElementById("green-prompt").style.display = "none";
  document.getElementById("green-prompt").style.height = "100%";
  document.getElementById("answering-area").style.display = "none";
}

function apply_change_username() {
  if (
    document.getElementById("inserted-name").innerHTML ==
    document.getElementById("new-username-input").value
  ) {
    alert("You still have the same Username");
  } else {
    $.post(
      current_hosting_url + "php/js-request/change_username.php",
      { username: document.getElementById("new-username-input").value },
      function (data) {
        alert(data);
        document.getElementById("inserted-name").innerHTML =
          document.getElementById("new-username-input").value;
        cancel_btn_function();
      }
    );
  }
}

function answer_question(question) {
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("insert-title").innerHTML = "Assessment Task";
  document.getElementById("green-prompt-content").innerHTML =
    arr_questions[question] + "<br>• You must write atleast 10 words.";
  document.getElementById("green-prompt-content").style.height = "10%";
  document.getElementById("answering-area").style.display = "block";
  answering_currently = arr_questions_id[question];
  // alert("arr_questions_id: " + arr_questions_id);
  // alert("arr_questions_id: " + answering_currently);
}

function grammarly_stopper() {
  editor = document.querySelector("grammarly-editor-plugin");
  editor.disconnect();
}

function check_num_words() {
  if (parseInt(document.getElementById("count-words").innerHTML) >= 10) {
    grading();
  } else {
    alert("Sorry you must have enough words to submit your answer.");
  }
}
function grading() {
  Grammarly.init().then((grammarly) => {
    editor = document.querySelector("textarea");
    grammarly.addPlugin(editor);
    editor.config = {
      underlines: "on",
    };
    editor.config = {
      suggestionCards: "on",
    };
  });
  // alert("grading()");
  document.getElementById("overlay").style.zIndex = "3";
  document.getElementById("show-loading").style.zIndex = "3";
  document.getElementById("show-loading").style.display = "block";
  // Grading essay answer via grammar, spelling and other text composition

  setTimeout(grammarly_function, 7000);
}

function grammarly_function() {
  var grade_grammar = "";
  // alert(
  //   "for start = " +
  //     document.querySelector("#grammarlyapi").shadowRoot.innerHTML[
  //       document
  //         .querySelector("#grammarlyapi")
  //         .shadowRoot.innerHTML.indexOf('data-grammarly-count="') +
  //         'data-grammarly-count="'.length
  //     ]
  // );
  for (
    i =
      document
        .querySelector("#grammarlyapi")
        .shadowRoot.innerHTML.indexOf('data-grammarly-count="') +
      'data-grammarly-count="'.length;
    document.querySelector("#grammarlyapi").shadowRoot.innerHTML[i] != '"';
    i++
  ) {
    grade_grammar +=
      document.querySelector("#grammarlyapi").shadowRoot.innerHTML[i];
  }
  text = document.getElementById("textarea-answer").value;
  // alert("grammarly_function() grade_grammar output = " + grade_grammar);
  essaycontent_function(text, answering_currently, grade_grammar);
}

function essaycontent_function(answer, question_id, grade_grammar) {
  // alert(
  //   "grade_gramar: " +
  //     grade_grammar +
  //     "\nquestion_id: " +
  //     question_id +
  //     "\nanswer: " +
  //     answer
  // );
  $.post(
    current_hosting_url + "php/nlpcheck.php",
    { answer: answer, question_id: question_id, grade_grammar: grade_grammar },
    function (data) {
      alert(data);
      document.getElementById("overlay").style.zIndex = "2";
      document.getElementById("show-loading").style.zIndex = "2";
      document.getElementById("show-loading").style.display = "none";
      window.location = current_hosting_url + "pages/page_student.php";
    }
  );
}

$("#enter-course-code").click(function () {
  if (document.getElementById("course-code-input").value.length == 0) {
    alert("Please input the course code...");
  } else {
    $.post(
      current_hosting_url +
        "php/js-request/page_student_fetch_existing_coursecode.php",
      { course_code: document.getElementById("course-code-input").value },
      function (data) {
        // alert(data);
        data = JSON.parse(data);
        if (data.length == 1) {
          $.post(
            current_hosting_url +
              "php/js-request/page_student_create_connection.php",
            { teacher_id: data[0]["user_id"] },
            function (data) {
              alert(data);
              window.location = current_hosting_url + "pages/page_student.php";
            }
          );
        } else {
          alert("You entered non-existent course code...");
        }
      }
    );
  }
});

function count_words() {
  arr_text = document
    .getElementById("textarea-answer")
    .value.replaceAll("  ", " ")
    .split(" ")
    .filter(function (el) {
      return el != "";
    });
  word_count = 0;
  if (arr_text[arr_text.length - 1] == "") {
    document.getElementById("count-words").innerHTML = arr_text.length - 1;
    word_count = arr_text.length - 1;
  } else {
    document.getElementById("count-words").innerHTML = arr_text.length;
    word_count = arr_text.length;
  }
  if (word_count > 50) {
    alert("Sorry you cannot add more words.");
    output = "";
    while (word_count > 50) {
      num_text = document
        .getElementById("textarea-answer")
        .value.replaceAll("  ", " ")
        .split(" ");
      output = num_text[0];
      for (i = 1; i < 50; i++) {
        output += " " + num_text[i];
      }
      word_count = output.split(" ").length;
      document.getElementById("count-words").style.color = "white";
      document.getElementById("count-words").value = word_count;
    }
    document.getElementById("textarea-answer").value = output;
    document.getElementById("count-words").innerHTML = word_count;
  }
  if (word_count < 10) {
    document.getElementById("count-words").style.color = "red";
  } else {
    document.getElementById("count-words").style.color = "white";
  }
}

function disconnect_function(input) {
  confirming_disconnection = input;
  teacher = arr_connections[arr_connections_id.indexOf(input.toString())];
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("insert-title").innerHTML = "Disconnect?";
  document.getElementById("green-prompt-content").style.height = "5vh";
  document.getElementById("answering-area").style.display = "none";
  document.getElementById("green-prompt-content").innerHTML =
    "Do you want to disconnect Teacher <strong>" +
    teacher +
    "</strong>?<br>You can reconnect via course code, if it is a mistake later on.<br><button onclick='cancel_btn_function()'>CANCEL</button><button onclick='confirm_disconnection()'>YES</button>";
}

function confirm_disconnection() {
  $.post(
    current_hosting_url + "php/js-request/user_disconnect.php",
    { connection_id: confirming_disconnection },
    function (data) {
      alert(data);
      window.location = current_hosting_url + "pages/page_student.php";
    }
  );
}

function view_student_answer(input) {
  // alert(arr_answers[input]);
  input = arr_answers_id.indexOf("" + input);
  document.getElementById("overlay").style.display = "block";
  document.getElementById("green-prompt").style.display = "block";
  document.getElementById("green-prompt").style.height = "80vh";
  document.getElementById("insert-title").innerHTML = "Your Answer";
  document.getElementById("green-prompt-content").style.height = "5vh";
  document.getElementById("answering-area").style.display = "none";
  document.getElementById("green-prompt-content").innerHTML =
    arr_answers[input] +
    "<br><br><button onclick='cancel_btn_function()'>BACK</button>";
}
