<!DOCTYPE html>
<html>
<head>
	<title>Grafik Dengan HTML</title>
	<script src="asset/Chart.bundle.js"></script>
	<script src="asset/utils.js"></script>
</head>
<body>
		<?php  
			mysql_connect("localhost","root", "");
			mysql_select_db("test-grafik");
		?>
		<table border="1">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama</th>
					<th>Kondisi</th>
				</tr>
			</thead>
			<?php 
			$data = mysql_query("SELECT * FROM barang");
			$no = 1;
			while ($barang = mysql_fetch_array($data)) {
			?>
			<tbody>
				<tr>
					<td><?php echo $no++;?></td>
					<td><?php echo $barang['nama']?></td>
					<td><?php echo $barang['kondisi']?></td>
				</tr>
			</tbody>
			<?php } ?>
		</table>
<?php 
$data = mysql_query("SELECT count(kondisi) AS kon_baik FROM barang WHERE kondisi ='Baik'");
		while ($kon = mysql_fetch_array($data)) {
			echo "<h1> Kondisi Baik : ".$kon['kon_baik']." Unit</h1>";
		}
?>
<?php 
$data = mysql_query("SELECT count(kondisi) AS kon_rusak FROM barang WHERE kondisi ='Rusak'");
		while ($kon = mysql_fetch_array($data)) {
			echo "<h1> Kondisi Rusak : ".$kon['kon_rusak']." Unit</h1>";
		}
?>


<h1>Grafik</h1>
<div id="canvas-holder" style="width:20%">
		<canvas id="chart-area"></canvas>
	</div>
	<script>

		<?php 
			// query untuk menampilkkan jumlah barang kondisi baik
			$data = mysql_query("SELECT count(kondisi) AS kon_baik FROM barang WHERE kondisi ='Baik'");
				while ($kon = mysql_fetch_array($data)) {
				$baik = $kon['kon_baik'];
				}
			// query untuk menampilkkan jumlah barang kondisi rusak
			$data = mysql_query("SELECT count(kondisi) AS kon_rusak FROM barang WHERE kondisi ='Rusak'");
				while ($kon = mysql_fetch_array($data)) {
				$rusak = $kon['kon_rusak'];
				}
		?>
		var dataBaik = <?php echo $baik;?>;
		var dataRusak = <?php echo $rusak;?>;

		var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
					// pemanggilan variabel untuk menampilkan jumlah data pada grafik
						dataBaik,
						dataRusak
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.green,
					],
					label: 'Kondisi Barang'
				}],
				labels: [
				//tambah label pada cart
					<?php
					$data = mysql_query("SELECT kondisi FROM barang GROUP BY kondisi");
						while ($kon = mysql_fetch_array($data)) {
					?>
					'<?php echo $kon['kondisi'];?>',
					<?php
						}
					?>
				]
			},
			options: {
				responsive: true
			}
		};

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};

	</script>
</body>
</html>