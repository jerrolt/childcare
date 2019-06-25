<html>
	<head>
		<title>{{$nodes[0]['student']['firstname']}} {{$nodes[0]['student']['lastname']}} <?php echo date('M d, Y',time()); ?></title>
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
			<h3>Daily Summary - {{$nodes[0]['student']['facility']['name']}}
				<br/>
				{{$nodes[0]['student']['firstname']}} <?php if(strlen($nodes[0]['student']['mi'])):  echo $nodes[0]['student']['mi']; endif;?> {{$nodes[0]['student']['lastname']}} <?php if(strlen($nodes[0]['student']['special_code'])>0): echo "&nbsp;(<mark style='font-size: 10pt;'>".$nodes[0]['student']['special_code']."</mark>)"; endif; ?>
			</h3>			
			<h4><u>Classroom</u>: {{$nodes[0]['student']['classroom']['name']}}</h4>				
			<h4><?php echo date('D, M d, Y', strtotime($nodes[0]['checkin']['action_at']) ); ?></h4>			
		</div>
		
		<table style="min-width:100%;">
		  <thead>
		    <tr>
		      <th style="border-left:1px solid black;">Comments</th>
		      <th>Drop-Off</th>
		      <th>Pick-Up</th>
		      <th>Hours</th>
		    </tr>
		  </thead>
		  <tbody>
		  
		  	<?php foreach($nodes as $n): ?>
		      <tr>
		        <td style="border-left:1px solid black;">
			        <small>{{$n['student']['notes']}}</small>			        
			    </td>		        
		        <td>
			        <?php echo date('h:i A', strtotime($n['checkin']['action_at'])); ?><br/>
			        <super>&copy;</super>&nbsp;
			        <small><i>{{$n['checkin']['guardian_name']}}</i></small>
		        </td>		        
		        <td>
			        <?php if($n['checkout']!=null): ?>
				        <?php echo date('h:i A', strtotime($n['checkout']['action_at'])); ?><br/>
				        <super>&copy;</super>&nbsp;
				        <small><i>{{$n['checkout']['guardian_name']}}</i></small>
			        <?php endif; ?>
			    </td>		   
		        <td>{{$n['time']}}</td>
		      </tr>		      
			<?php endforeach; ?>
			<tr>
			    <td colspan='3' style='text-align:right;border-bottom:0;'><b>Daily Total</b></td>
			    <td><small>{{ $total }}</small></td>
		    </tr>
		  </tbody>		  	
		</table>
	</body>
</html>



