

function hidebtl() {
    document.getElementById("openlmenu").style.display="none";
    document.getElementById("btnmenu").style.display="none";
    }
    function DoPost(){
       $.post("/autoupdate/web/index.php?r=site%2Flogout"    );  //Your values here..
    
    }
    function openNav() {
      document.getElementById("mySidenav").style.width = "200px";
      document.getElementById("openlmenu").style.display="none";
    document.getElementById("btnmenu").style.display="none";
    }
    
    /* Set the width of the side navigation to 0 */
    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.getElementById("openlmenu").style.display="block";
    document.getElementById("btnmenu").style.display="block";
    }


function resetsstd(){
    var f =document.getElementById("search").value ; 
    document.getElementById("search").value =''; 
    if((f == null) || (f=='')){
      //alert("nulla");
      $('td:not(:visible)').show();
      }
    else {
    var tags=$("td:not([name*="+f.toUpperCase()+"])");
tags.show();};



}

function resets(){
    var f =document.getElementById("search").value ; 
    document.getElementById("search").value =''; 
    if((f == null) || (f=='')){
      //alert("nulla");
      $('tr:not(:visible)').show();
      }
    else {
        $('.table  tr:not(:contains('+f+'))').show();


    }
}
function resetsq(){
  var f =document.getElementById("query").value ; 
  document.getElementById("query").value =''; 
 
};

function finds(){
    var f =document.getElementById("search").value ; 
    $('tr:not(:visible)').show();
    //var f=f.toUpperCase();
    console.log(f);
   //var tags=$('tr:not():not(:contains(f.toUpperCase()))'); ;
   //tags.hide();
   //$(document).find('td:not(:contains('+f+'))').parent().parent().hide();
//var tab=document.getElementById("tabname").value;
   $.extend($.expr[':'], {
    'containsi': function(elem, i, match, array) {
      return (elem.textContent || elem.innerText || '').toLowerCase()
          .indexOf((match[3] || "").toLowerCase()) >= 0;
    }
  });

   $('.table  tr:not(:containsi('+f+'))').hide();

}



function findstd(){
 var f =document.getElementById("search").value ; 
 $('td:not(:visible)').show();
var tags=$( "td:not([name*="+f.toUpperCase()+"])" );
tags.hide();

}
  
function azzera_li()
{

    list = document.getElementById("tblgroup-lista-sortable");
    list2 = document.getElementById("tblgroup-lista2-sortable");
    console.log(list.querySelectorAll('li'));
// As long as <ul> has a child node, remove it
    while (list.hasChildNodes()) {
        tmpi = list.firstChild;
        cln = tmpi.cloneNode(true);
        list2.appendChild(cln);
        list.removeChild(list.firstChild);
    }
document.getElementById("tblgroup-lista2").value=document.getElementById("tblgroup-lista2").value
                   +','+document.getElementById("tblgroup-lista").value;    
document.getElementById("tblgroup-lista").value="";
}
;
function all_in()
{
    //console.log(document.querySelector('.sortable'));
    list = document.getElementById("tblgroup-lista2-sortable");
    list2 = document.getElementById("tblgroup-lista-sortable");

// As long as <ul> has a child node, remove it
    while (list.hasChildNodes()) {
        //console.log(list.firstChild.attributes);
        tmpi = list.firstChild;
        cln = tmpi.cloneNode(true);
        list2.appendChild(cln);
        list.removeChild(list.firstChild);
    }
           document.getElementById("tblgroup-lista").value=document.getElementById("tblgroup-lista").value
                   +','+document.getElementById("tblgroup-lista2").value;
         document.getElementById("tblgroup-lista2").value="";
}
;

function addtabedt(id){
  console.log('ciao2');
  tab=document.getElementById("tabs");
  //seltab=$("#seltabs option:selected").text();
 // console.log(seltab);
 seltab=id;
  var num_tabs = $("div#tabs ul li").length + 1;
  $("div#tabs ul").append(
      "<li ><a href='#Mtabs-tab" + num_tabs + "' data-toggle='tab'>" + seltab + "</a></li>"
  );
   var response = $.ajax({ type: "GET",   
                      url: "index.php?r=Dintable/whitems/update",
                      data:{id: seltab},
                      async: false
                    }).responseText;
                    console.log(response);
  $( ".tab-content" ).append("<div class='tab-pane' id='Mtabs-tab" + num_tabs + "'>"+ response+"</div>");


}
;


function addtab(){
    console.log('ciao');
    tab=document.getElementById("tabs");
    seltab=$("#seltabs option:selected").text();
    console.log(seltab);
    var num_tabs = $("div#tabs ul li").length + 1;
    $("div#tabs ul").append(
        "<li ><a href='#Mtabs-tab" + num_tabs + "' data-toggle='tab'>" + seltab + "</a></li>"
    );
     var response = $.ajax({ type: "GET",   
                        url: "index.php?r=Dintable/dtab/doform",
                        data:{tab: seltab},
                        async: false
                      }).responseText;
    $( ".tab-content" ).append("<div class='tab-pane' id='Mtabs-tab" + num_tabs + "'>"+ response+"</div>");

};

function addtabc(){
  console.log('ciao');
  tab=document.getElementById("tabs");
  //seltab=$("#seltabs option:selected").text();
 // console.log(seltab);
 seltab='mimmi';
  var num_tabs = $("div#tabs ul li").length + 1;
  $("div#tabs ul").append(
      "<li ><a href='#Mtabs-tab" + num_tabs + "' data-toggle='tab'>" + seltab + "</a></li>"
  );
   var response = $.ajax({ type: "GET",   
                      url: "index.php?r=Dintable/whitems/index",
                     // data:{tab: seltab},
                      async: false
                    }).responseText;
                    console.log(response);
  $( ".tab-content" ).append("<div class='tab-pane' id='Mtabs-tab" + num_tabs + "'>"+ response+"</div>");

};

