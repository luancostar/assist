window.addEventListener("load", function() {
    if ("geolocation" in navigator) {
      // Obter a localização atual do usuário
      navigator.geolocation.getCurrentPosition(
        function(position) {
          const latitude = position.coords.latitude;
          const longitude = position.coords.longitude;
  
          // Fazer uma chamada para um serviço de geocodificação para obter o endereço
          // (isso pode ser feito através de uma API de geocodificação, como Google Maps Geocoding API)
          // No exemplo a seguir, usaremos a API do OpenStreetMap Nominatim como exemplo:
  
          const apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;
          fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
              const endereco = data.display_name;
              const inputEndereco = document.getElementById("endereco");
              inputEndereco.value = endereco;
            })
            .catch(error => {
              console.error("Erro ao obter o endereço:", error);
            });
        },
        function(error) {
          console.error("Erro na geolocalização:", error);
        }
      );
    } else {
      console.error("Geolocalização não suportada pelo navegador.");
    }
  });