<?php
if ( isset( $_SESSION[ "Kullanici" ] ) ) {
  if ( isset( $_GET[ "ID" ] ) ) {
    $GelenID = Guvenlik( $_GET[ "ID" ] );
  } else {
    $GelenID = "";
  }

  if ( $GelenID != "" ) {


    $KullanicininSepetKontrolSorgusu = $VeritabaniBaglantisi->prepare( "select * from sepet where UyeId=? order by id desc LIMIT 1" );
    $KullanicininSepetKontrolSorgusu->execute( [ $KullaniciId ] );
    $KullanicininSepetSayisi = $KullanicininSepetKontrolSorgusu->rowCount();

    if ( $KullanicininSepetSayisi > 0 ) {

      $UrunSepetKontrolSorgusu = $VeritabaniBaglantisi->prepare( "select * from sepet where UyeId=? and UrunId = ?  LIMIT 1" );
      $UrunSepetKontrolSorgusu->execute( [ $KullaniciId, $GelenID ] );
      $UrunSepetKontrolSayisi = $UrunSepetKontrolSorgusu->rowCount();
      $UrunSepetKontrolKaydi = $UrunSepetKontrolSorgusu->fetch( PDO::FETCH_ASSOC );


      if ( $UrunSepetKontrolSayisi > 0 ) {
        $UrununIDsi = $UrunSepetKontrolKaydi[ "id" ];
        $UrununSepettekiMevcutAdedi = $UrunSepetKontrolKaydi[ "UrunAdedi" ];
        $UrununYeniAdedi = $UrununSepettekiMevcutAdedi + 1;

        $UrunGuncellemeSorgusu = $VeritabaniBaglantisi->prepare( "update sepet set UrunAdedi = ? where id= ? and UyeId =? and UrunId=? LIMIT 1" );
        $UrunGuncellemeSorgusu->execute( [ $UrununYeniAdedi, $UrununIDsi, $KullaniciId, $GelenID ] );
        $UrunGuncellemeSayisi = $UrunGuncellemeSorgusu->rowCount();
        if ( $UrunGuncellemeSayisi > 0 ) {
          header( "Location:index.php?SK=94" );
          exit();
        } else {
          header( "Location:index.php?SK=92" );
          exit();
        }


      } else {
        $UrunEklemeSorgusu = $VeritabaniBaglantisi->prepare( "insert into sepet (UyeId,UrunId,UrunAdedi) values (?,?,?)" );
        $UrunEklemeSorgusu->execute( [ $KullaniciId, $GelenID, 1 ] );
        $UrunEklemeSayisi = $UrunEklemeSorgusu->rowCount();
        $SonIdDgeri = $VeritabaniBaglantisi->lastInsertId();
        if ( $UrunEklemeSayisi > 0 ) {
          $SiparisNumarasiGuncelleSorgusu = $VeritabaniBaglantisi->prepare( "update sepet set SepetNumarasi = ? where UyeId= ? " );
          $SiparisNumarasiGuncelleSorgusu->execute( [ $SonIdDgeri, $KullaniciId ] );
          $SiparisNumarasiGuncellemeSayisi = $SiparisNumarasiGuncelleSorgusu->rowCount();

          if ( $SiparisNumarasiGuncellemeSayisi > 0 ) {
            header( "Location:index.php?SK=94" );
            exit();
          } else {
            header( "Location:index.php?SK=92" );
            exit();
          }

        } else {
          header( "Location:index.php?SK=92" );
          exit();
        }
      }


    } else {
      $UrunEklemeSorgusu = $VeritabaniBaglantisi->prepare( "insert into sepet (UyeId,UrunId, UrunAdedi) values (?,?,?)" );
      $UrunEklemeSorgusu->execute( [ $KullaniciId, $GelenID, 1 ] );
      $UrunEklemeSayisi = $UrunEklemeSorgusu->rowCount();
      $SonIdDgeri = $VeritabaniBaglantisi->lastInsertId();
      if ( $UrunEklemeSayisi > 0 ) {
        $SiparisNumarasiGuncelleSorgusu = $VeritabaniBaglantisi->prepare( "update sepet set SepetNumarasi = ? where UyeId= ? " );
        $SiparisNumarasiGuncelleSorgusu->execute( [ $SonIdDgeri, $KullaniciId ] );
        $SiparisNumarasiGuncellemeSayisi = $SiparisNumarasiGuncelleSorgusu->rowCount();

        if ( $SiparisNumarasiGuncellemeSayisi > 0 ) {
          header( "Location:index.php?SK=94" );
          exit();
        } else {
          header( "Location:index.php?SK=92" );
          exit();
        }


      } else {
        header( "Location:index.php?SK=92" );
        exit();
      }

    }


  } else {
    header( "Location:index.php" );
    exit();
  }
} else {
  header( "Location:index.php?SK=93" );
  exit();
}
?>