<template>
	<div class="container">

		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
				<h2 id="PageHeader">Guardian Attendance Records</h2>
			</div>
		</div>

		<!-- Search FORM -->
		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
				<div class="panel panel-default" id="search-form" v-show="searchForm">
					<div class="panel-body">
						<form @submit.prevent="loadBlocks">
							<fieldset>												                  
				                <div class="row" style="margin-bottom:0px;">                	
									<div class="form-group col-md-3 col-sm-3 col-xs-4 text-left">
										<label class="control-label">Select Students:</label>						
										<select v-model="students" class="form-control" multiple>
											<option v-for="student in studentOptions" :id="'student_'+student.id" v-bind:value="student.id">
												{{student.firstname}} {{student.mi}} {{student.lastname}}
											</option>
										</select>						
									</div> 									
									<div class="form-group col-md-3 col-sm-3 col-xs-4">                	
				                		<label class="control-label">Date From:</label>
										<input v-model.lazy="dateFrom" type="date" class="form-control">	
				                	</div>               	
				                	<div class="form-group col-md-3 col-sm-3 col-xs-4">
				                		<label class="control-label">Date To:</label>
										<input v-model.lazy="dateTo" type="date" class="form-control">
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
			</div>
		</div>
		<!-- END Search FORM -->
		



		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
				<div class="panel panel-body" v-show="searchResults">
					<table class="table table-condensed">
						<thead>
					<tr>			
						<td colspan="2">
							<span class="btn btn-default btn-lg">
							Total Time: <small class="badge">{{total}}</small>
							</span>
						</td>
						<td colspan="4"></td>
					</tr>
							<tr>
								<th>Child</th>
								<th>Date</th>			
								<th>Drop Off</th>
								<th>Pick Up</th>
								<th>Total</th>
								<th>Facility</th>
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
								<td>{{block.checkin.action_at | formatDate}}</td>			
								<td>
									{{block.checkin.action_at | formatTime}}
									<br/>
									{{block.checkin.guardian_name}}
								</td>			
								<td v-if="block.checkout!=null">
									{{block.checkout.action_at | formatTime}}
									<br/>
									{{block.checkout.guardian_name}}
								</td>	
								<td v-else>
								n/a
								</td>	
								<td><span class="badge">{{block.time}}</span></td>	
								<td>{{block.checkin.facility_name}}</td>
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
	name: 'activityguardian',
    mounted() {
        $.get(`/api/timecard/sync/${this.guardian_id}`);
    },
    props:['guardian_id','start','end'],
	data(){
        return {
	        searchForm: true,
	        searchResults: true,
	        
	        blocks:[],
        	studentOptions:[],
        	
        	students:[],
        	dateFrom:'',
        	dateTo:'',
        	total:0,
        	
        	
        	
        	dailySummary: false,
        	dailyAttendance: true,
        	dailyAbsentee: true,
        	links:[],
        	report_days:[],
        	
        	attendance_days:[]
		};
	},
	
	created(){
		this.dateFrom = this.start;
		this.dateTo = this.end;
		$.get(`/api/guardian/${this.guardian_id}`, guardian => {			    
			this.studentOptions = guardian.data.students;
			for(var x=0; x<this.studentOptions.length; x++)
			{
				this.students.unshift(this.studentOptions[x].id);
			}
		}).then(this.loadBlocks);
	},
	
	filters: {
		formatDate: function(d){
			return moment(d).format('MM/D/YYYY');
		},
		
		formatTime: function(t){
			return moment(t).format('h:mm A');
		}		
	},	
	
	methods:{
		loadStudents() {
		    $.get(`/api/guardian/${this.guardian_id}`, guardian => {			    
				this.studentOptions = guardian.data.students;
			});
	    },
		loadBlocks() {	
			var params = {
				students: this.students,
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
				
				//if(response.constructor === Array)
				//{
					this.blocks=response.blocks;
					
					
					//this.total = this.blocks[0].total;
					
					
					
					this.total = response.total;
					
					
					//if(!isset(response[0].firstname))
					//{
					//	this.blocks=[];
					//}
						
				//}
				//else
				//{
				//	this.blocks=[];
				//	this.total = 0;
				//}			       
			    //this.total = this.blocks[0].total;
			    
			    
			    this.createPdfLinks();
			    this.createAbsenteeLinks(this.dateFrom, this.dateTo);    
			    this.createAttendanceLinks(this.dateFrom, this.dateTo);
			}).fail(function (msg) {
			    console.log(msg);
			}).always(msg => {});								
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
		    $.get(`/api/student/get_days_included/${from}/${to}`, data => {
				this.report_days = data.days;
				console.log(this.report_days);
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
	    }
	    
	    
	    
	}//end methods
}
</script>