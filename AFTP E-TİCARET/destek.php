<form action="index.php?SK=21" method="post">
<table width="1065"   align="center" border="0" cellpadding="0" cellspacing="0"> 
	<tr height="100" bgcolor="#FF9900">
		<td align="left"><H2 style="color: white;">&nbsp;SIK SORULAN SORULAR</H2></td>					
		 </tr>
	<tr height="50">
		<td style="border-bottom: 1px dashed #CCCCCC;" lign="left">Aklınıza takılacağını düşündüğümüz soruların cevaplarını bu sayfada cevapladık.Fakat farklı bir sorunuz varsa lütfen iletişim alanından bizlere iletiniz.</td>					
		 </tr>

	<tr>
		<td><?php	
			
				$SoruSorgusu = $VeritabaniBaglantisi -> prepare("Select * from sorular");
				$SoruSorgusu -> execute();
				$SoruSayisi     = $SoruSorgusu->rowCount();
				$SoruKayitlari      = $SoruSorgusu->fetchAll(PDO::FETCH_ASSOC);
			
			foreach($SoruKayitlari as $Kayitlar){
			?>
			<div>
			
			<div id="<?php echo $Kayitlar["id"];?>" class="SorununBaslikAlani" onClick="$.SoruIcerigiGoster(<?php echo $Kayitlar["id"];?>)"><?php echo $Kayitlar["soru"];?></div>
			<div class="SorununCevapAlani" style="display: none;"><?php echo $Kayitlar["cevap"];?></div>	
			</div>
			<?php				
			}
			?>
		</td>		
		 </tr>
 
</table>
	</form>