<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}


h3,.goDjidjia,.row-2{
  text-align:center;
}


.ads{
  width: fit-content;
  padding-bottom:0.5rem;
  cursor: pointer;
  border: 1px solid rgb(184, 184, 184);
  border-radius: 10px !important;
}
.row-2{
  position: relative;
}

.container {
  width:800px;
  display:flex;
  justify-content: space-between;
  border-radius: 5px;
  padding: 20px;
  margin: 0 auto
}
.goDjidjia{
  text-decoration: none;
  color: rgb(82, 82, 82) ;
}
.goDjidji{
  text-decoration: none;
  color: #004e66 ;
}
.ad-image{
  width:160px;
  height:160px;
  padding:2px;
  border-radius: 10px !important;
}
.info{
  width:60%;
  margin-top:20px;
}
.add{
  margin-left:40%;
  margin-top:-2px;
}
.descPrix,.descPrix-r-second,.pinfo,.pinfom{
  font-weight:700;
}
.pinfo,.pinfom,h3{
  color: black;
}
.pinfo span{
  font-size:15px;
  font-weight:400;
  color: black !important;
}
.pinfom span{
  font-size:15px;
  display:block;
  word-wrap: break-word;
  font-weight:400;
  color: black !important;
}
.descPrix-r-second,.descPrix,h4{
  color: black !important;
}
</style>
</head>
<body>

<h3>Vous avez reçu un message de <a class="goDjidji" href="http://127.0.0.1:8080/">Djidji.com</a></h3>

<div class="container">
<div class="info">
<p class="pinfo">Nom expéditeur : <br> <span>{{$details['name']}}</span></p>
<p class="pinfo">Email expéditeur : <br> <span>{{$details['email']}}</span></p>
<p class="pinfom">Message <br><br>
<span>{{$details['message']}}</span></p>
</div>

<div class="add">
<h4>Votre annonce</h4>
<div class="ads">
    <div class="row-1">
    <a class="goDjidjia" title="Cliquez pour voir votre annonce" href="<?php echo 'http://127.0.0.1:8080/#/annonce/'.$details['id']?>">
      <div class="ads-img">
        <img class="ad-image" src="https://i.ibb.co/Kwfc6h5/KFFPJLwfxfv-SWd-Nc-GQc3-BXNw-Euro-UYc0-KSry-Vp-Wy.jpg"/>
      </div>   
    </a>
    </div>
    <div class="row-2">
     
      <div class="ad-infoo d-flex flex-column">
      <br>
        <span class="descPrix">{{$details['prix']}} FCFA</span><br><br>
        <span class="descPrix-r-second">{{$details['titre']}}</span>
      </div>
 
    </div>
  </div>
</div>

</div>

</body>
</html>
