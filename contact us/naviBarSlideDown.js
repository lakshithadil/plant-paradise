window.onscroll = function() {scrollFunction()};
  
  function scrollFunction() {
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
      document.getElementById("navbar").style.top = "0";
    } else {
      document.getElementById("navbar").style.top = "-100px";
    }
  }
  
 

  

function setPanels()
{
  var windowWidth = window.innerWidth;
  if(windowWidth < 768)
  {
    document.getElementById("arrow").src = "images/icons8_arrow_down_200px_1.png";
    document.getElementById("arrow2").src = "images/icons8_arrow_down_200px_1.png";
    document.getElementById("arrow").style.width="20%";
    document.getElementById("arrow2").style.width="20%";
    document.getElementById("arrow").style.marginBottom="7%";
    document.getElementById("arrow2").style.marginBottom="7%";
  }
  else
  {
    document.getElementById("arrow").src = "images/icons8_arrow_200px_1.png";
    document.getElementById("arrow2").src = "images/icons8_arrow_200px_1.png";
    document.getElementById("arrow").style.width="30%";
    document.getElementById("arrow2").style.width="30%";
  }
}