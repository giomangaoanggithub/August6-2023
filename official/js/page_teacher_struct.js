// this javascript program runs in the background of pages/page_teacher.php. It fetches all the data requested from this account.
// The requested data are the contents of the account initially whenever they login.

// public variables

var arr_questions = [];
var arr_questions_id = [];
var arr_collected_links = [];
var arr_time_of_issue = [];
var arr_grades = [];
var arr_students = [];
var arr_assigned_questions = [];
var arr_connections = [];
var arr_connections_id = [];
var arr_teacher_filenames = [];
var confirming_disconnection = "";
var chosen_connection = "";
var current_user = "";
var string_simulate_input = "";
var string_graph = "";
var string_ranked_context = ``;
var arr_stud_answer = [];
var arr_stud_grades = [];
var arr_raw_grades = [];
var extracted_score = "";
var max_score = "";
var recent_selection = 0;
var eta = "";

function load_teacher_data() {
  $.get(current_hosting_url + "php/js-request/count_eta.php", function (data) {
    eta = data;
    // alert(eta);
  });
  $.get(
    current_hosting_url + "php/js-request/page_teacher_start_data.php",
    function (data) {
      data = JSON.parse(data);

      if (data.length > 0) {
        document.getElementById("if-empty-table-question").style.display =
          "none";
        for (i = 0; i < data.length; i++) {
          arr_questions.push(data[i]["question"]);
          arr_questions_id.push(data[i]["question_id"]);
          arr_collected_links.push(data[i]["collected_links"]);
          arr_time_of_issue.push(data[i]["time_of_issue"]);
          arr_grades.push(data[i]["HPS"]);
          $("#teacher-left-side-table-tr").append(
            "<tr class='tr-questions-action' id='trquestion_" +
              i +
              "' onclick='click_tr_question(" +
              data[i]["question_id"] +
              ")'><td>" +
              data[i]["question"] +
              "</td><td>" +
              data[i]["HPS"] +
              "</td><td>" +
              data[i]["due_date"] +
              "</td><td><span class='material-icons' onclick='show_edit_question_prompt(" +
              data[i]["question_id"] +
              ")'>edit</span><span class='material-icons'>delete</span></td></tr>"
          );
        }
      }
    }
  );
}

function load_students() {
  $.get(
    current_hosting_url + "php/js-request/page_teacher_start_students.php",
    function (data) {
      data = JSON.parse(data);
      if (data.length > 0) {
        for (i = 0; i < data.length; i++) {
          arr_students.push(data[i]["username"]);
          arr_connections.push(data[i]["username"]);
          arr_connections_id.push(data[i]["connection_id"]);
          document.getElementById("no-show-students").style.display = "none";
          $("#teacher-student-left-side-table-tr").append(
            "<tr><td>" +
              data[i]["username"] +
              "</td><td>" +
              data[i]["email"] +
              "</td><td><span class='material-icons' onclick='disconnect_function(" +
              data[i]["connection_id"] +
              ")'>cancel</span></td></tr>"
          );
        }
      }
    }
  );
}

function load_references() {
  $.get(
    current_hosting_url + "php/js-request/page_teacher_start_reference.php",
    function (data) {
      data = JSON.parse(data);
      arr_teacher_filenames = [];
      for (i = 2; i < data.length; i++) {
        arr_teacher_filenames.push(data[i]);
      }
      // alert(arr_teacher_filenames);
    }
  );
}

function start_page() {
  $.get(
    current_hosting_url + "php/js-request/current_email_session.php",
    function (data) {
      current_user = data;
    }
  );
  $.get(
    current_hosting_url + "php/js-request/page_teacher_start.php",
    function (data) {
      // alert(data);
      data = JSON.parse(data);
      document.getElementById("inserted-name").innerHTML = data[0]["username"];
      document.getElementById("account-course-code").innerHTML =
        "Course Code: " + data[0]["course_code"];

      load_teacher_data();
      load_students();
      load_references();
    }
  );
}

start_page();
