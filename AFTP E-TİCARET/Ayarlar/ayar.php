<?php
try{
	$VeritabaniBaglantisi = new PDO("mysql:host=localhost;dbname=aftp-e-ticaret-sitesi;charset=UTF8","root","");
}catch(PDOException $Hata ){
	//echo "Bağlantı Hatası <br />". $Hata->getMessage();
	die();
}

$AyarlarSorgusu = $VeritabaniBaglantisi -> prepare("Select * from ayarlar LIMIT 1");
$AyarlarSorgusu -> execute();
$AyarSayisi     = $AyarlarSorgusu->rowCount();
$Ayarlar        = $AyarlarSorgusu->fetch(PDO::FETCH_ASSOC);

if($AyarSayisi>0){
	$SiteAdi                   = $Ayarlar["SiteAdi"];
	$SiteTitle                 = $Ayarlar["SiteTitle"];
	$SiteDescription           = $Ayarlar["SiteDescription"];
	$SiteKeywords              = $Ayarlar["SiteKeywords"];
	$SiteCopyrightMetni        = $Ayarlar["SiteCopyrightMetni"];
	$SiteLogosu                = $Ayarlar["SiteLogosu"];
	$SiteEmailAdresi           = $Ayarlar["SiteEmailAdresi"];
	$SiteEmailSifresi          = $Ayarlar["SiteEmailSifresi"];
	$SosyalLinkFacebook        = $Ayarlar["SosyalLinkFacebook"];
	$SosyalLinkTwitter         = $Ayarlar["SosyalLinkTwitter"];
	$SosyalLinkLinkedin        = $Ayarlar["SosyalLinkLinkedin"];
	$SosyalLinkInstagram       = $Ayarlar["SosyalLinkInstagram"];
	$SosyalLinkPinterest       = $Ayarlar["SosyalLinkPinterest"];
	$SosyalLinkYoutube         = $Ayarlar["SosyalLinkYoutube"];
	
	
}else{
	//echo "Site  Hatası <br />". $Hata->getMessage();
	die();
}
$MetinlerSorgusu = $VeritabaniBaglantisi -> prepare("Select * from sozlesmelervemetinler LIMIT 1");
$MetinlerSorgusu -> execute();
$MetinSayisi     = $MetinlerSorgusu->rowCount();
$Metinler        = $MetinlerSorgusu->fetch(PDO::FETCH_ASSOC);

if($MetinSayisi>0){
	$HakkimizdaMetni                  	  = $Metinler["HakkimizdaMetni"];
	$UyelikSozlesmesiMetni                = $Metinler["UyelikSozlesmesiMetni"];
	$KullanimKosullariMetni           	  = $Metinler["KullanimKosullariMetni"];
	$GizlilikSozlesmesiMetni              = $Metinler["GizlilikSozlesmesiMetni"];
	$MesafeliSatisSozlesmesimetni         = $Metinler["MesafeliSatisSozlesmesimetni"];
	$TeslimatMetni               		  = $Metinler["TeslimatMetni"];
	$IptalIadeDegisimMetni           	  = $Metinler["IptalIadeDegisimMetni"];

}else{
	//echo "Metinler  Hatası <br />". $Hata->getMessage();
	die();
}






?>