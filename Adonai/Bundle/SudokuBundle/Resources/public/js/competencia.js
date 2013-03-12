$('input[name="cf"]').numeric(false);
$('input[name="tf"]').numeric(false);
$('input[name="cm"]').numeric(false);
$('input[name="tm"]').numeric(false);
$('input[name="cd"]').numeric(false);
$('input[name="td"]').numeric(false);

$('input[name="cf"]').keyup(function(e){
  if(e.which >= 48 && e.which <= 57)
    time();
});
$('input[name="tf"]').keyup(function(e){
  if(e.which >= 48 && e.which <= 57)
    time();
});
$('input[name="cm"]').keyup(function(e){
  if(e.which >= 48 && e.which <= 57)
    time();
});
$('input[name="tm"]').keyup(function(e){
  if(e.which >= 48 && e.which <= 57)
    time();
});
$('input[name="cd"]').keyup(function(e){
  if(e.which >= 48 && e.which <= 57)
    time();
});
$('input[name="td"]').keyup(function(e){
  if(e.which >= 48 && e.which <= 57)
    time();
});

$('input[name="facil"]').change(function(){
  if($(this).attr("checked")){
    $('input[name="cf"]').removeAttr('readonly');
    $('input[name="tf"]').removeAttr('readonly');
    $('input[name="cf"]').attr('required', 'required');
    $('input[name="tf"]').attr('required', 'required');
  }
  else{
    $('input[name="cf"]').attr('readonly', 'readonly');
    $('input[name="tf"]').attr('readonly', 'readonly');
    $('input[name="cf"]').removeAttr('required');
    $('input[name="tf"]').removeAttr('required');
    $('input[name="cf"]').val(null);
    $('input[name="tf"]').val(null);
  }
  time();
});
$('input[name="medio"]').change(function(){
  if($(this).attr("checked")){
    $('input[name="cm"]').removeAttr('readonly');
    $('input[name="tm"]').removeAttr('readonly');
    $('input[name="cm"]').attr('required', 'required');
    $('input[name="tm"]').attr('required', 'required');
  }
  else{
    $('input[name="cm"]').attr('readonly', 'readonly');
    $('input[name="tm"]').attr('readonly', 'readonly');
    $('input[name="cm"]').removeAttr('required');
    $('input[name="tm"]').removeAttr('required');
    $('input[name="cm"]').val(null);
    $('input[name="tm"]').val(null);
  }
  time();
});
$('input[name="dificil"]').change(function(){
  if($(this).attr("checked")){
    $('input[name="cd"]').removeAttr('readonly');
    $('input[name="td"]').removeAttr('readonly');
    $('input[name="cd"]').attr('required', 'required');
    $('input[name="td"]').attr('required', 'required');
  }
  else{
    $('input[name="cd"]').attr('readonly', 'readonly');
    $('input[name="td"]').attr('readonly', 'readonly');
    $('input[name="cd"]').removeAttr('required');
    $('input[name="td"]').removeAttr('required');
    $('input[name="cd"]').val(null);
    $('input[name="td"]').val(null);
  }
  time();
});

function time(){
  var total = $('input[name="cf"]').val() * $('input[name="tf"]').val();
  total += $('input[name="cm"]').val() * $('input[name="tm"]').val();
  total += $('input[name="cd"]').val() * $('input[name="td"]').val();
  
  $('#time').html(total);
}

function check_time(){
  if($('#time').html() > 0)
    return true;
  return false;
}