var str_questions = "";
var str_answers = "";
var str_truths = "";

function initial_files() {
  $.get(
    current_hosting_url + "php/demo/php/mass_demo_files.php",
    function (data) {
      document.getElementById("user-files-content").innerText = data;
    }
  );
}
initial_files();

function initial_diverse_colors() {
  document.getElementsByClassName("diverse-context")[0].style.background =
    "rgb(128,0,0)";
  document.getElementsByClassName("diverse-context")[1].style.background =
    "rgb(255,128,0)";
  document.getElementsByClassName("diverse-context")[2].style.background =
    "rgb(0,128,0)";
  document.getElementsByClassName("diverse-context")[3].style.background =
    "rgb(128,255,0)";
  document.getElementsByClassName("diverse-context")[4].style.background =
    "rgb(0,255,128)";
  document.getElementsByClassName("diverse-context")[5].style.background =
    "rgb(0,128,255)";
  document.getElementsByClassName("diverse-context")[6].style.background =
    "rgb(128,0,255)";
  document.getElementsByClassName("diverse-context")[0].style.color = "white";
  document.getElementsByClassName("diverse-context")[2].style.color = "white";
  document.getElementsByClassName("diverse-context")[6].style.color = "white";
  document.getElementsByClassName("diverse-context")[0].innerHTML =
    "physics dealing transmission light images glass plastic optics";
  document.getElementsByClassName("diverse-context")[1].innerHTML =
    "archimedes principle law stating object";
  document.getElementsByClassName("diverse-context")[2].innerHTML =
    "passing poles celestial sphere imaginary plane pass";
  document.getElementsByClassName("diverse-context")[3].innerHTML =
    "completer cycle watts unit power rate energy";
  document.getElementsByClassName("diverse-context")[4].innerHTML =
    "stretch compress sample deforms stains proportion returns original";
  document.getElementsByClassName("diverse-context")[5].innerHTML =
    "shaft engine maintains smooth rotation shaft high inertia forensic science";
  document.getElementsByClassName("diverse-context")[6].innerHTML =
    "satellite kind spacecraft satellite dish kind aerial seismograph instrument";
  //   initial_diverse_contexts();
}
initial_diverse_colors();

function initial_diverse_contexts() {
  $.get(
    current_hosting_url + "php/demo/php/all_diverse_contexts.php",
    function (data) {
      //   alert(data);
      time = "";
      num_phrases = "";
      phrases = "";
      x = 0;
      while (x < data.indexOf("<&time&>")) {
        time += data[x];
        x++;
      }
      x += "<&time&>".length;
      while (x < data.indexOf("<&num_phrases&>")) {
        num_phrases += data[x];
        x++;
      }
      x += "<&num_phrases&>".length;
      while (x < data.indexOf("<&phrases&>")) {
        phrases += data[x];
        x++;
      }
      phrases = phrases.split("<,>");
      for (
        i = 0;
        i < document.getElementsByClassName("diverse-context").length;
        i++
      ) {
        document.getElementsByClassName("diverse-context")[i].innerHTML =
          phrases[i];
      }
    }
  );
}

function load_qa_truths() {
  $.get(current_hosting_url + "php/demo/php/DATA.php", function (data) {
    x = 0;
    while (x < data.indexOf("<&questions&>")) {
      str_questions += data[x];
      x++;
    }
    x += "<&questions&>".length;
    while (x < data.indexOf("<&anwers&>")) {
      str_answers += data[x];
      x++;
    }
    x += "<&anwers&>".length;
    while (x < data.indexOf("<&truths&>")) {
      str_truths += data[x];
      x++;
    }
    // alert(str_questions);
    // alert(str_answers);
    // alert(str_truths);
    display_questions();
  });
}
load_qa_truths();

function display_questions() {
  arr_questions = str_questions.split("<,>");
  str_html = ``;
  x = 0;
  for (i = 0; i < arr_questions.length; i++) {
    str_html +=
      `<div><div class="question-placement" onclick="display_curr_question_content(` +
      i +
      `)"><strong>` +
      arr_questions[i] +
      `</strong></div><div class="data-tab-selection row"><div class="question-answers col-6"><button id="question-answers-` +
      x +
      `" onmouseover="cursor_btn_behavior(this.id)" onclick="cursor_tab_btn_onclick(this.id)">Answers</button></div><div class="question-model col-6"><button id="question-model-` +
      x +
      `" onmouseover="cursor_btn_behavior(this.id)" onclick="cursor_tab_btn_onclick(this.id)" style="background-color: sienna; color: white;">Model</button></div></div><div class="answers-set"></div><div class="model-set">MODEL HERE</div></div>`;
    x++;
  }
  document.getElementById("list-of-questions").innerHTML = str_html;
  display_answers();
}

