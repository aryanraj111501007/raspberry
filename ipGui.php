<?php
	
	$handle = fopen("hiddenfile.txt", "r") or die("couldn,t open\n");
	$actual_username=fgets($handle);
	$actual_password=fgets($handle);
	$password=$_POST['passwd'];
	$username=$_POST['uname']."\n";
	
	
	
	if($actual_password!=$password || $actual_username!=$username)
	{
		echo "<a href='auth.html'>log in</a>";
		die ("wrong password or username");
	}
	else {
		echo "welcome you are logged in";
		$password="";

	}
?>


<html>
	<head>

		<style>
			body{
				background-color: #41f4dc;
				opacity:0.9;
				z-index: 0;
			}
			#form{
				height:500px;
				width:500px;
				background-color: #42e5f4;
				z-index: 1;
				padding:10px;
			}
	   </style>


		<script>
			  function handleChange(input) {
			    if (input.value < 393000) input.value = 393000;
			    if (input.value > 450000) input.value = 450000;
			  }
			  
		</script>

	</head>

	<body>
		<form action="ip_changer.php" method=post id="form">
			<p>NEW IP :<input type="text" name="ip" placeholder="eg. xxx.xxx.xxx.xxx"></p>
			<p> Frequency :<input type="number" id="fre" value=393050 onchange="handleChange(this);" name='frequency' min="393000" max="450000" />
			<p>Bandwidth :<select id="defaults" name='bandwidth'>
								<option value=2000 selected>2000</option>
								<option value=6000>6000</option>
								<option value=8000>8000</option>
						</select></p>
			<p>Modulation :<select id="mod" name="modulation">
								<option value=4>QPSK</option>
								<option value=16>QAM16</option>
								<option value=32>QAM32</option>
						  </select>

			</p>				
			<p>FEC : <select id="fec" name="FEC">
								<option value="1/2">1/2</option>
								<option value="2/3">2/3</option>
								<option value="3/4">3/4</option>
								<option value="5/6">5/6</option>
								<option value="7/8">7/8</option>
					 </select></p>
			<p>G.I. : <select id="gi" name="GI">
								<option value="1/16">1/16</option>
								<option value="1/32">1/32</option>
								<option value="1/8">1/8</option>
								<option value="1/4">1/4</option>
					 </select></p>

			<p> Gain :<input type="number" id="gain" name="Gain" min=-15 max=0></p>


			<p><button>submit</button>
		</form>

		<button id="set-defaults" onclick="setdefaults()">setdefaults</button>
		<script> 
			
			function setdefaults(){
				document.getElementById("defaults").value=2000;
				document.getElementById("fre").value=393050;
				document.getElementById("mod").value=16;
				document.getElementById("fec").value="2/3";
				document.getElementById("gain").value=-5;

			}
			




		</script>
	</body>
</html>
