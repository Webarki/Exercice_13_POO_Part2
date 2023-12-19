$(function () {
  //Requete Ajax inscription
  $("#btnRegister").on("click", function () {
    var email = $("#email").val();
    var password = $("#password").val();
    if (email != "") {
      if (password != "") {
        if (validateEmail(email) == true) {
          $.ajax({
            url: "dist/assets/js/register/register.php",
            type: "POST",
            async: true,
            data: {
              email: email,
              password: password,
            },
            crossDomain: true,
            dataType: "json",
            timeout: 2000,
            cache: false,
          })
            .done(function (returnData) {
              response = returnData;
              if (response.type == "Success") {
                document.getElementById("form").remove();
                var elem = document.getElementsByClassName("elem");
                elem.innerHTML = response.data;
                alert("inscription réussie ");
                document.location.href = response.url;
              } else {
                var elem = document.getElementById("elem");
                elem.innerHTML = response.type + " " + response.data;
                alert(response.type);
              }
            })
            .fail(function (error) {
              var elem = document.getElementById("elem");
              elem.innerHTML = "Un compte existe deja avec cette adresse email";
              console.error(error);
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
