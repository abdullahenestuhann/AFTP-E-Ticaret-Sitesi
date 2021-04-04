<?php
if(isset($_SESSION["Kullanici"])){

if(isset($_POST["E-MailAdresi"])){
	$GelenEMailAdresi =  Guvenlik($_POST["E-MailAdresi"]);
}else{
	$GelenEMailAdresi = "";
}

if(isset($_POST["Sifre"])){
	$GelenSifre =  Guvenlik($_POST["Sifre"]);
}else{
	$GelenSifre = "";
}
if(isset($_POST["SifreTekrar"])){
	$GelenSifreTekrari =  Guvenlik($_POST["SifreTekrar"]);
}else{
	$GelenSifreTekrari = "";
}

if(isset($_POST["AdiSoyadi"])){
	$GelenIsimSoyisim =  Guvenlik($_POST["AdiSoyadi"]);
}else{
	$GelenIsimSoyisim = "";
}

if(isset($_POST["TelefonNumarasi"])){
	$GelenTelefonNumarasi = Guvenlik($_POST["TelefonNumarasi"]);
}else{
	$GelenTelefonNumarasi = "";
}

if(isset($_POST["Adres"])){
	$GelenAdres = Guvenlik($_POST["Adres"]);
}else{
	$GelenAdres = "";
}
$MD5liSifre		=	md5($GelenSifre);
if(($GelenEMailAdresi!="") and ($GelenSifre!="") and ($GelenSifreTekrari!="") and ($GelenIsimSoyisim!="") and ($GelenTelefonNumarasi!="")and ($GelenAdres!="")){
	
	
		if($GelenSifre!=$GelenSifreTekrari){
			header("Location:index.php?SK=57");//eşleşmeyen şifre
			exit();	
		}else{
			if($GelenSifre == "EskiSifre"){
				$SifreDegistirmeDurumu = 0;
			}else{
				$SifreDegistirmeDurumu = 1;
			}
			if($EmailAdresi == $GelenEMailAdresi){
				$KontrolSorgusu = $VeritabaniBaglantisi -> prepare("Select * from uyeler where EmailAdresi=?");
			$KontrolSorgusu -> execute([$GelenEMailAdresi]);
			$KullaniciSayisi     = $KontrolSorgusu->rowCount();
			if($KullaniciSayisi>0){
				header("Location:index.php?SK=55");//kullanılan email başka hesapta mevcut
				exit();}
			
			}
			if($SifreDegistirmeDurumu==1){
			$KullaniciGuncellemeSorgusu = $VeritabaniBaglantisi -> prepare("UPDATE uyeler SET EmailAdresi = ?, Sifre = ?, IsimSoyism = ?, TelefonNumarasi = ?,Adres = ? WHERE id = ? LIMIT 1");	
			$KullaniciGuncellemeSorgusu -> execute([$GelenEMailAdresi,$MD5liSifre,$GelenIsimSoyisim,$GelenTelefonNumarasi,$GelenAdres,$KullaniciId]);
			}else{
			$KullaniciGuncellemeSorgusu = $VeritabaniBaglantisi -> prepare("UPDATE uyeler SET EmailAdresi = ?, IsimSoyism = ?, TelefonNumarasi = ?,Adres = ?WHERE id = ? LIMIT 1");	
			$KullaniciGuncellemeSorgusu -> execute([$GelenEMailAdresi,$GelenIsimSoyisim,$GelenTelefonNumarasi,$GelenAdres,$KullaniciId]);
			}
					
			$KayitKontrol    = $KullaniciGuncellemeSorgusu->rowCount();
					if($KayitKontrol>0){
						$_SESSION["Kullanici"]=$GelenEMailAdresi;
						header("Location:index.php?SK=53");//tamam
						exit();
					}else{
					header("Location:index.php?SK=54");//hata
					exit();
				}
			}
		}

	
else{
	header("Location:index.php?SK=56");// eksik alan
	exit();

}	
	
}else{
	header("Location:index.php");
	exit();
		
	}
?>