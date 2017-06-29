$(document).ready(function() {
  var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/")+1);
  $("#sidenav01 li a").each(function(){
      if($(this).attr("href") == pgurl || $(this).attr("href") == '' )
      $(this).parent().addClass("active");
  })
});
