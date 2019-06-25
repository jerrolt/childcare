<template>
<div class="container-fluid">





	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
			<div class="row">
				<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
					<h2 id="PageHeader">Student Attendance</h2>
				</div>
			</div>
		</div>
	</div>






	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
				
			<!-- Edit Timecard -->
			<div class="panel panel-default" id="timecard-form" v-show="timecardForm">
				<div class="panel-heading">
					<h4>Update Student Timecard</h4>
					<b>Student:</b> {{sname}}
					&nbsp;&nbsp;
					<b>Date:</b> {{sdate | formatDate}}
					&nbsp;&nbsp;
					<b>Activity:</b> {{saction}}
				</div>
				<div class="panel-body">
					<form @submit.prevent="saveTimecard">
						<fieldset>		
							<div class="row" style="margin-bottom:0px;">
								<div class="form-group col-md-4 col-sm-4 col-xs-4">                	
				                	<label class="control-label" for="edit-time">Time:</label>
									<input id="edit-time" v-model="stime"  type="time" class="form-control" size="10" style="width:auto;" required>	
				                </div>          
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label" for="edit-guardian">Guardian</label>	                        
							        <div  :class="{'has-error': errors && errors.primary}">
				                    	<select class="form-control" v-model="timecard.guardian_id">
				                    		<option v-for="(guardian in guardians" :value="guardian.id">
				                    		{{guardian.lastname}}, {{guardian.firstname}} {{guardian.mi}}
				                    		</option>
										</select>
							            <span v-if="errors && errors.primary" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.primary[0] }}</span>
							        </div>
								</div>											
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label" for="edit-facility">Facility</label>	                        
								    <div  :class="{'has-error': errors && errors.facility}">
								        <select class="form-control" v-model="timecard.facility_id">
								            <option v-for="(facility in facilities" :value="facility.id">{{facility.name}}</option>
										</select>
								        <span v-if="errors && errors.facility" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.facility[0] }}</span>
								    </div>
								</div>						
							</div>						
							<div class="row">
				            	<div class="form-group col-md-12 col-sm-12 text-right">			                    
				                    <button type="button" class="btn btn-danger btn-sm" @click="onCancel">
				                    	<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
										Cancel
				                    </button>
				                    <button type="submit" class="btn btn-primary btn-sm">
				                    	<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
										Save
				                    </button>			                    
								</div>
							</div>
						</fieldset>
					</form>
				</div>			            
			</div>
	
		
			<!-- Search FORM -->
			<div class="panel panel-default" id="search-form" v-show="searchForm">
				<div class="panel-heading">
					<h4>Search Records</h4>
				</div>
				<div class="panel-body">
					<form @submit.prevent="loadTimecards">
						<fieldset>												                  
						    <div class="row" style="margin-bottom:0px;">                	
								<div class="form-group col-md-3 col-sm-3 col-xs-4 text-left">
									<label class="control-label">Select Students:</label>
									<select v-model="searchStudents" class="form-control" size="10" multiple>
										<option v-for="student in students" :id="'student_'+student.id" v-bind:value="student.id">
										{{student.firstname}} {{student.mi}} {{student.lastname}}
										</option>
									</select>						
								</div> 
								<div class="form-group col-md-3 col-sm-3 col-xs-4">             
						            <label class="control-label">Date From:</label>									
									<input id="date-from" v-model.lazy="dateFrom" type="date" class="form-control" style="width:auto;">
									
						        </div>               	
						        <div class="form-group col-md-3 col-sm-3 col-xs-4">
						            <label class="control-label">Date To:</label>						            
									<input id="date-to" v-model.lazy="dateTo" type="date" class="form-control" style="width:auto;">
								</div>               
						    </div>
						    <div class="row">
						        <div class="form-group col-md-12 col-sm-12 text-right">   
						            <button type="submit" class="btn btn-primary btn-sm">
						                <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
										Search Records
						            </button>			                    
								</div>
							</div>
						</fieldset>
					</form>
				</div>			            
			</div>
			<!-- END Search FORM -->
			
		</div>
	</div>






	<div class="row">
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">

			<!-- table-list of Student Timecards -->
			<div class="panel panel-body" v-show="timecardResults">
				<table class="table table-condensed">
					<thead>
						<tr>			
							<td colspan="2">
								<span class="btn btn-default btn-lg">
								Total Time: <small class="badge">{{total}}</small>
								</span>
							</td>
							<td colspan="4" id="download_links">
								
							</td>
						</tr>		
						<tr>
							<th>Child</th>
							<th>Facility</th>
							<th>Date</th>			
							<th>Drop Off</th>
							<th>Pick Up</th>
							<th>Total</th>
							
						</tr>
					</thead>
					<tbody>
						<tr v-for="block in blocks">
							<td>
								{{block.student.firstname}} {{block.student.lastname}}<br/>
								<small class="badge" style="font-size:6pt;background:#bf5329;">
									<span v-if="block.student.special_code!=null">{{block.student.special_code}}</span>
								</small>
							</td>
							<td>{{block.checkin.facility_name}}</td>
							<td>{{block.checkin.action_at | formatDate}}</td>			
							<td style="padding-left:0;">
								<a class="btn btn-link btn-xs " @click.prevent="editTimecard(block.checkin)">
									<span class="glyphicon glyphicon-pencil" />
									{{block.checkin.action_at | formatTime}}
								</a>
								<br/>
								<a class="btn btn-link btn-xs" @click.prevent="editTimecard(block.checkin)">
									<span class="glyphicon glyphicon-pencil" />
									{{block.checkin.guardian_name}}
								</a>
							</td>			
							<td style="padding-left:0;">
								<a v-if="block.checkout!=null" class="btn btn-link btn-xs" @click.prevent="editTimecard(block.checkout)">
									<span class="glyphicon glyphicon-pencil" />
									{{block.checkout.action_at | formatTime}}
								</a>				
								<br/>
								<a v-if="block.checkout!=null" class="btn btn-link btn-xs" @click.prevent="editTimecard(block.checkout)">
									<span class="glyphicon glyphicon-pencil" />
									{{block.checkout.guardian_name}}
								</a>
							</td>			
							<td><span class="badge">{{block.time}}</span></td>			
							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>





	<!-- #daily-summary-pdfs (PDF Downloads) -->	
	<div id="daily-summary-pdfs" class="row" v-show="dailySummary">
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Daily Summary Reports</h4>
				</div>
				<div class="panel-body">				
					<a v-for="pdf in links" 
					   v-bind:href="'/summary-pdf/'+ pdf.student.id + '/' +pdf.checkin.action_at.split(' ')[0] + '/' +  pdf.checkin.action_at.split(' ')[0]" 
					   class="clearfix"
					   target="_blank"
					>				
					{{pdf.student.firstname}}<span v-if="pdf.student.mi!=null"> {{pdf.student.mi}}</span> {{pdf.student.lastname}}:&nbsp;{{pdf.checkin.action_at.split(' ')[0]}} (PDF)<br/>					
					</a>
				</div>
			</div>
		
		</div>		            
	</div>
	

	


	<!-- #daily-absentee-pdfs -->
	<div id="daily-absentee-pdfs" class="row" v-show="dailyAbsentee">
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Daily Absentee Reports</h4>
				</div>
				<div class="panel-body">
					<a v-for="day in report_days" 
					   v-bind:href="'/absentee-pdf/' + day" 
					   class="clearfix"
					   target="_blank"
					>				
					{{day}} Absentee Report(PDF)					
					</a>
				</div>
			</div>
		</div>		            
	</div>
	
	
	
	
	
	
	
	
	<!-- #daily-attendance-pdfs 
	<div id="daily-attendance-pdfs" class="row" v-show="dailyAttendance">
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">		
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Daily Attendance Reports</h4>
				</div>
				<div class="panel-body">
					<a v-for="day in report_days" 
					   v-bind:href="'/attendance-pdf/' + day" 
					   class="clearfix"
					   target="_blank"
					>				
					{{day}} Attendance Report(PDF)					
					</a>				
				</div>
			</div>		
		</div>		            
	</div>		
	-->
	
	<!-- #daily-attendance-pdfs -->
	<div id="daily-attendance-pdfs" class="row" v-show="dailyAttendance">
		<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">		
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Daily Attendance Reports</h4>
				</div>
				<div class="panel-body">
					<a v-for="day in attendance_days" 
					   v-bind:href="'/attendance-pdf/' + day" 
					   class="clearfix"
					   target="_blank"
					>				
					{{day}} Attendance Report(PDF)					
					</a>				
				</div>
			</div>		
		</div>		            
	</div>
		
	
	
	
	
	
