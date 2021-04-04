<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';

if(isset($_GET["EmailAdresi"])){
	$EmailAdresi =  Guvenlik($_GET["EmailAdresi"]);
}else{
	$EmailAdresi = "";
}
if(isset($_GET["AktivasyonKodu"])){
	$AktivasyonKodu =  Guvenlik($_GET["AktivasyonKodu"]);
}else{
	$AktivasyonKodu = "";
}

if(isset($_POST["YeniSifre"])){
	$GelenSifre =  Guvenlik($_POST["YeniSifre"]);
}else{
	$GelenSifre = "";
}
if(isset($_POST["SifreTekrari"])){
	$GelenSifreTekrari =  Guvenlik($_POST["SifreTekrari"]);
}else{
	$GelenSifreTekrari = "";
}
$MD5liSifre		=	md5($GelenSifre);


if(($GelenSifre!="") and ($GelenSifreTekrari!="") and ($EmailAdresi!="") and ($AktivasyonKodu!="")){
		if($GelenSifre!=$GelenSifreTekrari){
			header("Location:index.php?SK=47");
			exit();	
		}else{
		$UyeGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE uyeler SET Sifre = ? WHERE EmailAdresi = ? AND Aktivasyon = ? LIMIT 1 ");
		$UyeGuncellemeSorgusu->execute([$MD5liSifre,$EmailAdresi,$AktivasyonKodu]);
		$Kontrol		=	$UyeGuncellemeSorgusu->rowCount();

					if($Kontrol>0){
						
						header("Location:index.php?SK=45");
						exit();					
					}else{
							
					header("Location:index.php?SK=46");
					exit();
				}

		}
}else{
	header("Location:index.php?SK=48");
	exit();
}

?>