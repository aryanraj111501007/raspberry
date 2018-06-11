<?php
	session_start();
	$val=$_SESSION['visited'];
	if($val==1)
	{
		echo "your form has been submitted.click on reboot";
		session_unset();
	}
	else{
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

	}
	
?>


<html>
	<head>
		<meta charset="utf-8">
		
		<script src="knockout-3.0.0.debug.js" type="text/javascript"></script>
			


		<style>

			
			body{
				background-color: #41f4dc;
				opacity:0.9;
				z-index: 0;
			}
			#form{
				height:700px;
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
             while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
           
            for (i=0;i<number;i++){
                // Append a node with a random text
                container.appendChild(document.createTextNode("CAMERA" + (i+1)+":"));
                // Create an <input> element, set its type and name attributes
                var input = document.createElement("input");
                input.type = "text";
                input.name = "ip" + i;
                input.id="IP" +i;
                input.addEventListener('change', function(e) {
  					do_ping(this);
			}, false);
                input.placeholder="eg. xxx.xxx.xxx.xxx";
                container.appendChild(input);
                // Append a line break 
                container.appendChild(document.createElement("br"));
            }
        }
			  
		</script>


		<script>
    



				function ping(ip, callback) {

				    if (!this.inUse) {
				        this.status = 'unchecked';
				        this.inUse = true;
				        this.callback = callback;
				        this.ip = ip;
				        var _that = this;
				        this.img = new Image();
				        this.img.onload = function () {
				            _that.inUse = false;
				            _that.callback('responded');

				        };
				        this.img.onerror = function (e) {
				            if (_that.inUse) {
				                _that.inUse = false;
				                _that.callback('responded', e);
				            }

				        };
				        this.start = new Date().getTime();
				        this.img.src = "http://" + ip;
				        this.timer = setTimeout(function () {
				            if (_that.inUse) {
				                _that.inUse = false;
				                _that.callback('timeout');
				            }
				        }, 1500);
				    }
				 }


				function do_ping(input)
				{

					



				  ko.cleanNode(document.body);

				  var PingModel = function (servers) {
				    var self = this;
				    var myServers = [];
				    ko.utils.arrayForEach(servers, function (location) {
				        myServers.push({
				            name: location,
				            status: ko.observable('unchecked')
				        });
				    });
				    self.servers = ko.observableArray(myServers);
				    ko.utils.arrayForEach(self.servers(), function (s) {
				        s.status('checking');
				        new ping(s.name, function (status, e) {
				            s.status(status);
				        });
				    });
				};

					url=input.value;
					var komodel = new PingModel([url]);
					
				    ko.applyBindings(komodel);
				        

				     
				}


    
	</script>



	</head>

	<body>
		
		<ul data-bind="foreach:servers">
    <li> <a href="#" data-bind="text:name,attr:{href: 'http://'+name}">tester</a> <span data-bind="text:status,css:status"></span>

    </li>
	</ul>
		
    	
		<form action="ip_changer.php" method=post id="form">
			<p>No of camera:<input type="number" id="camera" onchange="addFields()" name="camera" min=0 value=0></p>
			
			<div id="container"></div>
			<p> Frequency :<input type="number" id="fre" value=403000 onchange="handleChange(this);" name='frequency' min="393000" max="450000" />

			<p>Bandwidth :<select id="defaults" name='bandwidth'>
								<option value=2000>2000</option>
								<option value=6000 selected="">6000</option>
								<option value=8000>8000</option>
						</select></p>
			<p>Modulation :<select id="mod" name="modulation">
								<option value=4 selected>QPSK</option>
								<option value=16>QAM16</option>
								<option value=32>QAM32</option>
						  </select>

			</p>				
			<p>FEC : <select id="fec" name="FEC">
								<option value="1/2" selected>1/2</option>
								<option value="2/3">2/3</option>
								<option value="3/4">3/4</option>
								<option value="5/6">5/6</option>
								<option value="7/8">7/8</option>
					 </select></p>
			<p>G.I. : <select id="gi" name="GI">
								<option value="1/16">1/16</option>
								<option value="1/32" selected>1/32</option>
								<option value="1/8">1/8</option>
								<option value="1/4">1/4</option>
					 </select></p>

			<p> Gain :<input type="number" value=-2 id="gain" name="Gain" min=-15 max=0></p>
			<p>NO OF SUB_CARRIERS : <select id="carrier" name="carrier">
								<option value=8>8k</option>
								<option value=2>2k</option>
								
					 </select></p>
			
			

			<p><button>submit</button></p>
		</form>



		<button id="set-defaults" onclick="setdefaults()">setdefaults</button>

		<form action='restart.php' method='post'>
			<button>reboot</button>
		</form>
		<script> 
			
			function setdefaults(){
				//document.getElementById("newip").value="192.168.0.221";
				document.getElementById("defaults").value=6000;
				document.getElementById("fre").value=403000;
				document.getElementById("mod").value=4;
				document.getElementById("fec").value="1/2";
				document.getElementById("gi").value="1/32"
				document.getElementById("gain").value=-2;
				document.getElementById("gain").value=8;

			}
			
			
			




		</script>
		
		<script type="text/javascript">
				var count;
				var nesne ;
				if(navigator.appName.search('Microsoft')>-1) { nesne = new ActiveXObject('MSXML2.XMLHTTP'); }
				else { nesne = new XMLHttpRequest(); }

				function yolla() {
				nesne.open('get', 'ar.txt', true); 
				nesne.onreadystatechange= cevap;
				nesne.send(null);
				}

				function cevap() {
				if(nesne.readyState==4) {


				var strRawContents = nesne.responseText;

				var arrLines = strRawContents.split("\n");
				//alert(arrLines.length);
				//alert("raj");
				for (var i = 0; i < arrLines.length; i++) {
			    	if (i==0)
			    	{
			    		
			    		count = parseInt(arrLines[i]);
			    			 

			    	}

			    	if (i<=count)
			    	{
			    		continue;
			    	}
			    	//alert(i);
			    	var curLine = arrLines[i];
			    	if (i==count+1)
			    	{
			    		//alert(i);
			    		document.getElementById("fre").value=curLine;
			    	}
			    	if (i==count+2)
			    	{
			    		//alert(i);
			    		document.getElementById("defaults").value=curLine;
			    	}
			    	if (i==count+3)
			    	{
			    		//alert("wow");
			    		document.getElementById("mod").value=curLine;
			    	}
			    	if (i==count+4)
			    	{
			    		//alert(i);
			    		document.getElementById("fec").value=curLine;
			    	}
			    	if (i==count+5)
			    	{
			    		//alert(i);
			    		document.getElementById("gi").value=curLine;
			    	}
			    	if (i==count+6)
			    	{
			    		//alert(i);
			    		document.getElementById("gain").value=curLine;
			    		//break;
			    	}
			    	if (i==count+7)
			    	{
			    		//alert(i);
			    		document.getElementById("carrier").value=curLine;
			    		break;
			    	}
				}


			}
		}
		yolla();

		</script>

	</body>
</html>
