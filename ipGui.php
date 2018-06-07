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
				height:1000px;
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

			  function addFields(){
            // Number of inputs to create
            var number = document.getElementById("camera").value;
            // Container <div> where dynamic content will be placed
            var container = document.getElementById("container");
            // Clear previous contents of the container
           
            for (i=0;i<number;i++){
                // Append a node with a random text
                container.appendChild(document.createTextNode("CAMERA" + (i+1)+":"));
                // Create an <input> element, set its type and name attributes
                var input = document.createElement("input");
                input.type = "text";
                input.name = "ip" + i;
                input.id="IP" +i;
                input.placeholder="eg. xxx.xxx.xxx.xxx";
                container.appendChild(input);
                // Append a line break 
                container.appendChild(document.createElement("br"));
            }
        }
			  
		</script>

	</head>

	<body>
		
    	<a href="#" id="filldetails" onclick="addFields()">add camera</a>
		<form action="ip_changer.php" method=post id="form">
			
			<div id="container"/>
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
			<input type="text" id="camera" name="camera" value="">Number of camera<br />
			
			<div id="container"/>

			<p><button>submit</button>
		</form>

		<button id="set-defaults" onclick="setdefaults()">setdefaults</button>
		<script> 
			
			function setdefaults(){
				//document.getElementById("newip").value="192.168.0.221";
				document.getElementById("defaults").value=6000;
				document.getElementById("fre").value=403000;
				document.getElementById("mod").value=4;
				document.getElementById("fec").value="1/2";
				document.getElementById("gi").value="1/32"
				document.getElementById("gain").value=-2;

			}
			document.addEventListener('contextmenu', event => event.preventDefault());
			
			




		</script>
	</body>
</html>
