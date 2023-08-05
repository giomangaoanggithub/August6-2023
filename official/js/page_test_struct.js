var previous_user = "";
var load_user_num = 0;
var show_cont_num = 0;
var curr_write_q = 0;
var curr_eta = 0;
var arr_cont_data = [];
var eta = "";
var curr_answering_question = "What is Speed?";
var answering_question_num = 0;

function load_previous() {
  console.log("load_previous()");
  document.getElementById("overlay").style.display = "block";
  $.get(
    current_hosting_url + "php/js-request/current_teacher_account.php",
    function (data) {
      previous_user = data;
      document.getElementById("overlay").innerHTML = "1%";
      setTimeout(load_user, 1000);
    }
  );
}

function load_user() {
  console.log("load_user()");
  $.post(
    current_hosting_url + "php/demo/php/collect_files.php",
    {
      demo_user: "user" + (load_user_num + 1),
    },
    function (data) {
      //   alert(data);
      data = data.split(",");
      display_files = data[0];
      for (i = 1; i < data.length; i++) {
        display_files += ", " + display_files[i];
      }
      document.getElementById(
        "user" + (load_user_num + 1) + "-files"
      ).textContent = display_files;
      //   alert("load_user() | " + load_user_num);
      load_user_num++;
      if (load_user_num < 2) {
        document.getElementById("overlay").innerHTML = load_user_num * 20 + "%";
        load_user();
      }
      if (load_user_num == 2) {
        // alert("show_context_results()");
        setTimeout(overlay100, 2000);
        setTimeout(remove_overlay, 3000);
      }
    }
  );
}

function overlay100() {
  document.getElementById("overlay").innerHTML = "100%";
}
function remove_overlay() {
  document.getElementById("overlay").style.display = "none";
  document.getElementById("overlay").innerHTML = "";
}

function show_eta() {
  curr_answering_question = document.getElementById("input-question").value;
  console.log(curr_answering_question);
  document.getElementById("overlay").style.display = "block";
  document.getElementById("show-loading").style.display = "block";
  arr_cont_data = [];
  $.post(
    current_hosting_url + "php/demo/php/demo_eta.php",
    { eta: "user" + (curr_eta + 1) },
    function (data) {
      eta = data;
      document.getElementById("overlay").innerHTML = "";
      document.getElementById("overlay").style.display = "block";
      show_context_results();
    }
  );
}

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

function show_context_results() {
  console.log("show_context_results()");
  $.post(
    current_hosting_url + "php/demo_create_question.php",
    {
      demo_user: "user" + (curr_write_q + 1),
      demo_question: document.getElementById("input-question").value,
    },
    function (data) {
      //   alert(data);

      if (curr_write_q < 2) {
        curr_write_q++;
        console.log(data);
        arr_cont_data.push(data);
        show_context_results();
      } else {
        curr_write_q = 0;
        context_user1 = arr_cont_data[0];
        context_user2 = arr_cont_data[1];
        load_intial_user_context();
        document.getElementById("overlay").style.display = "none";
        document.getElementById("show-loading").style.display = "none";
        // alert(arr_cont_data.length + " | " + arr_cont_data);
      }
    }
  );
  if (curr_write_q == 0) {
    show_loading_prog();
  }
}

function load_intial_user_context() {
  document.getElementById("label-curr-question").innerHTML =
    curr_answering_question;

  arr_context1 = "";
  string_context1 = "";
  for (
    i = "<&contexts&>".length + 1;
    i < context_user1.indexOf("<&tfidf&>");
    i++
  ) {
    arr_context1 += context_user1[i];
  }
  // alert(arr_context1);
  if (arr_context1 != "" && arr_context1 != " ") {
    arr_context1 = arr_context1.split("<,>");
    document.getElementById("num-of-contexts1").innerHTML =
      "<strong>User1 Contexts: </strong>" + arr_context1.length;
    for (i = 0; i < arr_context1.length; i++) {
      string_context1 +=
        "Context_" + (1 + i) + " : " + arr_context1[i] + "<br>";
    }
    document.getElementById("user-context1").innerHTML = string_context1;
  } else {
    document.getElementById("num-of-contexts1").innerHTML =
      "<strong>User1 Contexts: </strong>0";
    document.getElementById("user-context1").innerHTML = "";
  }

  arr_context2 = "";
  string_context2 = "";
  for (
    i = "<&contexts&>".length + 1;
    i < context_user2.indexOf("<&tfidf&>");
    i++
  ) {
    arr_context2 += context_user2[i];
  }
  // alert(arr_context2);
  if (arr_context2 != "" && arr_context2 != " ") {
    arr_context2 = arr_context2.split("<,>");
    document.getElementById("num-of-contexts2").innerHTML =
      "<strong>User2 Contexts: </strong>" + arr_context2.length;
    for (i = 0; i < arr_context2.length; i++) {
      string_context2 +=
        "Context_" + (1 + i) + " : " + arr_context2[i] + "<br>";
    }
    document.getElementById("user-context2").innerHTML = string_context2;
  } else {
    document.getElementById("num-of-contexts2").innerHTML =
      "<strong>User2 Contexts: </strong>0";
    document.getElementById("user-context2").innerHTML = "";
  }
}

function answering_question() {
  var grade_grammar = "";
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

  $.post(
    current_hosting_url + "php/demo_nlpcheck.php",
    {
      text: text,
      grammar: grade_grammar,
      parameter: arr_context_user1_user2[answering_question_num],
    },
    function (data) {
      // alert(data);
      console.log(data);
      data = data.split("<&,&>");
      // alert(data[2] + " == 1");
      if (data[2] == 1 && data[0] > 45) {
        allwords = parseInt(document.getElementById("count-words").innerText);
        document.getElementById(
          "user-score" + (1 + answering_question_num)
        ).innerHTML =
          "<strong>Content: </strong>" +
          data[0] +
          "%<br><strong>Grammar: </strong>" +
          Math.floor(((allwords - parseInt(data[1])) / allwords) * 100) +
          "%";
      } else {
        document.getElementById(
          "user-score" + (1 + answering_question_num)
        ).innerHTML =
          "<strong>Content: </strong>0%<br><strong>Grammar: </strong>0";
      }
      answering_question_num++;
      if (answering_question_num < 2) {
        answering_question();
      } else {
        answering_question_num = 0;
        document.getElementById("overlay").style.display = "none";
        document.getElementById("show-loading").style.display = "none";
      }
    }
  );
  // essaycontent_function(text, answering_currently, grade_grammar);
}

function check_num_words() {
  document.getElementById("overlay").innerHTML = "";
  document.getElementById("overlay").style.display = "block";
  document.getElementById("show-loading").style.display = "block";
  if (parseInt(document.getElementById("count-words").innerHTML) >= 10) {
    setTimeout(answering_question, 7000);
  } else {
    alert("Sorry you must have enough words to submit your answer.");
    document.getElementById("overlay").style.display = "none";
    document.getElementById("show-loading").style.display = "none";
  }
}

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

load_previous();
load_intial_user_context();
