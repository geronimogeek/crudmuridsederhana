// // MEMBUAT LIVE SEARCH MENGGUNAKAN JS

// // ambil elemen yang dibutuhkan
// var keyword = document.getElementById('keyword');
// var tombolCari = document.getElementById('tombol-cari');
// var container = document.getElementById('container');

// // tombolCari.addEventListener('mouseover', function() {
// // 	alert('berhasil!');
// // });

// // tambahkan event ketika keywoard ditulis
// keyword.addEventListener('keyup', function(){
// 	// alert('berhasil!');
// 	// console.log(keyword.value);

// 	// buat object ajax
// 	var xhr = new XMLHttpRequest();

// 	// check kesiapan ajax
// 	xhr.onreadystatechange =  function(){
// 		if ( xhr.readyState == 4 && xhr.status == 200 ){
// 			// console.log(xhr.responseText);
// 			container.innerHTML = xhr.responseText;
// 		}
// 	}

// 	// eksekusi ajax
// 	xhr.open('GET', 'ajax/murid.php?keyword=' + keyword.value, true);
// 	xhr.send();

// });

// // END JS

// MEMANGGIL AJAX MENGGUNAKAN JS

$(document).ready(function(){

	// hilangkan tombol cari
	$('#tombol-cari').hide();

	// event ketika keyword ditulis
	$('#keyword').on('keyup', function() {
		// munculkan icon loading
		$('.loader').show();

		// ajax menggunakan
		// $('#container').load('ajax/murid.php?keyword=' + $('#keyword').val());

		// $.get()
		$.get('ajax/murid.php?keyword=' + $('#keyword').val(), function(data){

			$('#container').html(data);
			$('.loader').hide();

		})
	});

});

// var keyword = document.getElementById('keyword');
// keyword.addEventListener('keyup', function(){
// 	console.log('ok');
// });



