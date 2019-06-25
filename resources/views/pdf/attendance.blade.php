<html>
	<head>
		<title><?php echo date('M d, Y',time()); ?> Attendance Report</title>
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
			
			<h3>Attendance Report
				<?php if(count($blocks)>0): ?> - {{$blocks[0]['checkin']['facility_name']}}<?php endif; ?>
			</h3>			
			<h4>{{$date}}</h4>
		</div>
		
		<table style="min-width:100%;">
		  <thead>
		    <tr>
		      <th style="border-left:1px solid black;">Date</th>
		      <th>Child Name</th>
		      <th>Time In</th>
		      <th>Time Out</th>
		    </tr>
		  </thead>
		  <tbody>
		  
		  	<?php foreach($blocks as $b): ?>
		      <tr>
		        <td style="border-left:1px solid black;">
			        <?php echo date('M d, Y',strtotime($b['checkin']['action_at'])); ?>
			    </td>		        			        
		        <td>
		        	<?php echo $b['student']['lastname'].", ".$b['student']['firstname'].($b['student']['mi'] ? " ".$b['student']['mi']."." : '');?>
		        </td>			        
			    <td>
			        <?php echo date('M d, Y @h:i A',strtotime($b['checkin']['action_at'])); ?>
		        </td>
		        <td>
			        <?php echo date('M d, Y @h:i A',strtotime($b['checkout']['action_at'])); ?>
		        </td>
		      </tr>		      
			<?php endforeach; ?>			
		  </tbody>		  	
		</table>
	</body>
</html>
