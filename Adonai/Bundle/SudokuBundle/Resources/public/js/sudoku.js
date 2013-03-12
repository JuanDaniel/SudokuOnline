function calificar(id){
  $.ajax({
    url: Routing.generate('calificar', {"id": id}),
    type: 'POST',
    data: $('input[name="map[]"]').serialize(),
    success: function(data){
      alert(data['msg']);
      if(data['status'] == 1)
        window.location = Routing.generate('competencia', {"id": id});
    }
  });
}