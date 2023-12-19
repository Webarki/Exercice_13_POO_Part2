$(function () {
  //Requete Ajax connexion
  $("#btnLogin").on("click", function () {
    var login = $("#email").val();
    var password = $("#password").val();
    if (login != "") {
      if (password != "") {
        if (validateEmail(login) == true) {
          $.ajax({
            url: "dist/assets/js/login/login.php",
            type: "POST",
            data: {
              login: login,
              password: password,
            },
            cache: false,
          }).done(function (returnData) {
            response = JSON.parse(returnData);
            if (response.type == "Success") {
              alert("connexion réussie ");
              document.location.href = response.url;
            } else {
              var elem = document.getElementById("elem");
              elem.innerHTML = response.data;
            }
          });
        } else {
          var elem = document.getElementById("elem");
          elem.innerHTML = "Veuillez renseigner une adresse email valide !";
        }
      } else {
        var elem = document.getElementById("elem");
        elem.innerHTML = "Le champs ne peut être vide";
      }
    } else {
      var elem = document.getElementById("elem");
      elem.innerHTML = "Le champs ne peut être vide";
    }
  });
});
