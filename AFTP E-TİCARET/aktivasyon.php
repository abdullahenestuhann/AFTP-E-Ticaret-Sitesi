<?php
require_once( "Ayarlar/ayar.php" );
require_once( "Ayarlar/fonksiyonlar.php" );

if ( isset( $_GET[ "AktivasyonKodu" ] ) ) {
  $AktivasyonKodu = Guvenlik( $_GET[ "AktivasyonKodu" ] );
} else {
  $AktivasyonKodu = "";
}


if ( isset( $_GET[ "Email" ] ) ) {
  $GelenEMailAdresi = Guvenlik( $_GET[ "Email" ] );
} else {
  $GelenEMailAdresi = "";
}


if ( ( $AktivasyonKodu != "" )and( $GelenEMailAdresi != "" ) ) {
  $KontrolSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM uyeler WHERE EmailAdresi = ? AND Aktivasyon = ? AND Durumu = ?" );
  $KontrolSorgusu->execute( [ $GelenEMailAdresi, $AktivasyonKodu, 0 ] );
  $KullaniciSayisi = $KontrolSorgusu->rowCount();

  if ( $KullaniciSayisi > 0 ) {
    $UyeGuncellemeSorgusu = $VeritabaniBaglantisi->prepare( "UPDATE uyeler SET Durumu = 1" );
    $UyeGuncellemeSorgusu->execute();
    $Kontrol = $UyeGuncellemeSorgusu->rowCount();

    if ( $Kontrol > 0 ) {
      header( "Location:index.php?SK=30" );
      exit();
    } else {

      header( "Location:" . $SiteLinki );
      exit();
    }
  } else {

    header( "Location:" . $SiteLinki );
    exit();
  }


} else {

  header( "Location:" . $SiteLinki );
  exit();
}


$VeritabaniBaglantisi = null;

?>