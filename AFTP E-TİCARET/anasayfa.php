<table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0">
        <?php
        $BannerSorgusu = $VeritabaniBaglantisi->prepare( "SELECT * FROM bannerlar WHERE BannerAlani = 'Ana Sayfa' ORDER BY GosterimSayisi ASC LIMIT 1" );
        $BannerSorgusu->execute();
        $BannerSayisi = $BannerSorgusu->rowCount();
        $BannerKaydi = $BannerSorgusu->fetch( PDO::FETCH_ASSOC );

        ?>
        <tr height="186">
          <td><img src="Oluşumlar/BannerOrnekleri/<?php echo $BannerKaydi["BannerResmi"];?>" border="0" </td>
        </tr>
        <?php
        $BannerGuncelle = $VeritabaniBaglantisi->prepare( "UPDATE bannerlar SET GosterimSayisi=GosterimSayisi+1 WHERE id= ? LIMIT 1 " );
        $BannerGuncelle->execute( [ $BannerKaydi[ "id" ] ] );


        ?>
      </table></td>
  </tr>
  <tr height="35">
    <td bgcolor="#F97400" style="color: white; font-weight: bold;">&nbsp;EN YENİ ÜRÜNLER </td>
  </tr>
  <tr>
    <td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <?php

          $EnYeniUrunlerSorgusu = $VeritabaniBaglantisi->prepare( "select * from urunler where    Durumu = '1' order by  id DESC LIMIT  5" );
          $EnYeniUrunlerSorgusu->execute();
          $EnYeniUrunSayisi = $EnYeniUrunlerSorgusu->rowCount();
          $EnYeniUrunKayitlari = $EnYeniUrunlerSorgusu->fetchALL( PDO::FETCH_ASSOC );

          $DonguSayisi = 1;

          foreach ( $EnYeniUrunKayitlari as $EnYeniUrunSatirlari ) {
            $EnYeniUrununFiyati = DonusumleriGeriDondur( $EnYeniUrunSatirlari[ "UrunFiyati" ] );
            $EnYeniUrununParaBirimi = DonusumleriGeriDondur( $EnYeniUrunSatirlari[ "ParaBirimi" ] );
            $EnYeniUrununTuru = DonusumleriGeriDondur( $EnYeniUrunSatirlari[ "UrunTuru" ] );

            if ( $EnYeniUrununParaBirimi == "USD" ) {
              $EnYeniUrunFiyatiHesapla = $EnYeniUrununFiyati * $DolarKuru;
            } elseif ( $EnYeniUrununParaBirimi == "EUR" ) {
              $EnYeniUrunFiyatiHesapla = $EnYeniUrununFiyati * $EuroKuru;
            } else {
              $EnYeniUrunFiyatiHesapla = $EnYeniUrununFiyati;
            }
            if ( $EnYeniUrununTuru == "Kayisi" ) {
              $EnYeniUrunResimKlasoru = "kayisi";
            } elseif ( $EnYeniUrununTuru == "Kuruyemis" ) {
              $EnYeniUrunResimKlasoru = "kuruyemis";
            } else {
              $EnYeniUrunResimKlasoru = "bos";
            }


            $EnYeniUrununToplamYorumSayisi = DonusumleriGeriDondur( $EnYeniUrunSatirlari[ "YorumSayisi" ] );
            $EnYeniUrununToplamYorumPuani = DonusumleriGeriDondur( $EnYeniUrunSatirlari[ "ToplamYorumPuani" ] );

            if ( $EnYeniUrununToplamYorumSayisi > 0 ) {
              $EnYeniPuanHesapla = number_format( $EnYeniUrununToplamYorumPuani / $EnYeniUrununToplamYorumSayisi, 2, ".", "" );
            } else {
              $EnYeniPuanHesapla = 0;
            }

            if ( $EnYeniPuanHesapla == 0 ) {
              $EnYeniPuanResmi = "YildizCizgiliBos.png";
            } elseif ( ( $EnYeniPuanHesapla > 0 )and( $EnYeniPuanHesapla <= 1 ) ) {
              $EnYeniPuanResmi = "YildizCizgiliBirDolu.png";
            } elseif ( ( $EnYeniPuanHesapla > 1 )and( $EnYeniPuanHesapla <= 2 ) ) {
              $EnYeniPuanResmi = "YildizCizgiliIkiDolu.png";
            } elseif ( ( $EnYeniPuanHesapla > 2 )and( $EnYeniPuanHesapla <= 3 ) ) {
              $EnYeniPuanResmi = "YildizCizgiliUcDolu.png";
            } elseif ( ( $EnYeniPuanHesapla > 3 )and( $EnYeniPuanHesapla <= 4 ) ) {
              $EnYeniPuanResmi = "YildizCizgiliDortDolu.png";
            } elseif ( $EnYeniPuanHesapla > 4 ) {
              $EnYeniPuanResmi = "YildizCizgiliBesDolu.png";
            }


            ?>
          <td width="205" valign="top"><table width="205"  align="left"  border="0"  cellpadding="0" cellspacing="0" style=" margin-bottom:10px">
              <!-- border: 1px solid #CCCCCC;-->
              <tr height="40">
                <td  align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]);?>"><img src="Resimler/UrunResimleri/<?php echo DonusumleriGeriDondur($EnYeniUrunResimKlasoru);?>/<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["UrunResmiBir"]);?>" border="0" width="185" height="247"></a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]);?>"style="color:#FF9900;font-weight: bold;text-decoration: none; "><?php echo $EnYeniUrununTuru;?></a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]);?>"style="color:#646464;font-weight: bold;text-decoration: none; ">
                  <div style="width:205px; max-width: 205px; height: 20px;overflow: hidden;line-height: 20px"> <?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["UrunAdi"])?> </div>
                  </a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]);?>"><img src="Resimler/<?php echo $EnYeniPuanResmi;?>" border="0"</a></td>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]);?>"style="color:#1515CB;font-weight: bold;text-decoration: none; "> <?php echo FiyatBicimlendir($EnYeniUrunFiyatiHesapla)?>TL </a></td>
              </tr>
            </table></td>
          <?php

          if ( $DonguSayisi < 4 ) {
            ?>
          <td width="10">&nbsp;</td>
          <?php
          }

          ?>
          <?php
          $DonguSayisi++;


          }
          ?>
        </tr>
      </table></td>
  <tr height="35">
    <td bgcolor="#F97400" style="color: white; font-weight: bold;">&nbsp;EN POPÜLER ÜRÜNLER </td>
  </tr>
  <tr>
    <td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <?php

          $EnPopularUrunlerSorgusu = $VeritabaniBaglantisi->prepare( "select * from urunler where    Durumu = '1' order by GoruntulenmeSayisi DESC LIMIT  5" );
          $EnPopularUrunlerSorgusu->execute();
          $EnPopularUrunSayisi = $EnPopularUrunlerSorgusu->rowCount();
          $EnPopularUrunKayitlari = $EnPopularUrunlerSorgusu->fetchALL( PDO::FETCH_ASSOC );

          $DonguSayisi = 1;

          foreach ( $EnPopularUrunKayitlari as $EnPopularUrunSatirlari ) {
            $EnPopularUrununFiyati = DonusumleriGeriDondur( $EnPopularUrunSatirlari[ "UrunFiyati" ] );
            $EnPopularUrununParaBirimi = DonusumleriGeriDondur( $EnPopularUrunSatirlari[ "ParaBirimi" ] );
            $EnPopularUrununTuru = DonusumleriGeriDondur( $EnPopularUrunSatirlari[ "UrunTuru" ] );

            if ( $EnPopularUrununParaBirimi == "USD" ) {
              $EnPopularUrunFiyatiHesapla = $EnPopularUrununFiyati * $DolarKuru;
            } elseif ( $EnPopularUrununParaBirimi == "EUR" ) {
              $EnPopularUrunFiyatiHesapla = $EnPopularUrununFiyati * $EuroKuru;
            } else {
              $EnPopularUrunFiyatiHesapla = $EnPopularUrununFiyati;
            }
            if ( $EnPopularUrununTuru == "Kayisi" ) {
              $EnPopularUrunResimKlasoru = "kayisi";
            } elseif ( $EnPopularUrununTuru == "Kuruyemis" ) {
              $EnPopularUrunResimKlasoru = "kuruyemis";
            } else {
              $EnPopularUrunResimKlasoru = "bos";
            }


            $EnPopularUrununToplamYorumSayisi = DonusumleriGeriDondur( $EnPopularUrunSatirlari[ "YorumSayisi" ] );
            $EnPopularUrununToplamYorumPuani = DonusumleriGeriDondur( $EnPopularUrunSatirlari[ "ToplamYorumPuani" ] );

            if ( $EnPopularUrununToplamYorumSayisi > 0 ) {
              $EnPopularPuanHesapla = number_format( $EnPopularUrununToplamYorumPuani / $EnPopularUrununToplamYorumSayisi, 2, ".", "" );
            } else {
              $EnPopularPuanHesapla = 0;
            }

            if ( $EnPopularPuanHesapla == 0 ) {
              $EnPopularPuanResmi = "YildizCizgiliBos.png";
            } elseif ( ( $EnPopularPuanHesapla > 0 )and( $EnPopularPuanHesapla <= 1 ) ) {
              $EnPopularPuanResmi = "YildizCizgiliBirDolu.png";
            } elseif ( ( $EnPopularPuanHesapla > 1 )and( $EnPopularPuanHesapla <= 2 ) ) {
              $EnPopularPuanResmi = "YildizCizgiliIkiDolu.png";
            } elseif ( ( $EnPopularPuanHesapla > 2 )and( $EnPopularPuanHesapla <= 3 ) ) {
              $EnPopularPuanResmi = "YildizCizgiliUcDolu.png";
            } elseif ( ( $EnPopularPuanHesapla > 3 )and( $EnPopularPuanHesapla <= 4 ) ) {
              $EnPopularPuanResmi = "YildizCizgiliDortDolu.png";
            } elseif ( $EnPopularPuanHesapla > 4 ) {
              $EnPopularPuanResmi = "YildizCizgiliBesDolu.png";
            }


            ?>
          <td width="205" valign="top"><table width="205"  align="left"  border="0"  cellpadding="0" cellspacing="0" style=" margin-bottom:10px">
              <!-- border: 1px solid #CCCCCC;-->
              <tr height="40">
                <td  align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopularUrunSatirlari["id"]);?>"><img src="Resimler/UrunResimleri/<?php echo DonusumleriGeriDondur($EnPopularUrunResimKlasoru);?>/<?php echo DonusumleriGeriDondur($EnPopularUrunSatirlari["UrunResmiBir"]);?>" border="0" width="185" height="247"></a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopularUrunSatirlari["id"]);?>"style="color:#FF9900;font-weight: bold;text-decoration: none; "><?php echo $EnPopularUrununTuru;?></a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopularUrunSatirlari["id"]);?>"style="color:#646464;font-weight: bold;text-decoration: none; ">
                  <div style="width:205px; max-width: 205px; height: 20px;overflow: hidden;line-height: 20px"> <?php echo DonusumleriGeriDondur($EnPopularUrunSatirlari["UrunAdi"])?> </div>
                  </a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopularUrunSatirlari["id"]);?>"><img src="Resimler/<?php echo $EnPopularPuanResmi;?>" border="0"</a></td>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopularUrunSatirlari["id"]);?>"style="color:#1515CB;font-weight: bold;text-decoration: none; "> <?php echo FiyatBicimlendir($EnPopularUrunFiyatiHesapla)?>TL </a></td>
              </tr>
            </table></td>
          <?php

          if ( $DonguSayisi < 4 ) {
            ?>
          <td width="10">&nbsp;</td>
          <?php
          }

          ?>
          <?php
          $DonguSayisi++;


          }
          ?>
        </tr>
      </table></td>
  </tr>
  <tr height="35">
    <td bgcolor="#F97400" style="color: white; font-weight: bold;">&nbsp;EN ÇOK SATAN ÜRÜNLER </td>
  </tr>
  <tr>
    <td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <?php

          $EnCokSatanUrunlerSorgusu = $VeritabaniBaglantisi->prepare( "select * from urunler where    Durumu = '1' order by ToplamSatisSayisi DESC LIMIT  5" );
          $EnCokSatanUrunlerSorgusu->execute();
          $EnCokSatanUrunSayisi = $EnCokSatanUrunlerSorgusu->rowCount();
          $EnCokSatanUrunKayitlari = $EnCokSatanUrunlerSorgusu->fetchALL( PDO::FETCH_ASSOC );

          $DonguSayisi = 1;

          foreach ( $EnCokSatanUrunKayitlari as $EnCokSatanUrunSatirlari ) {
            $EnCokSatanUrununFiyati = DonusumleriGeriDondur( $EnCokSatanUrunSatirlari[ "UrunFiyati" ] );
            $EnCokSatanUrununParaBirimi = DonusumleriGeriDondur( $EnCokSatanUrunSatirlari[ "ParaBirimi" ] );
            $EnCokSatanUrununTuru = DonusumleriGeriDondur( $EnCokSatanUrunSatirlari[ "UrunTuru" ] );

            if ( $EnCokSatanUrununParaBirimi == "USD" ) {
              $EnCokSatanUrunFiyatiHesapla = $EnCokSatanUrununFiyati * $DolarKuru;
            } elseif ( $EnCokSatanUrununParaBirimi == "EUR" ) {
              $EnCokSatanUrunFiyatiHesapla = $EnCokSatanUrununFiyati * $EuroKuru;
            } else {
              $EnCokSatanUrunFiyatiHesapla = $EnCokSatanUrununFiyati;
            }
            if ( $EnCokSatanUrununTuru == "Kayisi" ) {
              $EnCokSatanUrunResimKlasoru = "kayisi";
            } elseif ( $EnCokSatanUrununTuru == "Kuruyemis" ) {
              $EnCokSatanUrunResimKlasoru = "kuruyemis";
            } else {
              $EnCokSatanUrunResimKlasoru = "bos";
            }


            $EnCokSatanUrununToplamYorumSayisi = DonusumleriGeriDondur( $EnCokSatanUrunSatirlari[ "YorumSayisi" ] );
            $EnCokSatanUrununToplamYorumPuani = DonusumleriGeriDondur( $EnCokSatanUrunSatirlari[ "ToplamYorumPuani" ] );

            if ( $EnCokSatanUrununToplamYorumSayisi > 0 ) {
              $EnCokSatanPuanHesapla = number_format( $EnCokSatanUrununToplamYorumPuani / $EnCokSatanUrununToplamYorumSayisi, 2, ".", "" );
            } else {
              $EnCokSatanPuanHesapla = 0;
            }

            if ( $EnCokSatanPuanHesapla == 0 ) {
              $EnCokSatanPuanResmi = "YildizCizgiliBos.png";
            } elseif ( ( $EnCokSatanPuanHesapla > 0 )and( $EnCokSatanPuanHesapla <= 1 ) ) {
              $EnCokSatanPuanResmi = "YildizCizgiliBirDolu.png";
            } elseif ( ( $EnCokSatanPuanHesapla > 1 )and( $EnCokSatanPuanHesapla <= 2 ) ) {
              $EnCokSatanPuanResmi = "YildizCizgiliIkiDolu.png";
            } elseif ( ( $EnCokSatanPuanHesapla > 2 )and( $EnCokSatanPuanHesapla <= 3 ) ) {
              $EnCokSatanPuanResmi = "YildizCizgiliUcDolu.png";
            } elseif ( ( $EnCokSatanPuanHesapla > 3 )and( $EnCokSatanPuanHesapla <= 4 ) ) {
              $EnCokSatanPuanResmi = "YildizCizgiliDortDolu.png";
            } elseif ( $EnCokSatanPuanHesapla > 4 ) {
              $EnCokSatanPuanResmi = "YildizCizgiliBesDolu.png";
            }


            ?>
          <td width="205" valign="top"><table width="205"  align="left"  border="0"  cellpadding="0" cellspacing="0" style=" margin-bottom:10px">
              <!-- border: 1px solid #CCCCCC;-->
              <tr height="40">
                <td  align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]);?>"><img src="Resimler/UrunResimleri/<?php echo DonusumleriGeriDondur($EnCokSatanUrunResimKlasoru);?>/<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["UrunResmiBir"]);?>" border="0" width="185" height="247"></a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]);?>"style="color:#FF9900;font-weight: bold;text-decoration: none; "><?php echo $EnCokSatanUrununTuru;?></a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]);?>"style="color:#646464;font-weight: bold;text-decoration: none; ">
                  <div style="width:205px; max-width: 205px; height: 20px;overflow: hidden;line-height: 20px"> <?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["UrunAdi"])?> </div>
                  </a></td>
              </tr>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]);?>"><img src="Resimler/<?php echo $EnCokSatanPuanResmi;?>" border="0"</a></td>
              <tr height="25">
                <td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]);?>"style="color:#1515CB;font-weight: bold;text-decoration: none; "> <?php echo FiyatBicimlendir($EnCokSatanUrunFiyatiHesapla)?>TL </a></td>
              </tr>
            </table></td>
          <?php

          if ( $DonguSayisi < 4 ) {
            ?>
          <td width="10">&nbsp;</td>
          <?php
          }

          ?>
          <?php
          $DonguSayisi++;


          }
          ?>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="11">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="258"><table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><img src="Resimler/HizliTeslimat.png"</td>
              </tr>
              <tr>
                <td  align="center"><b>Bugün Teslimat</b></td>
              </tr>
              <tr>
                <td align="center">Saat 14.00'a kadar verdiğiniz siparişler aynı gün kapınızda.(İstanbul -Avrupa - Malatya içi) </td>
              </tr>
              <tr>
                <td></td>
              </tr>
            </table></td>
          <td width="11">&nbsp;</td>
          <td width="258"><table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><img src="Resimler/GuvenliAlisveris.png"</td>
              </tr>
              <tr>
                <td  align="center"><b>Tek Tıkla Güvenli Alışveriş</b></td>
              </tr>
              <tr>
                <td align="center">Ödeme ve Adres bilgileriniz kaydedin, güvenli alışveriş yapın. </td>
              </tr>
              <tr>
                <td></td>
              </tr>
            </table></td>
          <td width="11">&nbsp;</td>
          <td width="258">
            <table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><img src="Resimler/MobilErisim.png"</td>
              </tr>
              <tr>
                <td  align="center"><b>Mobil Erişim</b></td>
              </tr>
              <tr>
                <td align="center">Dilediğiniz her cihazdan sitemize erişebilir ve alışveriş yapabilirsiniz. </td>
              </tr>
              <tr>
                <td></td>
              </tr>
            </table></td>
          <td width="11">&nbsp;</td>
          <td width="258">
            <table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center"><img src="Resimler/IadeGarantisi.png"</td>
              </tr>
              <tr>
                <td  align="center"><b>Kolay İade</b></td>
              </tr>
              <tr>
                <td align="center">Aldığınız herhangi bir ürünü 14 gün içerisinde iade edebilirsiniz. </td>
              </tr>
              <tr>
                <td></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
