<?php
use PHPMailer\ PHPMailer\ PHPMailer;
use PHPMailer\ PHPMailer\ Exception;

require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';

if ( isset( $_POST[ "E-MailAdresi" ] ) ) {
  $GelenEMailAdresi = Guvenlik( $_POST[ "E-MailAdresi" ] );
} else {
  $GelenEMailAdresi = "";
}

if ( isset( $_POST[ "Sifre" ] ) ) {
  $GelenSifre = Guvenlik( $_POST[ "Sifre" ] );
} else {
  $GelenSifre = "";
}
if ( isset( $_POST[ "SifreTekrar" ] ) ) {
  $GelenSifreTekrari = Guvenlik( $_POST[ "SifreTekrar" ] );
} else {
  $GelenSifreTekrari = "";
}

if ( isset( $_POST[ "AdiSoyadi" ] ) ) {
  $GelenIsimSoyisim = Guvenlik( $_POST[ "AdiSoyadi" ] );
} else {
  $GelenIsimSoyisim = "";
}

if ( isset( $_POST[ "TelefonNumarasi" ] ) ) {
  $GelenTelefonNumarasi = Guvenlik( $_POST[ "TelefonNumarasi" ] );
} else {
  $GelenTelefonNumarasi = "";
}

if ( isset( $_POST[ "Adres" ] ) ) {
  $GelenAdres = Guvenlik( $_POST[ "Adres" ] );
} else {
  $GelenAdres = "";
}
if ( isset( $_POST[ "SozlesmeOnay" ] ) ) {
  $SozlesmeOnay = Guvenlik( $_POST[ "SozlesmeOnay" ] );
} else {
  $SozlesmeOnay = "";
}
$AktivasyonKodu = AktivasyonKoduUret();
$MD5liSifre = md5( $GelenSifre );


if ( ( $GelenEMailAdresi != "" )and( $GelenSifre != "" )and( $GelenSifreTekrari != "" )and( $GelenIsimSoyisim != "" )and( $GelenTelefonNumarasi != "" )and( $GelenAdres != "" ) ) {
  if ( $SozlesmeOnay == 0 ) {
    header( "Location:index.php?SK=29" );
    exit();
  } else {
    if ( $GelenSifre != $GelenSifreTekrari ) {
      header( "Location:index.php?SK=28" );
      exit();
    } else {
      $KontrolSorgusu = $VeritabaniBaglantisi->prepare( "Select * from uyeler where EmailAdresi=?" );
      $KontrolSorgusu->execute( [ $GelenEMailAdresi ] );
      $KullaniciSayisi = $KontrolSorgusu->rowCount();
      if ( $KullaniciSayisi > 0 ) {
        header( "Location:index.php?SK=27" );
        exit();
      } else {
        $UyeEklemeSorgusu = $VeritabaniBaglantisi->prepare( "INSERT INTO uyeler(EmailAdresi,Sifre,IsimSoyism,TelefonNumarasi,Adres,Durumu,KayitTarihi,KayitIpAdresi,Aktivasyon) values(?,?,?,?,?,?,?,?,?)" );
        $UyeEklemeSorgusu->execute( [ $GelenEMailAdresi, $MD5liSifre, $GelenIsimSoyisim, $GelenTelefonNumarasi, $GelenAdres, 0, $ZamanDamgasi, $IPAdresi, $AktivasyonKodu ] );
        $KayitKontrol = $UyeEklemeSorgusu->rowCount();
        if ( $KayitKontrol > 0 ) {
          $MailIcerigiHazirla = "Merhaba Sayın " . $GelenIsimSoyisim . "<br /><br />Sitemize yapmış olduğunuz üyelik kaydını tamamlamak için lütfen <a href='" . $SiteLinki . "/aktivasyon.php?AktivasyonKodu=" . $AktivasyonKodu . "&Email=" . $GelenEMailAdresi . "'>BURAYA TIKLAYINIZ</a>.<br /><br />Saygılarımızla, iyi çalışmalar...<br />" . $SiteAdi;


          $MailGonder = new PHPMailer( true );

          try {


            $MailGonder->SMTPDebug = 0;
            $MailGonder->isSMTP();
            $MailGonder->Host = DonusumleriGeriDondur( $SiteEmailHostAdresi );
            $MailGonder->SMTPAuth = true;
            $MailGonder->CharSet = "UTF-8";
            $MailGonder->Username = DonusumleriGeriDondur( $SiteEmailAdresi );
            $MailGonder->Password = DonusumleriGeriDondur( $SiteEmailSifresi );
            $MailGonder->SMTPSecure = 'tls';
            $MailGonder->Port = 587;
            $MailGonder->SMTPOptions = array(
              'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
              )
            );
            $MailGonder->setFrom( DonusumleriGeriDondur( $SiteEmailAdresi ), DonusumleriGeriDondur( $SiteAdi ) );
            $MailGonder->addAddress( DonusumleriGeriDondur( $GelenEMailAdresi ), DonusumleriGeriDondur( $GelenIsimSoyisim ) );
            $MailGonder->addReplyTo( DonusumleriGeriDondur( $SiteEmailAdresi ), DonusumleriGeriDondur( $SiteAdi ) );
            $MailGonder->isHTML( true );
            $MailGonder->Subject = DonusumleriGeriDondur( $SiteAdi ) . ' AFTP KURUYEMİŞ YENİ ÜYELİK AKTİVASYON KODU';
            $MailGonder->MsgHTML( $MailIcerigiHazirla );
            $MailGonder->send();

            header( "Location:index.php?SK=24" );
            exit();
          } catch ( Exception $e ) {
            header( "Location:index.php?SK=25" );
            exit();
          }
        } else {
          header( "Location:index.php?SK=25" );
          exit();
        }
      }
    }
  }
} else {
  header( "Location:index.php?SK=26" );
  exit();
}

?>