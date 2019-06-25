<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                
                
                <!-- ACTIVITY LOG FORM PANEL -->
	            <div class="panel panel-default" id="timecard-form" v-show="displayForm">
					<div class="panel-heading">
						<h4>{{targetStudent}}</h4>
					</div>
					<div class="panel-body">
						
						<form @submit.prevent="saveTimecard">
							<fieldset>
								<div class="row" style="margin-bottom:0px;">
									
									<div class="form-group col-md-6 col-sm-6">
										<section>
											<label class="control-label">Activity:</label><br/>
											<span id="action-checkin">
												<input  type="radio" v-model="timecard.action" value="checkin" :checked="timecard.action=='checkin'" :disabled="status==1">&nbsp;check-in
											</span>
											&nbsp;
											<span id="action-confirm">
												<input  type="radio" v-model="timecard.action" value="confirm">&nbsp;confirm check-in
											</span>
											&nbsp;
											<span id="action-checkout">
												<input  type="radio" v-model="timecard.action" value="checkout" :disabled="status==0">&nbsp;check-out
											</span>											
										</section>
										
										
										
										<section>
											<label class="control-label" for="confirmed-at" v-show="timecard.action=='confirm'">Time:</label>
											<input id="action-at" v-model="timecard.action_at" type="time" class="form-control" size="10" style="width:auto;" v-show="timecard.action=='confirm'">				                 
										</section>
										
										
										
										
									</div>
										
										
										
											                    
									<div class="form-group col-md-6 col-sm-6">
										<section>                        
						            		<label class="control-label">Guardian:</label>						            	
											<select class="form-control" v-model="timecard.guardian_id">
												<option v-for="guardian in guardians" :value="guardian.id">{{guardian.lastname}}, {{guardian.firstname}}</option>
											</select>
										</section>
										
										<section>                        
						            		<label class="control-label">Facility/Location:</label>						            	
											<select class="form-control" v-model="timecard.facility_id">
												<option v-for="facility in facilities" :value="facility.id">{{facility.name}}</option>
											</select>
										</section>
									</div>
									
									<div class="form-group col-md-12 col-sm-12">
										<section>
											<label class="control-label">Notes/Comments</label>
											<textarea v-model="timecard.notes" class="form-control"></textarea>
										</section>
									</div>
							
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





                
                
                <!--   STUDENT OVERVIEW PANEL -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                    
                    	<h5><i>{{dateDisplay}} - Activity Overview</i></h5>
                    	<h4>Total Checked-In: {{total_checked_in}}</h4>
                    	
                    </div>
                    <div class="panel-body">                   
                    	<table class="table table-condensed table-hover">
						  <thead>
						  	  <th scope="col"></th>					    
						      <th scope="col">Name</th>
						      <th scope="col">In</th>
						      <th scope="col">Out</th>
						      <th scope="col">Total</th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr v-for="student in students">						    
						    	<td scope="col" style="width:50px;">
									<div v-if="student.status==1 && student.confirmed!=null" class="flagin"></div>
									<div v-else-if="student.status==1 && student.confirmed==null" class="flagpending"></div>
									<div v-else class="flagout"></div>
								</td>
								<td style="width:205px;">						      	
									{{student.name}}<br/>
									<img v-if="student.image==null" :id="'s'+student.student_id+'img'" src="/images/students/no_img_thumb.jpg" width="40" height="40" class="img-thumbnail">
									<img v-else :id="'s'+student.student_id+'img'" :src="'/images/students/thumb_'+student.image" width="60" height="60" class="img-thumbnail">
								</td>
								<td style="width:105px;">{{student.time_in}}</td>
								<td style="width:105px;">
									<span v-if="student.status==0">{{student.time_out}}</span>
								</td>						      
								<td>{{student.total}}</td>
								
								
								
								
								
								<!----- NEW ACTION BUTTONS --->
								<td>																
									<!-- CHECK-IN -->
									<button v-if="student.status==0" type="button" class="btn btn-success btn-xs" @click="initTimecard(student)">check-in</button>									
									<button v-else-if="student.status==1 && student.confirmed == null" class="btn btn-warning btn-xs" @click="initTimecard(student)">confirm check-in</button>									
									<button v-else type="button" class="btn btn-success btn-xs disabled" @click="initTimecard(student)" disabled="disabled">check-in</button>
									
									
									<!-- CHECK-OUT -->
									<button v-if="student.status==1 && student.confirmed != null" type="button" class="btn btn-danger btn-xs" @click="initTimecard(student)">check-out</button>									
									<button v-else type="button" class="btn btn-danger btn-xs disabled" disabled="disabled">check-out</button>																	
								</td>
								<!----- END NEW ACTION BUTTONS --->
								
								
								
								
						    </tr>						   
						  </tbody>
					 	</table>
                    </div>                    
                </div>
            
            
            
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'dashboardadmin',
    mounted() {
        console.log('--- DashboardAdmin Component ---');       
        this.setDateDisplay();
    },
    props:['user_id'],
    data(){
        return {
	        today:'', 
	        dateDisplay: '',
	        status: '',
	        total_checked_in: 0,
	        students: [],
	        
	        displayForm: false,
	        facilities:[],
	        guardians:[],
        	timecard: {
	        	timecard_id:0,
	        	guardian_id: '',
	        	facility_id: '',
	        	student_id: '',
	        	action_at: '',
	        	action:'',
	        	notes:'',
	        	confirmed_at: null,
	        	confirmed_by: 0
        	},
        	targetStudent:''
	    };
    },
    created(){
	    $.get('/api/timecard/sync-all');
	    
	    $.get('/api/facilities/options', facilities => {
			this.facilities = facilities.data;
		});
		
	    $.get('/api/timecard/current-status', status => {
		    this.total_checked_in = status.total_checked_in;
		    //console.log("students");
		    //console.log(status.students);
		    this.students = status.students;
		    //this.printStatus();
		});	
		
		
	},
	methods:{
		printStatus(){
			for(var key in this.students)
			{
				if(this.students.hasOwnProperty(key)){
					console.log(key);
					console.log(this.students[key]);
				}
			}
		},
		
		setDateDisplay(){
		   //var date = new Date();
		   //var m = 'Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec'.split(' ')[date.getMonth()];			    
		   //this.dateDisplay = m + " " + date.getDate().toString() + ", " + date.getFullYear();
		   
		   this.today = new Date();
		   var m = 'Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec'.split(' ')[this.today.getMonth()];	
		   this.dateDisplay = m + " " + this.today.getDate().toString() + ", " + this.today.getFullYear();
		   
		   //different date format (mm/dd/yyyy)
		   //this.dateDisplay = date.getMonth().toString()  + "/" + date.getDate().toString() + "/" + date.getFullYear();
	    },
	    
	    
	    
	    
	    
	    
	    //TIMECARD METHODS
	    //Load Timecard data into form 
	    initTimecard(student){
		    
		    this.targetStudent = student.name;
		    if(student.status)
		    {
			    /** NEW NEW NEW **/
			    $('#action-confirm').hide();
			    $('#action-checkin').hide();
			    $('#action-other').show();
			    
			    this.timecard.action="checkout";
			    
			    /** NEW NEW NEW **/
			    $('#action-checkout').show();
			    $('#action-checkout').prop("checked", true).trigger("click");
			    
			    /** PENDING checkins? NEW NEW NEW NEW **/
		    	if(student.confirmed==null)
		    	{
			    	this.timecard.action = "confirm";
			    	this.timecard.confirmed_at = student.checkin;
			    	this.timecard.action_at = (student.checkin.split(' ')[1]).split(':')[0] + ":" + (student.checkin.split(' ')[1]).split(':')[1];  //action_at to start
			    	this.timecard.confirmed_by = this.user_id;
			    	
			    	
			    	this.timecard.timecard_id = student.timecard_id;
					$('#action-checkin').hide();
					$('#action-checkout').hide();
					$('#action-other').hide();
					$('#action-confirm').show();
					$('#action-confirm').prop("checked", true).trigger("click");	
		    	}		    
		    }
		    else
		    {
			    /** NEW NEW NEW **/
			    $('#action-confirm').hide();
			    $('#action-checkout').hide();
			    $('#action-other').hide();
			    				    	
			    this.timecard.action="checkin";
			    this.timecard.confirmed_by = this.user_id;
			    /** NEW NEW NEW **/
			    $('#action-checkin').show();
			    $('#action-checkin').prop("checked", true).trigger("click");
		    }
		    
		    this.status=student.status;
		    this.timecard.facility_id = student.facility_id;
		    this.timecard.guardian_id = student.guardian_id;
		    this.timecard.student_id = student.student_id;
		    		    
		    //load students object
		    $.get(`/api/student/${student.student_id}`, profile => {
				this.guardians = profile.data.guardians;
			}).done(data => {
			    this.displayForm = true;
		    });

	    },
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    //Save 
	    saveTimecard(){
		    //confirm the timecard
		    if(this.timecard.action=='confirm')
		    {
			   	this.timecard.action_at = this.timecard.confirmed_at.split(' ')[0] + " " + this.timecard.action_at + ":00";
			   	this.timecard.confirmed_by = this.user_id;  //admin confirms
		    	var saveRequest = {
					type: 'PUT',
					url: '/api/timecard',
					contentType: 'application/json',
					data: JSON.stringify(this.timecard), // access in body
				};  
				
				var saveMsg = "Timecard confirmation successful.";			    
		    			    
			    $.ajax(saveRequest).done(data => {
				    console.log(data);
				    if(confirm(saveMsg)){					
						this.displayForm = false;
						this.resetTimecard();
			        }
			        $.get('/api/timecard/current-status', status => {
					    this.total_checked_in = status.total_checked_in;
					    this.students = status.students;
					});
				}).fail(function (msg) {
				    console.log(msg);
				}).always(msg => {});  				
		    }
		    else		 //create new timecard   		    		   
		    {
			    		    		   
			    var saveRequest = {
					type: 'POST',
				    url: '/api/timecard',
				    contentType: 'application/json',
				    data: JSON.stringify(this.timecard), // access in body
				};
				var saveMsg = "Student "+this.timecard.action+" successful.";			    
			    			    
			    $.ajax(saveRequest).done(data => {
				    console.log(data);
				    if(confirm(saveMsg)){					
						this.displayForm = false;
						this.resetTimecard();
			        }
			        $.get('/api/timecard/current-status', status => {
					    this.total_checked_in = status.total_checked_in;
					    this.students = status.students;
					});
				}).fail(function (msg) {
				    console.log(msg);
				}).always(msg => {});			    
		    }
		   
	    },
	    
	    
	    
	    
	    
	    
	    
	    
	        
	    onCancel(){	        	        
	        this.displayForm = false;
	        this.resetTimecard();
        },
                
	    resetTimecard(){
		    this.guardians=[];
		    this.timecard = {
			    timecard_id:0,
	        	guardian_id: '',
	        	facility_id: '',
	        	student_id: '',
	        	action_at: '',
	        	action:'',
	        	notes:''
        	};
	    }
	}
}
</script>
