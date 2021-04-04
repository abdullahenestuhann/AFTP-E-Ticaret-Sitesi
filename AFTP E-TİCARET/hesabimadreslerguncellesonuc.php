<?php
if(isset($_SESSION["Kullanici"])){

if(isset($_GET["ID"])){
	$GelenID =  Guvenlik($_GET["ID"]);
}else{
	$GelenID = "";
}
	
if(isset($_POST["AdiSoyadi"])){
	$GelenIsimSoyisim =  Guvenlik($_POST["AdiSoyadi"]);
}else{
	$GelenIsimSoyisim = "";
}	
if(isset($_POST["Adres"])){
	$GelenAdres = Guvenlik($_POST["Adres"]);
}else{
	$GelenAdres = "";
}	

if(isset($_POST["Ilce"])){
	$GelenIlce =  Guvenlik($_POST["Ilce"]);
}else{
	$GelenIlce = "";
}

if(isset($_POST["Sehir"])){
	$GelenSehir =  Guvenlik($_POST["Sehir"]);
}else{
	$GelenSehir = "";
}

if(isset($_POST["TelefonNumarasi"])){
	$GelenTelefonNumarasi = Guvenlik($_POST["TelefonNumarasi"]);
}else{
	$GelenTelefonNumarasi = "";
}


if(($GelenID!="") and ($GelenIsimSoyisim!="") and ($GelenAdres!="") and ($GelenIlce!="") and ($GelenSehir!="") and ($GelenTelefonNumarasi!="")){
	
	
	
	
			$AdresGuncellemeSorgusu = $VeritabaniBaglantisi -> prepare("UPDATE  adresler SET AdiSoyadi = ?, Adres = ?, Ilce = ?, Sehir = ?, TelefonNumarasi = ? WHERE id = ? and UyeId = ? LIMIT 1");	
			$AdresGuncellemeSorgusu -> execute([$GelenIsimSoyisim,$GelenAdres,$GelenIlce,$GelenSehir,$GelenTelefonNumarasi,$GelenID,$KullaniciId]);
			$GuncellemeKontrol 		= $AdresGuncellemeSorgusu->rowCount();
			
			if($GuncellemeKontrol>0){

				header("Location:index.php?SK=64");// eksik alan
				exit();

			}else{

					header("Location:index.php?SK=65");// eksik alan
					exit();

			}

}
		
	

	
else{
	header("Location:index.php?SK=66");// eksik alan
	exit();

}	
	
}else{
	header("Location:index.php");
	exit();
		
	}
?>