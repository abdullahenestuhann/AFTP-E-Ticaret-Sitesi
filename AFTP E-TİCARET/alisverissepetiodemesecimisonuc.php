<?php
if ( isset( $_SESSION[ "Kullanici" ] ) ) {

  if ( isset( $_POST[ "OdemeTuruSecimi" ] ) ) {
    $OdemeTuruSecimi = Guvenlik( $_POST[ "OdemeTuruSecimi" ] );
  } else {
    $OdemeTuruSecimi = "";
  }
  if ( isset( $_POST[ "TaksitSecimi" ] ) ) {
    $TaksitSecimi = Guvenlik( $_POST[ "TaksitSecimi" ] );
  } else {
    $TaksitSecimi = "";
  }

  if ( $OdemeTuruSecimi != "" ) {


    if ( $OdemeTuruSecimi == "Banka Havalesi" ) {


      $AlisverisSepetiSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM sepet WHERE UyeId = ? ORDER BY id DESC" );
      $AlisverisSepetiSorgusu->execute( [ $KullaniciId ] );
      $SepetSayisi = $AlisverisSepetiSorgusu->rowCount();
      $SepetUrunleri = $AlisverisSepetiSorgusu->fetchAll( PDO::FETCH_ASSOC );

      if ( $SepetSayisi > 0 ) {
        foreach ( $SepetUrunleri as $SepetSatirlari ) {

          $SepetIdsi = $SepetSatirlari[ "id" ];
          $SepetSepetNumarasi = $SepetSatirlari[ "SepetNumarasi" ];
          $SepettekiUyeId = $SepetSatirlari[ "UyeId" ];
          $SepettekiUrununIdsi = $SepetSatirlari[ "UrunId" ];
          $SepettekiAdresId = $SepetSatirlari[ "AdresId" ];
          $SepettekiUrununVaryantIdsi = $SepetSatirlari[ "VaryantId" ];
          $SepettekiKargoId = $SepetSatirlari[ "KargoId" ];
          $SepettekiUrununAdedi = $SepetSatirlari[ "UrunAdedi" ];
          $SepettekiOdemeSecimi = $SepetSatirlari[ "OdemeSecimi" ];
          $SepettekiTaksitSecimi = $SepetSatirlari[ "TaksitSecimi" ];


          $UrunBilgileriSorgusu = $VeritabaniBaglantisi->prepare( "Select * from urunler where id=? LIMIT 1" );
          $UrunBilgileriSorgusu->execute( [ $SepettekiUrununIdsi ] );
          $UrunKaydi = $UrunBilgileriSorgusu->fetch( PDO::FETCH_ASSOC );

          $UrununTuru = $UrunKaydi[ "UrunTuru" ];
          $UrununAdi = $UrunKaydi[ "UrunAdi" ];
          $UrununFiyati = $UrunKaydi[ "UrunFiyati" ];
          $UrununParaBirimi = $UrunKaydi[ "ParaBirimi" ];
          $UrununKDVOrani = $UrunKaydi[ "KdvOrani" ];
          $UrununKargoUcreti = $UrunKaydi[ "KargoUcreti" ];
          $UrununResmi = $UrunKaydi[ "UrunResmiBir" ];
          $UrununVaryantBasligi = $UrunKaydi[ "VaryantBasligi" ];


          $UrunVaryantBilgileriSorgusu = $VeritabaniBaglantisi->prepare( "Select * from urunvaryanlari where id=? LIMIT 1" );
          $UrunVaryantBilgileriSorgusu->execute( [ $SepettekiUrununVaryantIdsi ] );
          $VaryanKaydi = $UrunVaryantBilgileriSorgusu->fetch( PDO::FETCH_ASSOC );

          $VaryantAdi = $VaryanKaydi[ "VaryanAdi" ];

          $UrunKargoBilgileriSorgusu = $VeritabaniBaglantisi->prepare( "Select * from kargofirmalari where id=? LIMIT 1" );
          $UrunKargoBilgileriSorgusu->execute( [ $SepettekiKargoId ] );
          $KargoKaydi = $UrunKargoBilgileriSorgusu->fetch( PDO::FETCH_ASSOC );

          $KargonunAdi = $KargoKaydi[ "KargoFirmasiAdi" ];


          $AdresBilgileriSorgusu = $VeritabaniBaglantisi->prepare( "Select * from adresler where id=? LIMIT 1" );
          $AdresBilgileriSorgusu->execute( [ $SepettekiAdresId ] );
          $AdresKaydi = $AdresBilgileriSorgusu->fetch( PDO::FETCH_ASSOC );

          $AdresAdiSoyadi = $AdresKaydi[ "AdiSoyadi" ];
          $AdresAdres = $AdresKaydi[ "Adres" ];
          $AdresIlce = $AdresKaydi[ "Ilce" ];
          $AdresSehir = $AdresKaydi[ "Sehir" ];
          $AdresToparla = $AdresAdres . " " . $AdresIlce . " " . $AdresSehir;
          $AdresTelefonNumarasi = $AdresKaydi[ "TelefonNumarasi" ];

          if ( $UrununParaBirimi == "USD" ) {
            $UrunFiyatiHesapla = $UrununFiyati * $DolarKuru;
          } elseif ( $UrununParaBirimi == "EUR" ) {
            $UrunFiyatiHesapla = $UrununFiyati * $EuroKuru;
          } else {
            $UrunFiyatiHesapla = $UrununFiyati;
          }
          $UrununToplamFiyati = ( $UrunFiyatiHesapla * $SepettekiUrununAdedi );
          $UrununToplamKargoFiyati = $UrununKargoUcreti;

          $SiparisEkle = $VeritabaniBaglantisi->prepare( "INSERT INTO siparisler (UyeId,SiparisNumarasi,UrunId,UrunTuru,UrunAdi,UrunFiyati,	KdvOrani,UrunAdedi,ToplamUrunFiyati,KargoFirmasiSecimi,KargoUcreti,UrunResmiBir,VaryantBasligi,	VaryantSecimi,AdresAdiSoyadi,AdresDetay, AdresTelefon, OdemeSecimi, TaksitSecimi, SiparisTarihi, SiparisIpAdresi) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)" );
          $SiparisEkle->execute( [ $SepettekiUyeId, $SepetSepetNumarasi, $SepettekiUrununIdsi, $UrununTuru, $UrununAdi, $UrunFiyatiHesapla, $UrununKDVOrani, $SepettekiUrununAdedi, $UrununToplamFiyati, $KargonunAdi, $UrununToplamKargoFiyati, $UrununResmi, $UrununVaryantBasligi, $VaryantAdi, $AdresAdiSoyadi, $AdresToparla, $AdresTelefonNumarasi, $OdemeTuruSecimi, 0, $ZamanDamgasi, $IPAdresi ] );
          $EklemeKontrol = $SiparisEkle->rowCount();
          if ( $EklemeKontrol > 0 ) {
            $SepettenSilmeSorgusu = $VeritabaniBaglantisi->prepare( "DELETE FROM sepet WHERE id = ? AND UyeId = ? LIMIT 1" );
            $SepettenSilmeSorgusu->execute( [ $SepetIdsi, $SepettekiUyeId ] );

            $UrunSatisiArttirmaSorgusu = $VeritabaniBaglantisi->prepare( "UPDATE urunler SET ToplamSatisSayisi=ToplamSatisSayisi + ? WHERE id = ?" );
            $UrunSatisiArttirmaSorgusu->execute( [ $SepettekiUrununAdedi, $SepettekiUrununIdsi ] );

            $StokGuncellemeSorgusu = $VeritabaniBaglantisi->prepare( "UPDATE urunvaryanlari SET StokAdedi=StokAdedi - ? WHERE id = ? LIMIT 1" );
            $StokGuncellemeSorgusu->execute( [ $SepettekiUrununAdedi, $SepettekiUrununVaryantIdsi ] );
          } else {
            header( "Location:index.php?SK=102" );
            exit();
          }


        }

        $KargoFiyatiIcinSiparislerSorgusu = $VeritabaniBaglantisi->prepare( "SELECT SUM(ToplamUrunFiyati) AS ToplamUcret FROM siparisler WHERE UyeId = ? AND SiparisNumarasi = ?" );
        $KargoFiyatiIcinSiparislerSorgusu->execute( [ $KullaniciId, $SepetSepetNumarasi ] );
        $KargoFiyatiKaydi = $KargoFiyatiIcinSiparislerSorgusu->fetch( PDO::FETCH_ASSOC );
        $ToplamUcretimiz = $KargoFiyatiKaydi[ "ToplamUcret" ];

        if ( $ToplamUcretimiz >= $UcretsizKargoBaraji ) {
          $SiparisiGuncelle = $VeritabaniBaglantisi->prepare( "UPDATE siparisler SET KargoUcreti = ? WHERE UyeId = ? AND SiparisNumarasi = ?" );
          $SiparisiGuncelle->execute( [ 0, $SepettekiUyeId, $SepetSepetNumarasi ] );
        }


        header( "Location:index.php?SK=101" );
        exit();

      } else {
        header( "Location:index.php" );
        exit();
      }


    } else {
      if ( $TaksitSecimi != "" ) {


        $SepetiGuncelle = $VeritabaniBaglantisi->prepare( "UPDATE sepet SET OdemeSecimi=?, TaksitSecimi=? where UyeId=?" );
        $SepetiGuncelle->execute( [ $OdemeTuruSecimi, $TaksitSecimi, $KullaniciId ] );
        $SepetKontrol = $SepetiGuncelle->rowCount();

        if ( $SepetKontrol > 0 ) {
          header( "Location:index.php?SK=103" );
          exit();
        } else {
          header( "Location:index.php" );
          exit();
        }


        echo "kredi kartı işlemleri";


      } else {
        header( "Location:index.php" );
        exit();
      }
    }


  } else {
    header( "Location:index.php" );
    exit();
  }

} else {
  header( "Location:index.php" );
  exit();

}
?>