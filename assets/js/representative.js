function rep_show_main_comp(){
 $("#show_branch_comp_id").prop("checked", false);
 $(".rep_project_name").hide();
}
function rep_show_branch_comp(){
  $("#show_main_comp_id").prop("checked", false);
  $(".rep_project_name").show();
}
