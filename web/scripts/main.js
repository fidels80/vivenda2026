/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


// listen click, open modal and .load content
/*
 * Quando viene cliccato il pulsante "modalButton"
 * mostra il "modal" con il contenuto "modalContent"
 * preso dal rendering di modal.value
 */
$('#modalButton').click(function (){
    $('#modal').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
        
});

$('#modal_mvButton').click(function (){
    $('#modalmv').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
        
});
$('#modal_ptButton').click(function (){
    $('#modalpt').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
        
});
$('#modal_cdButton').click(function (){
    $('#modalcd').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
        
});
$('#modal_idmButton').click(function (){
    $('#modalidm').modal('show')
        .find('#modalContent')
        .load($(this).attr('value'));
        
});