$(document).ready(function(){
    $( document ).on( 'focus', ':input', function(){
        $( this ).attr( 'autocomplete', 'off' );
    });
});

function komabilangan(n){
    var rx= /(\d+)(\d{3})/;
    return String(n).replace(/^\d+/, function(w){
        while(rx.test(w)){
           w= w.replace(rx, '$1.$2');
        }
        return w;
    });
}

function showterbilang(bilangan,id){
  tb=terbilang(bilangan);
  var od=document.getElementById(id);
  if(od){
    if((od.tagName=='INPUT')) od.value=tb;
    else if((od.tagName=='DIV')) od.innerHTML=tb;
  } 
}
function trim(str) {
  return str.replace(/^\s+|\s+$/g,"");
}
function terbilang(bil) {
 bil=Math.round(bil,0);
 bilangan    = String(bil);
 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
 var tanda="";
 
 
 var panjang_bilangan = bilangan.length;
 /* pengujian panjang bilangan */
 if (panjang_bilangan > 15) {
   kaLimat = "Diluar Batas";
   return kaLimat;
 }
 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 for (i = 1; i <= panjang_bilangan; i++) {
   abil=bilangan.substr(-(i),1);
   if(abil=="-") tanda="Minus ";
   else angka[i] = abil;
 }
 
 i = 1;
 j = 0;
 kaLimat = "";
 
 
 /* mulai proses iterasi terhadap array angka */
 while (i <= panjang_bilangan) {
 
   subkaLimat = "";
   kata1 = "";
   kata2 = "";
   kata3 = "";
 
   /* untuk Ratusan */
   if (angka[i+2] != "0") {
     if (angka[i+2] == "1") {
       kata1 = "Seratus";
     } else {
       kata1 = trim(kata[angka[i+2]]) + " Ratus";
     }
   }
 
   /* untuk Puluhan atau Belasan */
   if (angka[i+1] != "0") {
     if (angka[i+1] == "1") {
       if (angka[i] == "0") {
         kata2 = "Sepuluh";
       } else if (angka[i] == "1") {
         kata2 = "Sebelas";
       } else {
         kata2 = trim(kata[angka[i]]) + " Belas";
       }
     } else {
       kata2 = trim(kata[angka[i+1]]) + " Puluh";
     }
   }
 
   /* untuk Satuan */
   if (angka[i] != "0") {
     if (angka[i+1] != "1") {
       kata3 = trim(kata[angka[i]]);
     }
   }
 
   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     subkaLimat = trim(kata1)+" "+trim(kata2)+" "+trim(kata3)+" "+trim(tingkat[j])+" ";
   }
 
   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   kaLimat = trim(subkaLimat) + trim(kaLimat);
   kaLimat = trim(kaLimat);
   i = i + 3;
   j = j + 1;
 
 }
 
 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }
 
 return trim(tanda+kaLimat);
}
