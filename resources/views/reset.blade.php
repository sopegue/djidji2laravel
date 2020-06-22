<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}


h3, .add p{
  text-align:center;
}

.container {
  width:800px;
  border-radius: 5px;
  padding: 20px;
  margin: 0 auto
}
.goDjidji{
  text-decoration: none;
  color: #004e66 ;
}
.code{
  font-size:18x;
  font-weight:800;
}
</style>
</head>
<body>

<h3>Demande de réinitialisation de mot de passe sur <a class="goDjidji" href="http://127.0.0.1:8080/">Djidji.com</a></h3>

<div class="container">
<div class="info">
<p class="pinfo">Vous avez demandé(e) à réinitialiser votre mot de passe : <br> <span></span></p>
<p class="pinfo">Votre code est : <span class="code">{{$code}}</span></p>
</div>

<div class="add">
<h4>Copier le code ci-dessus pour le coller et réinitialiser votre mot de passe.</h4>
<p>Copyright © 2020 <a class="goDjidji" href="http://127.0.0.1:8080/">Djidji.com</a>. Tous droits réservés</p>
</div>

</div>

</body>
</html>
