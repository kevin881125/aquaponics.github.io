
$(window).scroll(function() {
    let st = this.scrollY; 
    let a=0;
    if (st > 2000){
     /* window.alert(st);*/
     a=a+1;
    }
    else if(st >1650){
        $("#box22id").addClass("box2ss");
        $("#box13id").addClass("box13");
       /* window.alert(st);*/
       a=a+1;
     }
    else if(st >1100){
      $("#entityboxid").addClass("entitybox");
      $("#entitybox2id").addClass("entitybox2");
     /* window.alert(st);*/
     a=a+1;
   }
    else if(st >1000){
      $("#entityboxid3").addClass("entitybox3");
      $("#entityboxid4").addClass("entitybox4");
     /* window.alert(st);*/
     a=a+1;
   }
   else if(st >900){
      /*window.alert(st);*/
      return false; 
      a=a+1;
   }
    else if(st >0){
       if(a<1){
      $("#title1").addClass("title");
      $("#title1").html('<div class="title-effects"></div><h1>什麼是魚菜共生?</h1>');
      /*window.alert(st);*/
      a=a+1;
      }
   }
});