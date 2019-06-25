<html>
	<head>
		<title>{{$student->firstname}} {{$student->lastname}} - ID Badge</title>
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
		


	    <div id="app">
	        <nav class="navbar navbar-default navbar-static-top">
	            <div class="container">

		
		
			        <div class="row" >
						<div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="border: thin solid #636b6f;max-width:380px; max-height:240px;width:380px;height:240px;border-radius:10px;">
						  
						  <div class="row text-center" style="border-bottom:thin solid black;text-align:center;">
						  	<h3>{{$student->firstname}} {{$student->lastname}}</h3>
						  </div>
						  <div class="row" style="color:#636b6f;">
							  <table>
								  <tr>
									  <td style="border:none;">
										@if($student->image != null)
							          		<img src="images/students/thumb_{{$student->image}}" class="img-thumbnail">
							          	@else
						          			<img src="images/students/no_img_thumb.jpg" class="img-thumbnail">
								  		@endif
								  		<br/>
								  		<span v-if="stud.special_code!=null">{{$student->special_code}}</span>
									  </td>
									  <td style="border:none;">
										  <b>Guardian:</b> {{$student->primary_guardian->firstname}} {{$student->primary_guardian->lastname}}									<br/>
										  <b>Special Needs:</b> {{$student->special_needs}}
									  </td>
								  </tr>
							  </table>
						  </div>
						  <!--
						  <div class="row" style="color:#636b6f;">
				          	<div class="col-lg-2 col-md-2 col-sm-2" style="padding:5px;clear:none;">
					          	@if($student->image != null)
					          		<img src="images/students/thumb_{{$student->image}}" class="img-thumbnail">
					          	@else
				          			<img src="images/students/no_img_thumb.jpg" class="img-thumbnail">
						  		@endif
						  		<br/>
						  		<span v-if="stud.special_code!=null">{{$student->special_code}}</span>
				          	</div>
						  	<div class="col-lg-8 col-md-8 col-sm-8" >							  	
								<b>Guardian:</b> {{$student->primary_guardian->firstname}} {{$student->primary_guardian->lastname}}									<br/>
								<b>Special Needs:</b> {{$student->special_needs}}							  	
						  	</div>
						  </div> 
						 -->
						</div>
					</div>		
		
		
		
	            </div>
	        </nav>
	    </div>
		
	</body>
</html>