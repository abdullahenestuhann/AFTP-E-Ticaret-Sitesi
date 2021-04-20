$(document).ready(function () {

  $.SoruIcerigiGoster = function (ElemanIDsi) {

    var SoruIDsi = ElemanIDsi;
    var IslenecekAlan = "#" + ElemanIDsi;

    $(".SorununCevapAlani").slideUp();
    $(IslenecekAlan).parent().find(".SorununCevapAlani").slideToggle();

  }
  $.UrunDetayResmiDegistir = function (Klasor, ResimDegeri) {
    var ResimIcınDosyaYolu = "Resimler/UrunResimleri/" + Klasor + "/" + ResimDegeri;

    $("#BuyukResim").attr("src", ResimIcınDosyaYolu);


  }

});