</div> 
</template>


<script>
export default {
    name: 'activityadmin',
    props:['user_id','start','end'],
    mounted() {
    },
    data() {
    	return {
        	searchForm: true,
        	timecardForm:false,
        	
        	timecardResults: false,
        	
        	dailySummary: false,
        	dailyAttendance: true,
        	dailyAbsentee: true,
        	
        	
        	errors: [],
        	
        	sname:'',
        	sdate:'',
        	stime:'',
        	saction:'',
        	
        	students: [],
        	facilities: [],
        	guardians:[],
        	
        	searchStudents: [],
        	dateFrom: '',
        	dateTo: '',
        	       	
        	blocks: [],

        	timecards: [],
        	timecard:{
	        	id:'',
	        	student_id:'',	        	
	        	facility_id:'',
	        	guardian_id:'',	        	
	        	action_at:'',
	        	is_checkin:'',
	        	is_checkout:'',
	        	notes:''
        	},
        	total:0,
        	links:[],
        	
        	report_days:[],
        	
        	attendance_days:[]
        };
    },


	    
    created() {	   
	    $.get(`/api/timecard/sync-all`, opts => {
		    this.loadTimecards();		    		    		    
		});
	    
        this.loadStudents();  	
        this.resetTimecard();
        this.loadFacilities();
        this.dateFrom=this.start;
        this.dateTo=this.end;      		        	    				
    }, 
	    	
	filters: {
		formatDate: function(d){
			return moment(d).format('MM/D/YYYY');
		},
		
		formatTime: function(t){
			return moment(t).format('h:mm A');
		}
		
	},    	    
    methods: {
	    loadStudents() {
		    $.get(`/api/student/options`, student => {
				this.students = student.data;
			});
	    },
	    
	    
	    
	    /** create PDF file links **/
		createPdfLinks() {	
			var last = '';
			this.links = [];	
			for(var i=0; i<this.blocks.length; i++)
			{
				if(i==0)
				{
					this.links.push(this.blocks[i]);
					last=this.blocks[i];
					continue;
				}
				//was the timecard.action_at(date) already generated?
				if(this.blocks[i].checkin.action_at.split(' ')[0] != last.checkin.action_at.split(' ')[0] || this.blocks[i].student.id!=last.student.id)
				{
					this.links.push(this.blocks[i]);
					last=this.blocks[i];
				}
			}	
							
			if(this.links.length>0)	
			{	    
		    	this.dailySummary=true;   
		    }
		},
	    
	    
	    
	    createAbsenteeLinks(from, to) {		
		    
		    /** IF GUARDIAN only get logged_in guardian.students - 
		     	IF ADMIN get all students 
		     **/    
		    $.get(`/api/student/get_days_included/${from}/${to}`, data => {
				this.report_days = data.days;
			});			
	    },
	    
	    
	    
	    
	    
	    
	    
	    createAttendanceLinks(from,to) {
		    var vm = this;
		    var mdays = [];
		    console.log(`/api/student/get_days_included/${from}/${to}`);
		    $.get(`/api/student/get_days_included/${from}/${to}`, data => {
				//this.report_days=data.days;
				mdays=data.days;
				console.log("days included: ");
				console.log(mdays);
			}).then(function(){
				 $.get(`/get-attendance-pdf-count/${from}/${to}`, data => {			    
				    for(var i=0;i<mdays.length;i++)
				    {
					    for(var y=0;y<data.length;y++)
					    {
						    if(mdays[i]==data[y].day)
								vm.attendance_days.push(mdays[i]);
					    }				   
				    }
				    console.log(vm.attendance_days);	
				    if(vm.attendance_days.length==0)
				    {
					    vm.dailyAttendance = false;
				    }
				    else
				    {
					    vm.dailyAttendance = true;
				    }			
				});
			});					    		   
	    },
	    
	    
	    
	    
	    
	    
	    
	    
	    loadTimecards() {	
			this.timecardResults=true;
			this.searchForm=true;
			
			var params = {
				students: this.searchStudents,
				from: this.dateFrom,
				to: this.dateTo
			}
						
			var searchRequest = {
				type: 'POST',
			    url: '/api/timecards/block_report',
			    contentType: 'application/json',
			    data: JSON.stringify(params)
			};
			
			$.ajax(searchRequest).done(response => {			    
			    this.blocks=response.blocks;
			    this.total = response.total;
			    
			    //load PDF Links
			    this.createPdfLinks();
			    
			    //new 
			    this.createAbsenteeLinks(this.dateFrom, this.dateTo);
			    
			    //NEW 
			    this.createAttendanceLinks(this.dateFrom, this.dateTo);
			    
			    
			}).fail(function (msg) {
			    console.log(msg);
			}).always(msg => {});								
	    },
		
		
		
		 
		
		resetTimecard() {
			this.timecard = {
	        	id:'',
	        	student_id:'',	        	
	        	facility_id:'',
	        	guardian_id:'',	        	
	        	action_at:'',
	        	is_checkin:'',
	        	is_checkout:'',
	        	notes:''
        	};
        	//this.total = 0;
		},
		
		
		/*
		onCancel() {
		    this.searchForm = false;
	    },
	    */
	    
	    
	    scrollTo(pos) {
        	$('html,body,.container').animate({
	        	scrollTop: $(pos).offset().top
			},'slow');
		},
	    onCancel(){
		    this.timecardForm = false;
		    this.resetTimecard();
		    this.guardians=[];
			//this.loadTimecards();
	    },
	    
	    
	    
	    //Timecard Update
	    editTimecard(timecard){
		    this.scrollTo('#timecard-form');
		    this.resetTimecard();
		    this.loadGuardians(timecard.student_id);
		    this.timecard = timecard;
		    
		    this.timecard.timecard_id = timecard.id;
		    this.timecardForm=true;
		    
		    this.sname = timecard.student.firstname + " " + timecard.student.lastname;
		    this.sdate = timecard.action_at.split(' ')[0];		    
		    this.stime = (timecard.action_at.split(' ')[1]).split(':')[0] + ":" + (timecard.action_at.split(' ')[1]).split(':')[1];
		    		    
			if(timecard.is_checkin==1){
				this.saction = 'Check In';
			}else if(timecard.is_checkout){
				this.saction = 'Check Out';
			}else{
				this.saction = 'Other Activity';
			}
	    },
	    
	    
	    saveTimecard(){
		    var changes = {
			    'timecard_id': this.timecard.id,
			    'action_at': this.sdate + " " + this.stime + ":00",
			    'guardian_id': this.timecard.guardian_id,
			    'facility_id': this.timecard.facility_id,
			    'user_id': this.user_id
		    }
		    console.log(changes);
		    
			$.ajax({
		        url: '/api/timecard',
		        type: 'PUT',
		        data: JSON.stringify(changes),
		        headers: {
					'content-type': 'application/json',
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		        },
		        success: data => {
                	console.log(data);
                	this.resetTimecard();
                	this.loadTimecards();
                	this.timecardForm=false;
				},
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
		    });		    
		    
	    },
	    
	    
	    loadFacilities(){
		    $.get(`/api/facilities/options`, facility => {
				this.facilities = facility.data;
			});
	    },
	    loadGuardians(student_id){
		    $.get(`/api/student/${student_id}`, student => {
				this.guardians = student.data.guardians;
			});
	    }
	    	    
	    
	} //end methods
}
</script>