function display_answers() {
  arr_answers = str_answers.split("<,>");
  arr_truths = str_truths.split("<,>");
  for (i = 0; i < arr_answers.length; i++) {
    answers_set = arr_answers[i].split("<,,>");
    truths_set = arr_truths[i].split("<,,>");
    str_html = `<table class="table-answers">`;
    for (h = 0; h < answers_set.length; h++) {
      truth_color = "";
      if (truths_set[h] == "TN") {
        truth_color = `color: rgb(255, 128, 0); background-color: black;`;
      }
      str_html +=
        `<tr><td style="width: 10%; ` +
        truth_color +
        `">` +
        `Answer ` +
        (h + 1) +
        `: ` +
        `</td><td style="width: 80%; ` +
        truth_color +
        ` text-align: justify;">` +
        answers_set[h] +
        `</td><td style="width: 10%;">` +
        `<span class="material-icons">pending</span>` +
        `</td></tr>`;
    }
    str_html += `</table>`;
    document.getElementsByClassName("answers-set")[i].innerHTML = str_html;
  }
}

function display_curr_question_content(input) {
  if (
    document.getElementsByClassName("table-answers")[input].style.display ==
    "block"
  ) {
    document.getElementsByClassName("data-tab-selection")[
      input
    ].style.visibility = "hidden";
    document.getElementsByClassName("table-answers")[input].style.display =
      "none";
    document.getElementsByClassName("model-set")[input].style.display = "none";
  } else {
    document.getElementsByClassName("data-tab-selection")[
      input
    ].style.visibility = "visible";
    document.getElementsByClassName("table-answers")[input].style.display =
      "block";
    document.getElementsByClassName("model-set")[input].style.display = "block";
  }
}

function confusion_matrix_properties() {
  document.getElementsByClassName("confusion-tile")[0].style.borderTop = "none";
  document.getElementsByClassName("confusion-tile")[0].style.borderLeft =
    "none";

  document.getElementsByClassName("confusion-tile")[1].style.borderTop = "none";
  document.getElementsByClassName("confusion-tile")[1].style.borderRight =
    "none";

  document.getElementsByClassName("confusion-tile")[2].style.borderBottom =
    "none";
  document.getElementsByClassName("confusion-tile")[2].style.borderLeft =
    "none";

  document.getElementsByClassName("confusion-tile")[3].style.borderBottom =
    "none";
  document.getElementsByClassName("confusion-tile")[3].style.borderRight =
    "none";
}
confusion_matrix_properties();

function cursor_btn_behavior(input) {
  if (document.getElementById(input).style.backgroundColor != "sienna") {
    document.getElementById(input).style.cursor = "default";
  } else {
    document.getElementById(input).style.cursor = "pointer";
  }
}

function cursor_tab_btn_onclick(input) {
  cleansed_input = "";
  for (i = input.length - 1; input[i] != "-"; i--) {
    cleansed_input = input[i] + cleansed_input;
  }
  if (input.includes("question-model")) {
    document.getElementById(
      "question-answers-" + cleansed_input
    ).style.backgroundColor = "sienna";
    document.getElementById("question-answers-" + cleansed_input).style.color =
      "white";
    document.getElementById(
      "question-model-" + cleansed_input
    ).style.backgroundColor = "transparent";
    document.getElementById("question-model-" + cleansed_input).style.color =
      "black";
    document.getElementsByClassName("answers-set")[
      cleansed_input
    ].style.display = "none";
    document.getElementsByClassName("model-set")[cleansed_input].style.display =
      "block";
  } else {
    document.getElementById(
      "question-model-" + cleansed_input
    ).style.backgroundColor = "sienna";
    document.getElementById("question-model-" + cleansed_input).style.color =
      "white";
    document.getElementById(
      "question-answers-" + cleansed_input
    ).style.backgroundColor = "transparent";
    document.getElementById("question-answers-" + cleansed_input).style.color =
      "black";
    document.getElementsByClassName("answers-set")[
      cleansed_input
    ].style.display = "block";
    document.getElementsByClassName("model-set")[cleansed_input].style.display =
      "none";
  }
}
