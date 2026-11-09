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


function resets(){
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
function finds(){
 var f =document.getElementById("search").value ; 
 $('td:not(:visible)').show();
var tags=$( "td:not([name*="+f.toUpperCase()+"])" );
tags.hide();

}

('#modalButton').click(function (){
    $('#modal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
        
});
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