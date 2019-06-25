<template>
    <div class="container">
    
    
    	<div class="row" style="margin-bottom:5px;">
            <div class="col-md-10 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0 text-left">            	
            	<h3 class="mb-0">Guardian Overview</h3>           				
        	</div>
        </div>
        <div class="row" style="margin-bottom:5px;">	       	
        	<div class="col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-0">
        		<img v-if="guardian.image==null" :id="'s'+guardian.id+'img'" src="/images/guardians/no_img.jpg" width="140" height="140"  class="img-rounded">
				<img v-else :id="'s'+guardian.id+'img'" :src="'/images/guardians/'+guardian.image" width="140" height="140" style="border-radius:3px;" class="img-rounded">       	
        	</div>
        	<div class="col-md-7 col-sm-9">
        		<i><b>Date:</b> {{dateDisplay}}</i><br/>
        		<i><b>Guardian:</b> {{guardian.firstname}} {{guardian.lastname}}</i>
        	</div>
        </div>    	
        
        
        
        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">    
	            
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
												<input name="notes" type="radio" v-model="timecard.action" value="checkin" :checked="timecard.action=='checkin'"> check-in
											</span>
											&nbsp;
											<span id="action-checkout">
												<input name="notes"  type="radio" v-model="timecard.action" value="checkout"> check-out
											</span>
											&nbsp;
											<span id="action-confirm">
												<input name="notes"  type="radio" v-model="timecard.action" value="confirm"> confirm check-in
											</span>
											&nbsp;
											<span id="action-other">
												<input name="notes" type="radio" v-model="timecard.action" value="other"> other activity
											</span>
										</section>
									</div>
											                    
									<div class="form-group col-md-6 col-sm-6">
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
			</div>
		</div>
    
    
    
    
    
    
    
		<!--  OLD ACTIVITY TABLE
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                        
                <div class="panel panel-default" v-for="childtc in this.timecards">
                    <div class="panel-heading" style="background:#f9f9f9;padding:5px;">
                    	<span class="panel-title">
                    		{{childtc.student.firstname}} {{childtc.student.lastname}}&nbsp;&nbsp;
							<button type="button" class="btn btn-link btn-xs" @click="initTimecard(childtc.student)">log activity</button>
						</span>
                    </div>
                    <div class="panel-body"  v-if="childtc.data.length">						
						<table class="table table-hover table-condensed mb-0">
							<thead>
								<th colspan="2">Summary {{childtc.data[0].action_at_date}}</th>
								<th>Facility</th>
								<th>Guardian</th>										
							</thead>
							<tbody>
								
								
			                    <tr v-for="timecard in childtc.data">
			                    	<td colspan="2">
			                        	<span v-if="timecard.is_checkin">Check In <b>@{{timecard.action_at_time}}</b></span>
										<span v-if="timecard.is_checkout">Check Out <b>@{{timecard.action_at_time}}</b></span>
										<span v-if="!timecard.is_checkin && !timecard.is_checkout">Activity <b>@{{timecard.action_at_time}}</b></span>&nbsp;-&nbsp;{{timecard.notes}}
			                        </td>
			                        <td>
			                        	{{timecard.facility.name}}
			                        </td>
			                        <td>
			                        	{{timecard.guardian.firstname}}&nbsp;{{timecard.guardian.lastname}}
			                        </td>
			                    </tr>
			                    
			                </tbody>
						</table>
                    </div>
                </div>

            </div>
        </div>
        -->
        
        
        
        
        
        
        
        
        
        
        
        
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                
                <!--   STUDENT OVERVIEW PANEL -->
                <div class="panel panel-default">
                    <div class="panel-body">                   
                    	<table class="table table-condensed table-hover">
						  <thead>
						  	  <th scope="col"></th>					    
						      <th scope="col">Name</th>
						      <th scope="col">Facility</th>
						      <th scope="col">In</th>
						      <th scope="col">Out</th>
						      <th scope="col">Total</th>
						      <th scope="col"></th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr v-for="activity in activities">						    
						    	<td scope="col" style="width:50px;">
						    	
									<div v-if="activity.option=='out' && activity.last.in.confirmed_at == null" class="flagpending"></div>
									<div v-else-if="activity.option=='out' && activity.last.in.confirmed_at != null" class="flagin"></div>									<div v-else class="flagout"></div>
																
								</td>
								<td style="width:205px;">						      	
									{{activity.profile.firstname}} {{activity.profile.lastname}}<br/>
									<img v-if="activity.profile.image==null" :id="'s'+activity.profile.id+'img'" src="/images/students/no_img_thumb.jpg" width="40" height="40" class="img-thumbnail">
									<img v-else :id="'s'+activity.profile.id+'img'" :src="'/images/students/thumb_'+activity.profile.image" width="60" height="60" class="img-thumbnail">
								</td>
								
								<td style="width:150px;">{{activity.profile.facility.name}}</td>
								
								<td style="width:105px;">{{activity.last.time_in}}</td>
								<td style="width:105px;">
									<span v-if="activity.last.out != null">{{activity.last.time_out}}</span>
								</td>						      
								<td>{{activity.last.total}}</td>
								
								
								

								
								
								<!-- ADMIN BUTTONS -->								
								<td v-if="role=='admin'">
									
									<!-- CHECK-IN -->
									<button v-if="activity.option=='in'" type="button" class="btn btn-success btn-xs" @click="initTimecard(activity)">check-in</button>
									<button v-else-if="activity.option == 'out' && activity.last.in.confirmed_at == null" class="btn btn-warning btn-xs" @click="initTimecard(activity)">confirm check-in</button>									
									<button v-else type="button" class="btn btn-success btn-xs disabled" @click="initTimecard(activity)" disabled="disabled">check-in</button>
									
									
									<!-- CHECK-OUT -->
									<button v-if="activity.option=='out' && activity.last.in.confirmed_at != null" type="button" class="btn btn-danger btn-xs" @click="initTimecard(activity)">check-out</button>															
									
									<button v-else type="button" class="btn btn-danger btn-xs disabled" @click="initTimecard(activity)">check-out</button>
															
								</td>
								
								<!-- GUARDIAN BUTTONS -->	
								<td v-else>
									<button v-if="activity.option=='in'" type="button" class="btn btn-success btn-xs" @click="initTimecard(activity)">check-in</button>	
									<button v-else type="button" class="btn btn-default btn-xs disabled" @click="initTimecard(activity)" disabled="disabled">check-in</button>
									
								</td>
								<!-- END BUTTONS -->
								
								
								
								
								
								
																
								
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
	    name: 'guardianscheckin',
        mounted() {
            console.log("GUARDIAN ROLE: " + this.role)
        },
        props:['guardian_id','role'],
        data(){
        	return {
	        	dateDisplay: '',
	        	displayForm: false,
	        	
	        	checkoutActive: false, //checkout button NEW
	        	
	        	guardian:{},
	        	//students:[],
	        	targetStudent:'',
	        	timecards:[],
	        	//options:[],
	        	facilities:[],
	        	timecard: {
		        	guardian_id: this.guardian_id,
		        	facility_id: '',
		        	student_id: '',
		        	action_at: '',
		        	action:'',
		        	notes:''
	        	},
	        	
	        	activities:[]
	        	
	        };
	    },
        created(){	
	        this.setDateDisplay();
	        
	        $.get('/api/facilities/options', facilities => {
			    this.facilities = facilities.data;
			});
			
						
	        $.get(`/api/timecard/sync/${this.guardian_id}`, opts => {
			    console.log('Allowed Actions:');
			    console.log(opts);
			    this.options = opts;
			});
			
			
			console.log(`/api/guardian/student_options/${this.guardian_id}`);
			
			this.getGuardians();
			this.getActivities();
			
	    }, //end created()
	    
	    
	    methods: {    
		    getActivities(){
			    $.get(`/api/guardian/student_options/${this.guardian_id}`, resp => {
					console.log("New Data");
					console.log(resp);
					this.activities = resp;
					console.log(this.activities[0].profile);
				});
		    },
		    getGuardians(){
			    $.get(`/api/guardian/${this.guardian_id}`, guardian => {
				    console.log("guardian: "+this.guardian_id);
				    console.log(guardian.data);
				    this.guardian = guardian.data;
				});
		    },
		    
		    
		    
		    /*** Prepare form data ***/
		    initTimecard(student){		    
			    this.targetStudent = student.profile.firstname + " " + student.profile.lastname;
			    	
			    /** confirm timecard (ONLY ADMIN) **/
			    
			    console.log("InitTimecard - student parameter:");
			    console.log("Role: " + this.role); 
			    console.log("Opt: " + student.option);
			    
			    if(student.option == 'out') 
			    { 
				    $('#action-confirm').hide();
			    	$('#action-checkin').hide();
			    	$('#action-other').show();
			    	
			    	this.timecard.action = "checkout";
			    	$('#action-checkout').show();
			    	$('#action-checkout').prop("checked", true).trigger("click");
			    	
			    	/** CHECK for PENDING checkins - ADMIN ROLE ONLY **/
			    	if(this.role=='admin' && (student.last.in.confirmed_by==0 || student.last.in.confirmed_at==null))
			    	{
				    	this.timecard.action = "confirm";
						$('#action-checkin').hide();
						$('#action-checkout').hide();
						$('#action-other').hide();
						$('#action-confirm').show();
						$('#action-confirm').prop("checked", true).trigger("click");	
			    	}
			    }
			    
			    if(student.option == 'in')
			    { 
				    $('#action-confirm').hide();
			    	$('#action-checkout').hide();
			    	$('#action-other').hide();
			    	
			    	this.timecard.action = "checkin";
			    	$('#action-checkin').show();
			    	$('#action-checkin').prop("checked", true).trigger("click");
			    }
			   			    
			    
			    this.timecard.facility_id = student.profile.facility_id;
			    this.timecard.guardian_id = this.guardian_id;
			    this.timecard.student_id = student.profile.id;
			    		    
				this.displayForm = true;			    
		    },
		    
		    
		    
		    
		    	
		    	
		    	
		    	
		    	    
		    /*** Create new timecard. POST this.timecard form data ***/
		    saveTimecard(){			    
			    var saveRequest = {
					type: 'POST',
				    url: '/api/timecard',
				    contentType: 'application/json',
				    data: JSON.stringify(this.timecard), // access in body
				};
				var saveMsg = "Student timecard saved.";	
				if(this.timecard.action == "checkin")		    
			    	saveMsg = "Student has been checked in.";
			    if(this.timecard.action == "checkout")
			    	saveMsg = "Student has been checked out.";
			    		    
			    $.ajax(saveRequest).done(data => {
				    console.log(data);
				    if(confirm(saveMsg)){
				        this.displayForm = false;						
						this.resetTimecard();
						this.refreshDisplay();
			        }
				}).fail(function (msg) {
				    console.log(msg);
				}).always(msg => {});
			    			    
		    }, 
		    
		    
		    
		    /*** Cancel Timecard Form Entry ***/
		    onCancel(){	        	        
		        this.displayForm = false;
		        this.resetTimecard();
	        },
	        
	        
	        
	        /*** Reset form data serving Timecard  POST ***/
		    resetTimecard(){
			    this.timecard = {
		        	guardian_id: this.guardian_id,
		        	facility_id: '',
		        	student_id: '',
		        	action_at: '',
		        	action:'',
		        	notes:''
	        	};
		    },
		    
		    
		    
		    /*** refresh/update student timecard data on display ***/ 
		    refreshDisplay(){
			    $.get(`/api/timecard/sync/${this.guardian_id}`, opts => {
				    this.options = opts;
				});
				
				$.get(`/api/guardian/student_options/${this.guardian_id}`, resp => {
					this.activities = resp;
				});				
		    },
		    
		    
		    
		    /*** date formatter ***/
		    setDateDisplay(){
			   var date = new Date();
			   var m = 'Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec'.split(' ')[date.getMonth()];			    
			   this.dateDisplay = m + " " + date.getDate().toString() + ", " + date.getFullYear();
		    },
		    
		    
		    /** onComplete **/
		    onComplete(){
			    window.location = "/guardian/fingerprint-login";
		    }

		    		    
		    		    
		    
	    }
	    
    }
</script>
