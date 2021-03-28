<?php
try{
	$VeritabaniBaglantisi = new PDO("mysql:host=localhost;dbname=aftp-e-ticaret-sitesi;charset=UTF-8","root","");
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


	
	
}else{
	//echo "Site  Hatası <br />". $Hata->getMessage();
	die();
}




?>