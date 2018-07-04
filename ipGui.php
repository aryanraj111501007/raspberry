<?php
	session_start();
	// session will be started
	$val=$_SESSION['visited'];
	//value of session['visited'] will be taken in val which has been set in ip_changer page so that we dont have to login again when it commes back from ip_changer
	//we destroy the session
	//in ip_changer the value of session varaiables are set to 1
	session_destroy();
	if($val==1)
	{
		echo "your form has been submitted.click on reboot";
		session_unset();
	}
	else{
		$handle = fopen("hiddenfile.txt", "r") or die("couldn,t open\n"); //hiddenfile.txt contains username and password of the user
		$actual_username=fgets($handle); //we get actual username
		$actual_password=fgets($handle); //actual password
		$password=$_POST['passwd'];      //submitted password
		$username=$_POST['uname']."\n"; //submitted username
		
		
		
		if($actual_password!=$password || $actual_username!=$username)  //if username or password is not correct
		{
			echo "<a href='auth.html'>log in</a>";
			echo "<br";
			die ("wrong password or username");  //log in again
		}
		else {
			echo "welcome you are logged in";  //if usename and password is correct logged in
			$password="";   //set password to null

		}

	}
	
?>


<html>
	<head>
		<meta charset="utf-8">  <!-- utf-8 encoding.necessary if your browser doesn,t support html5 -->
		
		<script src="knockout-3.0.0.debug.js" type="text/javascript"></script> <!--knockout js has been included for pinging the url of camera -->
			


		<style>

			
			body{
				background-color: #41f4dc;
				opacity:1;
				z-index: 0;
			}
			#form{
				height:600px;
				width:500px;
				background-color: #42e5f4;
				z-index: 1;
				padding:10px;
				position:relative;
				float:left;
				margin:10px;
			}
			#set-defaults{
				text-align: center;
				position:relative;
				
				float:left;

			}
			#log-out{
				position:relative;
				float:right;
			}
	   </style>


		<script>
			  function handleChange(input) {
			  	//this function sets the frequency to its maximum if input value ig greater than maximum and min if less than minimum
			    if (input.value < 393000) input.value = 393000;
			    if (input.value > 450000) input.value = 450000;
			  }


			function addFields(){
            // this function is to add the number of fields dynamicallly.basically it is for the number of camera
            var number = document.getElementById("camera").value; //here in number we store the value of camera given by user
            if (number>6)  // if input number is greater than 6.the value set will be 6 only
            {
            	document.getElementById("camera").value=6;
            	number=6; //set the number to be 6
            }
            if(number<0)  //if user enters the negative entry ,it will set its value to 0
            {
            	document.getElementById("camera").value=0;
            	number=0;
            }


            // Container <div> where dynamic content will be placed
            var container = document.getElementById("container");  //container is the element where camera elements will be there
            // Clear previous contents of the container
             while (container.hasChildNodes()) {
                container.removeChild(container.lastChild);
            }
           
            for (i=0;i<number;i++){
                // Append a node with a random text
                container.appendChild(document.createTextNode("CAMERA" + (i+1)+":"));
                // Create an <input> element, set its type and name attributes
                var input = document.createElement("input");
                // setting all the attributes.
                input.type = "text";  
                input.name = "ip" + i; //name attribute for form filling
                input.id="IP" +i;
                input.addEventListener('change', function(e) {
  					do_ping(this);
			}, false);  //adding event listener to the camera elements
                input.placeholder="eg. xxx.xxx.xxx.xxx";//it is palaceholde for ip
                container.appendChild(input); //apend the child element
                // Append a line break 
                container.appendChild(document.createElement("br"));
            }
        }
			  
		</script>


		<script>
    



				function ping(ip, callback) {
					//this function pings the given url and if it is live it will show live and if not it will show timeout

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
				                _that.callback('timeout');      //in case it doesn,t respond in 1500 milliseconds,then time out will be shown in front of page
				            }
				        }, 1500);
				    }
				 }


				function do_ping(input)
				{

					

				//t	

				  ko.cleanNode(document.body);   //you need to clean all the previous bindings before you can apply new bindings there
				  //Taking function as object and using its variable
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
					url=url.split("/")[0];
					//splitting the url into ip and pass the ip into PingModel
					var komodel = new PingModel([url]);
					
				    ko.applyBindings(komodel); //apply all the bindings here.but since ko bindings can be applied only once.so be sure to remove this before getting it do
				        

				     
				}


    
	</script>



	</head>

	<body>
		<a id="log-out" href="logout.html" onclick="logout();">logout</a> <!--this is to logout the page -->
		
		<ul data-bind="foreach:servers">  <!--here we are binding the data which we will get as a result of pinging -->
     <a href="#" data-bind="text:name,attr:{href: 'http://'+name}"></a> <span data-bind="text:status,css:status"></span> <!--this is where data will be displayed and that url will be displayed as link -->

    
	</ul>
		
    	
		<form action="ip_changer.php" method=post id="form"> <!--this is main form where we get details of camera ,frequency -->
			<p>No of camera:<input type="number" id="camera" onchange="addFields()" name="camera" min=0 max=6 value=0></p>    <!--input element with number of camera .onchange event listener is attached to it....whenever it changes addfiels() function is called....however min value is 0 and maximumvalue can be 6 -->
			
			<div id="container"></div>   <!-- Here new elements will be appended as per number of camera-->
			<p> Frequency :<input type="number" id="fre" value=403000 onchange="handleChange(this);" name='frequency' min="393000" max="450000" /> <!--here again we have input element to have frequency having range between 393000 and 450000.and onchange listener handleChange is attached to this which ensures that it,s value does not cross the range -->

			<p>Bandwidth :<select id="defaults" name='bandwidth'>
								<option value=2000>2000</option>
								<option value=6000 selected="">6000</option>
								<option value=8000>8000</option>
						</select></p>     <!--this is select box which selects for the bandwidth -->
			<p>Modulation :<select id="mod" name="modulation">
								<option value=4 selected>QPSK</option>
								<option value=16>QAM16</option>
								<option value=32>QAM32</option>
						  </select></p>   <!--this is also select box and user can select any of these three modulation value  -->

							
			<p>FEC : <select id="fec" name="FEC">
								<option value="1/2" selected>1/2</option>
								<option value="2/3">2/3</option>
								<option value="3/4">3/4</option>
								<option value="5/6">5/6</option>
								<option value="7/8">7/8</option>
					 </select></p>   <!--this select dropdown box used for FEC  -->
			<p>G.I. : <select id="gi" name="GI">
								<option value="1/16">1/16</option>
								<option value="1/32" selected>1/32</option>
								<option value="1/8">1/8</option>
								<option value="1/4">1/4</option>
					 </select></p><!--this select dropdown box used for gi  -->

			<p> Gain :<input type="number" value=-2 id="gain" name="Gain" min=-15 max=0></p>  <!--this input element is for gain.with default value -2 and its value can varry from -15 to 0.  -->
			<p>SUB_CARRIERS : <select id="carrier" name="carrier">
								<option value=8 selected>8k</option>
								<option value=2>2k</option>
								
					 </select></p><!-- this is to select sub carriers whether 2k or 8k -->
			
			

			<p><button >submit</button></p>  <!--submit button  -->
		</form>



		<button id="set-defaults" onclick="setdefaults()">setdefaults</button>   <!-- this is button element with onclick listener attached.it is to setdefaults() value.in case the user messes up the thing..... -->

		<form action='restart.php' method='post'> <!--this is just a simple form which takes the control to the restart.php where reboot code gets executed..and server gets rebooted  -->
			<button>reboot</button>
		</form>
		<script> 
			
			function setdefaults(){
				//document.getElementById("newip").value="192.168.0.221";
				//this function is for setting the defaults...
				document.getElementById("defaults").value=6000;  	//bandwidth
				document.getElementById("fre").value=403000;       //frequency
				document.getElementById("mod").value=4;           //modulation
				document.getElementById("fec").value="1/2";		 //fec
				document.getElementById("gi").value="1/32"      //gi
				document.getElementById("gain").value=-2;      //gain  
				document.getElementById("carrier").value=8;   //carrier
				// default value of bandwidth is 6000,frequency is 403000,modulation is 4,fec is 1/2,gi is 1/32 ,gain is -2,carrier is 8k
			}
			
			
			




		</script>
		
		<script type="text/javascript">
			    //this script is for reading text file from the server .....actually all idea is to set the value of all fields which was set previously.
			    //however there are not any specific method to open file and read file
			    //so one intelligent way is to make XMLHttpRequest for the file and gets the file as response and do the processessing
				var count;
				var nesne ;
				if(navigator.appName.search('Microsoft')>-1) { nesne = new ActiveXObject('MSXML2.XMLHTTP'); }
				else { nesne = new XMLHttpRequest(); }

				function yolla() {
				nesne.open('get', 'ar.txt', true);    //ar.txt is the file in which we have the data set previously.it opens that
				nesne.onreadystatechange= cevap;    //cevap is the function to be executed when the readyState changes.
				nesne.send(null);                   // The XMLHttpRequest.send() method sends the request. If the request is asynchronous (which is the default), this method returns as soon as the request is sent. If the request is synchronous, this method doesn't return until the response has arrived. send() accepts an optional argument for the request body. If the request method is GET or HEAD, the argument is ignored and request body is set to null.



         
				}

				function cevap() {

						/*

						readyState 	Holds the status of the XMLHttpRequest.
						0: request not initialized
						1: server connection established
						2: request received
						3: processing request
						4: request finished and response is ready	

						*/
				if(nesne.readyState==4) {  //if request is finished and response is ready


				var strRawContents = nesne.responseText;    //storing response of XMLHttprequest in strRawContents .i.e strRawContents contain contents of file

				var arrLines = strRawContents.split("\n");   //splitting the contents of file by newline and sote it in arrLines as list
				//alert(arrLines.length);
				//alert("raj");
				for (var i = 0; i < arrLines.length; i++) {
			    	if (i==0)
			    	{
			    		//first line of file has no of camera which is stored in count
			    		count = parseInt(arrLines[i]);  //since it was string.we need to parse it as int
			    		document.getElementById("camera").value=count; //store it in camera input
			    		addFields();   //then we call addFields()...this creates as many camera input as the value of count
			    		continue;	 //then it continues the loop

			    	}

			    	if (i<=count)     
			    	{
			    		document.getElementById("IP"+(i-1)).value=arrLines[i]   //getting ip of coreesponding camera
			    	}
			    	//alert(i);
			    	var curLine = arrLines[i];  
			    	if (i==count+1)
			    	{
			    		//alert(i);
			    		document.getElementById("fre").value=curLine;  //restoring frequency value previously set 
			    	}
			    	if (i==count+2)
			    	{
			    		//alert(i);
			    		document.getElementById("defaults").value=curLine;   //restoring bandwidth value previously set 
			    	}
			    	if (i==count+3)
			    	{
			    		//alert("wow");
			    		document.getElementById("mod").value=curLine;     //restoring modulation value previously set 
			    	}
			    	if (i==count+4)
			    	{
			    		//alert(i);
			    		document.getElementById("fec").value=curLine;        //restoring fec value previously set 
			    	}
			    	if (i==count+5)
			    	{
			    		//alert(i);
			    		document.getElementById("gi").value=curLine;            //restoring gi value previously set 
			    	}
			    	if (i==count+6)
			    	{
			    		//alert(i);
			    		document.getElementById("gain").value=curLine;            //restoring gain value previously set 
			    		//break;
			    	}
			    	if (i==count+7)
			    	{
			    		//alert(i);
			    		document.getElementById("carrier").value=curLine;        //restoring sub_carriers value previously set 
			    		break;
			    	}
				}


			}
		}
		yolla();                 //calling the function yolla() to read the file and set all the required fields 

		</script>
		
		

	</body>
</html>      <!--HAPPY CODING-->
