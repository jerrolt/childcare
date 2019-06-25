<html>
	<head>
		<title>{{$facility}} - Absentee Report</title>
		<style>
			div#main_heading{
				background: #eeeeee;
				padding: 10px;
			}
			table tr th{
				padding:10px; 
				border-top:1px solid black;
				border-right:1px solid black;
				border-bottom:1px solid black;
			}
			table tr td{
				padding:10px; 
				border-right:1px solid black;
				border-bottom:1px solid black;
				
				vertical-align:text-top;
			}
			p small{
				padding:8px;
				border: none;
			}
			p b{
				padding:8px;
			}
		</style>
	</head>
	<body>
		<div id="main_heading">
			<h3>Absentee Report<?php if($facility):?> - {{$facility}}<?php endif; ?></h3>			
			<h4>{{$date}}</h4>
		</div>
		
		<table style="min-width:100%;">
		  <thead>
		    <tr>
		      <th style="border-left:1px solid black;">Absentee List</th>
		      <th style="border-left:1px solid black;">Attendance List</th>
		      <th style="border-left:1px solid black;">Active Children</th>
		    </tr>
		  </thead>
		  <tbody>
		  
		  	
		      <tr>
		        <td style="border-left:1px solid black;">
			        <ol>
			        <?php foreach($absent as $a): ?>
			        	<li>{{$a}}</li>
			        <?php endforeach; ?>	
			        </ol>		             
			    </td>		        
				<td	style="border-left:1px solid black;">
					<ol>
					<?php foreach($present as $p): ?>
			        	<li>{{$p}}</li>
			        <?php endforeach; ?>	
			        </ol>		             
			    </td>
			    <td	style="border-left:1px solid black;">
				    <ol>
			    	<?php foreach($active as $c): ?>
			        	<li>{{$c}}</li>
			        <?php endforeach; ?>
			        </ol>		             
			    </td>       
		      </tr>		      

		  </tbody>		  	
		</table>
	</body>
</html>



