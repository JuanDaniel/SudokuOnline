/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(".completar").click(function(){
  var newElement = document.createElement("input");
  newElement.setAttribute("class", "write");
  newElement.setAttribute("type", "text");
  newElement.setAttribute("maxlength", "1");

  var oldElement = $(".tablero table tr td").html();
  
  $(".write").remove();
  $(this).html(newElement);
  $(".write").focus();
});

/*$(".write").bind("keyup", function(){
  alert($(this).html());
});*/

$(".write").live("blur", function(){
  var value = $(".write").attr("value");
  var parent = $(this).parent();
  $(".write").remove(); 
  if (!isNaN(value))
    $(parent).html(value);
  else 
    alert('Debe ingresar solamente dígitos');
});

$("#calificar").click(function(){
  var solucion = new Array(9);
  var tds = $('.cuadriculas').find('td');
  for(var i=0, p=0; i<9; i++){
      solucion[i] = new Array(9);
      for(var j=0; j<9; j++){
        solucion[i][j] = $(tds[p++]).html();
      }
  }
  $.ajax({
    dataType: 'json',
    type: 'POST',
    data: ({sudoku: solucion}),
    url: Url,
    success:function(data){
      alert(data['msg']);
    }
  });
});






