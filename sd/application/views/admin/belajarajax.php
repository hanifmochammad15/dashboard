 <!DOCTYPE html>
<html>
<head>
	<script src="<?php echo base_url('plugins/jquery/jquery.min.js') ?>"></script>

  <title>A Meaningful Page Title</title>
</head>
<body>

The content of the document......
<p id="nama"></p>

<p id="usia"></p>
<p id="alamat"></p>
</body>
</html> 

<script type="text/javascript">
	var post_usia=30;
	var post_nama = 'bogiant R';
    var post_alamat = 'bogor';
    //var obj =[];
	 $.ajax({
    url : 'http://10.11.12.93/dashboard-sd/board/index.php/admin/dashboard/lemparan_ajax',
    method : "POST",
    data : {usia: post_usia,
    		nama : post_nama,
            alamat : post_alamat},
    dataType : 'json',
    success: function(data){
        //var obj =JSON.parse(data);
                console.log(data);

    	//console.log(obj);
    	// alert(data.nama);
    	document.getElementById("nama").innerHTML =data.nama;
    	document.getElementById("usia").innerHTML =data.usia;
        document.getElementById('alamat').innerHTML = data.alamat;



    }
});	 
    </script>