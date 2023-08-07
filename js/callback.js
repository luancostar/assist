function CalculaDistancia() {
  $("#litResultado").html("Traçando melhor rota...");
  //Instanciar o DistanceMatrixService
  var service = new google.maps.DistanceMatrixService();
  //executar o DistanceMatrixService
  service.getDistanceMatrix(
    {
      //Origem
      origins: [$("#endereco").val()],
      //Destino
      destinations: [$("#txtDestino").val()],
      //Modo (DRIVING | WALKING | BICYCLING)
      travelMode: google.maps.TravelMode.DRIVING,
      //Sistema de medida (METRIC | IMPERIAL)
      unitSystem: google.maps.UnitSystem.METRIC,
      //Vai chamar o callback
    },
    callback
  );
}
//Tratar o retorno do DistanceMatrixService
function callback(response, status) {
  //Verificar o Status
  if (status != google.maps.DistanceMatrixStatus.OK)
    //Se o status não for "OK"
    $("#litResultado").html(status);
  else {
    //Se o status for OK
    //Endereço de origem = response.originAddresses
    //Endereço de destino = response.destinationAddresses
    //Distância = response.rows[0].elements[0].distance.text
    //Duração = response.rows[0].elements[0].duration.text
    $("#litResultado").html(
      // "<strong>Origem</strong>: " + response.originAddresses +
      "<strong>Destino:</strong> " +
        response.destinationAddresses +
        "<br /><strong>Distância</strong>: " +
        response.rows[0].elements[0].distance.text +
        " <br /><strong>Duração</strong>: " +
        response.rows[0].elements[0].duration.text
    );
    //Atualizar o mapa
    $("#map").attr(
      "src",
      "https://maps.google.com/maps?saddr=" +
        response.originAddresses +
        "&daddr=" +
        response.destinationAddresses +
        "&output=embed"
    );

    // SELECIONA O FORMULÁRIO QUE CRIARÁ A NOVA VIAGEM
    var form = document.getElementById("travel-form");

    // REMOVE INPUTS QUE PODEM TER SIDO INSERIDOS ANTERIORMENTE
    var inputToRemove = form.querySelector('input[name="distancia"]');
    if (inputToRemove) {
      form.removeChild(inputToRemove);
    }

    var hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "distancia"; // Name of the input
    hiddenInput.value = response.rows[0].elements[0].distance.value; // Value you want to send
    form.appendChild(hiddenInput);

    var hiddenInput = document.createElement("input");
    hiddenInput.type = "hidden";
    hiddenInput.name = "origem"; // Name of the input
    hiddenInput.value = response.originAddresses; // Value you want to send
    form.appendChild(hiddenInput);
  }
}
