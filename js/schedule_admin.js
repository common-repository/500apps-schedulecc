/** to get cookie value */
function schedule_getcookie(name) {
  var cookie_name = name + "=";
  var cookies = document.cookie.split(";");
  for (var i = 0; i < cookies.length; i++) {
    var extracted_cookie = cookies[i];
    while (extracted_cookie.charAt(0) == " ")
      extracted_cookie = extracted_cookie.substring(1, extracted_cookie.length);
    if (extracted_cookie.indexOf(cookie_name) == 0)
      return extracted_cookie.substring(
        cookie_name.length,
        extracted_cookie.length
      );
  }
  return null;
}

/**
 * Get JSON for events
 */
function schedule_get_events() {
  var schedule_names;
  var token = schedule_getcookie("token");
  var region = schedule_getcookie("region");
  var domain_id = schedule_getcookie("tenant_id");
  var user_id = schedule_getcookie("user_id");
  let select =
    '<select id="id-schedule-values" onchange="return schedule_set_shortcode(this.value)">' +
    '<option data-project="0" value="0">' +
    "-" +
    "</option>";
  jQuery.ajax({
    beforeSend: function (request) {
      request.setRequestHeader("token", token);
    },
    dataType: "json",
    url:
      "https://schedule." + region + ".500apps.com/v2/event_types?limit=50&offset=0&where=is_active=1&s=created_date%20desc",
    //url: 'https://api.'+ region +'.500apps.com/schedulely/v1/"'+domain_id+'"/"'+user_id+'"?limit=50',
    success: function (data1) {
      console.log(data1);
      schedule_names = data1;
      for (key in data1) {
        let data = schedule_names[key];
        select =
          select + '<option value="' + data.id + '">' + data.title + "</option>";
      }
      select = select + "</select>";
      jQuery("#id-schedule-selector").html(select);
    },
  });
}
/** To create shortcode for events **/
function schedule_set_shortcode(obj) {
  let editor_id = jQuery("#id-schedule-values").val();
  var project_id = jQuery("#id-schedule-values")
    .find(":selected")
    .attr("data-project");
  if (editor_id > 0) {
    let new_text = jQuery("#post-content-0").text();
    var schedule_text = "Event";
    new_text =
      new_text + "\n[" + schedule_text + " " + 'id="' + editor_id + '"]';
    jQuery("#post-content-0").val(new_text);
    jQuery(".block-editor-block-list__layout>p")[0].append(new_text);
    var theMessage = jQuery(".wp-editor-area").val();
    var totalShortcode = new_text + theMessage;
    jQuery(".wp-editor-area").val(totalShortcode);
  }
  return false;
}

/**
 * for agents
 */

/**
 * Get JSON data of agetns for select option in editor
 */
function schedule_get_agents() {
  var schedule_names;
  var token = schedule_getcookie("token");
  var region = schedule_getcookie("region");
  var tenant_id = schedule_getcookie("tenant_id");
  let select =
    '<select id="id-schedule-agent-values" onchange="return schedule_set_agent_shortcode(this.value)">' +
    '<option data-project="0" value="0">' + "-" + "</option>";
  var token = schedule_getcookie("token");
  jQuery.ajax({
    beforeSend: function (request) {
      request.setRequestHeader("token", token);
    },
    dataType: "json",
    url:
      "https://api." + region + ".500apps.com/schedulely/v1/" + tenant_id + "?limit=50",
    success: function (data1) {
      schedule_names = data1;
      for (key in data1) {
        let data = schedule_names[key];
        select = select + '<option value="' + data.domain_user_id + '">' + data.user_name + "</option>";
      }
      select = select + "</select>";
      jQuery("#agent-selector").html(select);
    },
  });
}

/** creating shortcode for agents **/
function schedule_set_agent_shortcode(obj) {
  let selected_id = jQuery("#id-schedule-agent-values").val();
  var project_id = jQuery("#id-schedule-agent-values")
    .find(":selected")
    .attr("data-project");
  if (selected_id > 0) {
    let editor_id = jQuery("#post-content-0").text();
    var schedule_text = "Agent";
    editor_id = editor_id + "\n[" + schedule_text + " " + 'id="' + selected_id + '"]';
    jQuery("#post-content-0").val(editor_id);
    jQuery(".block-editor-block-list__layout>p")[0].append(editor_id);
    var theMessage = jQuery(".wp-editor-area").val();
    var totalShortcode = editor_id + theMessage;
    jQuery(".wp-editor-area").val(totalShortcode);
  }
  return false;
}

/**
 * for workspace
 */

/**
 * Get JSON data of workspace
 */
function schedule_get_workspace() {
  var schedule_names;
  var token = schedule_getcookie("token");
  var region = schedule_getcookie("region");
  var tenant_id = schedule_getcookie("tenant_id");  
      var embed_button =
        '<input type="button" value="All Events" onclick="schedule_set_event_embed_shortcode()">';
      jQuery("#embed-selector").html(embed_button);
}

