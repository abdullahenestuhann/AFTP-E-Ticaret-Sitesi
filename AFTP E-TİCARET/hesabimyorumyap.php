<?php
if ( isset( $_SESSION[ "Kullanici" ] ) ) {
  if ( isset( $_GET[ "UrunID" ] ) ) {
    $GelenID = Guvenlik( $_GET[ "UrunID" ] );
  } else {
    $GelenID = "";
  }
 if ( $GelenID != "" ) {
    ?>
<table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="500" valign="top"><form action="index.php?SK=76&UrunId=<?php echo $GelenID;?>" method="post">
        <table width="500"   align="center" border="0" cellpadding="0" cellspacing="0">
          <tr height="50">
            <td  style="color: #FF9900"><h3>Hesabım > Yorum Yap</h3></td>
          </tr>
          <tr height="30">
            <td  valign="top" style="border-bottom: 1px dashed #CCCCCC;">Satın Almış Olduğunuz Urün İle Alakalı Aşağıdan Yorumunu Belirtebilirsin .</td>
          </tr>
          <tr height="30">
            <td  valign="bottom" align="left">Puanlama </td>
          </tr>
          <tr height="30">
            <td   valign="top" align="left"><table width="360"   align="center" border="0" cellpadding="0" cellspacing="0">
                <tr>
				<td width="64"><img src="Resimler/YildizBirDolu.png" border="0"></td>
                  <td width="10"></td>
                  <td width="64"><img src="Resimler/YildizIkiDolu.png" border="0"></td>
                  <td width="10"></td>
                  <td width="64"><img src="Resimler/YildizUcDolu.png" border="0"></td>
                  <td width="10"></td>
                  <td width="64"><img src="Resimler/YildizDortDolu.png" border="0"></td>
                  <td width="10"></td>
                  <td width="64"><img src="Resimler/YildizBesDolu.png" border="0"></td>
                </tr>
                <tr>
                  <td width="64" align="center"><input type="radio" name="Puan" value="1"></td>
                  <td width="10">&nbsp;</td>
                  <td width="64" align="center"><input type="radio" name="Puan" value="2"></td>
                  <td width="10">&nbsp;</td>
                  <td width="64" align="center"><input type="radio" name="Puan" value="3"></td>
                  <td width="10">&nbsp;</td>
                  <td width="64" align="center"><input type="radio" name="Puan" value="4"></td>
                  <td width="10">&nbsp;</td>
                  <td width="64" align="center"><input type="radio" name="Puan" value="5"></td>
                </tr>
              </table></td>
          </tr>
          <tr height="30">
            <td  valign="bottom" align="left">Yorum Metni</td>
          </tr>
          <tr height="30">
            <td  valign="top" align="left"><textarea name="Yorum" class="YorumIcinTextAreaAlanlari"></textarea></td>
          </tr>
          <tr height="40">
            <td colspan="2" align="center"><input type="submit" value="Yorumu Gönder" class="KirmiziButon"></td>
          </tr>
        </table>
      </form></td>
    <td width="20">&nbsp;</td>
    <td valign="top" width="545"><table width="545"   align="center" border="0" cellpadding="0" cellspacing="0">
        <tr height="50">
          <td  style="color: #FF9900" ><h3>Reklam</h3></td>
        </tr>
        <tr height="30">
          <td c valign="top" style="border-bottom: 1px dashed #CCCCCC;"></td>
        </tr>
        <tr height="5">
          <td  height="5" style="font-size: 5px;">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><b><img src="Resimler/bu-alana-reklam-ver.jpg"</b></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php
}else{
		header("Location:index.php?SK=78");
		exit();
	}
}else{
	header("Location:index.php");
	exit();
}
?>
