$(document).ready(function() {
  var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
  $("#main_menu ul li a").each(function(){
      if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
      $(this).parent().addClass("active");
  })
});