/** creating shortcode to show workspace **/
function schedule_set_event_embed_shortcode(obj) {
  let editor_id = jQuery("#post-content-0").text();
  var schedule_text = "Events";
  editor_id = editor_id + "\n[" + schedule_text + "]";
  jQuery("#post-content-0").val(editor_id);
  jQuery(".block-editor-block-list__layout>p")[0].append(editor_id);
  var theMessage = jQuery(".wp-editor-area").val();
  var totalShortcode = editor_id + theMessage;
  jQuery(".wp-editor-area").val(totalShortcode);
  //}
  return false;
}

jQuery(document).ready(function ($) {
  schedule_get_events();
  schedule_get_agents();
  schedule_get_workspace();
  schedule_event_preview();
  schedule_agent_preview();
  schedule_embed_events();
  /** to show infinity app **/
  var schedule_dataText = jQuery("#schedule_data").text();
  jQuery("#schedule_data").html("");
  var decodedData = window.atob(schedule_dataText);
  jQuery("#schedule_data").append(decodedData);
  jQuery("#schedule_data").attr("style", "display:block");
  var schedule_id = 0;
  jQuery("a").each(function (idx) {
    if (
      jQuery(this).attr("href") == "admin.php?page=500apps-schedulecc/classes/class.scheduleapp_adminschedule.php"
    ) {
      if (schedule_id == 1) {
        jQuery(this).css("display", "none");
      }
      schedule_id++;
    }
  });
  /** to show other apps  **/
  var id1 = 0;
  jQuery("a").each(function (idx) {
    if (
      jQuery(this).attr("href") == "admin.php?page=Other%20apps%20by%20500apps"
    ) {
      jQuery(this).addClass("show_popup");
      jQuery(this).attr("href", "#");
      jQuery(this).attr("id", "show_popup");
      id1++;
    }
  });
  /** to close other apps  **/
  var modal = document.getElementById("scheduleModal");
  var btn = document.getElementById("show_popup");
  var span = document.getElementsByClassName("close")[0];
  btn.onclick = function () {
    modal.style.display = "block";
  };
  span.onclick = function () {
    modal.style.display = "none";
  };
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  };
});

/**
 *
 * append agent events on agents preview page
 *
 */
function schedule_agent_preview() {
  //load_event
  if (jQuery("#load_event").length > 0) {
    var domain_id = document.getElementById("domain_id").value;
    var domain_user_id = document.getElementById("domain_user_id").value;
    var region = document.getElementById("region").value;
    const container = document.getElementById("load_event");
    container.innerHTML = "";
    const iframe = document.createElement("iframe");
    iframe.id = "schedule_iframe_agent";
    iframe.style = "display:block";
    iframe.style = "height:1000px";
    iframe.style = "width:100%";
    iframe.style = "max-width: 1500px !important";
    iframe.height = "1000px";
    iframe.width = "100%";
    iframe.addEventListener("load", function () {});
    iframe.src =
      "https://schedule-" + region + "-" + domain_id + "-" + domain_user_id + ".public.500apps.org/schedule?type=widget";
    container.append(iframe);
  }
}

/**
 *
 * append event on single event preview page
 *
 */
function schedule_event_preview() {
  console.log("single event");
  if (jQuery("#load_single_event").length > 0) {
    var event_id = document.getElementById("event_id").value;
    var domain_id = document.getElementById("domain_id").value;
    var domain_user_id = document.getElementById("domain_user_id").value;
    var region = document.getElementById("region").value;
    const container = document.getElementById("load_single_event");
    container.innerHTML = "";
    const iframe = document.createElement("iframe");
    iframe.id = "schedule_iframe_event";
    iframe.style = "display:block";
    iframe.style = "height:1000px";
    iframe.style = "width:200%";
    iframe.style = "max-width: 1500px !important";
    iframe.height = "1000px";
    iframe.width = "100%";
    iframe.addEventListener("load", function () {});
    iframe.src =
      "https://schedule-" + region + "-" +domain_id +"-" +domain_user_id + "-" + event_id + ".public-" + region + ".500apps.org/schedule?type=widget";
    container.append(iframe);
  }
}

/**
 *
 * append agents with events to preview page
 *
 */
function schedule_embed_events() {
  if (jQuery("#embed_events").length > 0) {
    var domain_id = document.getElementById("domain_id").value;
    var region = document.getElementById("region").value;
    const container = document.getElementById("embed_events");
    container.innerHTML = "";
    const iframe = document.createElement("iframe");
    iframe.id = "schedule_iframe_workspace";
    iframe.style = "display:block";
    iframe.style = "height:1000px";
    iframe.style = "width:100%";
    iframe.style = "max-width: 1500px !important";
    iframe.height = "1000px";
    iframe.width = "100%";
    iframe.addEventListener("load", function () {});
    iframe.src = "https://schedule-" + region + "-" + domain_id + ".public.500apps.org/schedule?type=widget";
    container.append(iframe);
  }
}