<template>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">



			<h2 id="gsAdminTitle"></h2>





			<!-- IMAGE UPLOAD FORM -->
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="thumbnail" id="profile" v-show="displayProfile"  style="background:#FFF;">     
						<div class="caption text-center">
							<h3 id="profile_name"></h3>
							<p>
								<form id="new-file-form" action="#" method="#" @submit.prevent enctype="multipart/form-data">
									<label class="btn btn-default btn-sm">
										<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
										Browse 
										<input id="img-input" name="image" type="file" style="display: none;" ref="file" @change="addImage" @keydown="this.errors=[]">
									</label>
						            <button type="button" id="cancel-upload" class="btn btn-danger btn-sm" @click="cancelImgUpload" >
					                    <span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
										Cancel
					                </button>	                					                             
								</form>
							</p>
						</div>
						<div class="progress" style="display:none;">
							<div class="progress-bar progress-bar-striped active" id="progressbar" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
							</div>
						</div>
						
						<img src="/images/students/no_img.jpg" id="profile_img" alt="profile image">
						
					</div>
				</div>
			</div>
			<!-- END IMAGE UPLOAD FORM -->










			<!-- STUDENT FORM -->
			<div class="panel panel-default" id="student-form" v-show="displayForm">
				<div class="panel-heading">
					<h4>Student Details</h4>
				</div>
				<div class="panel-body">
					<form @submit.prevent="saveStudent">
						<fieldset>		
							<div class="row" style="margin-bottom:0px;">
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label" for="edit-guardian">Primary Guardian</label>	                        
			                        <div  :class="{'has-error': errors && errors.primary}">
			                        	<select class="form-control" v-model="student.primary_guardian_id" @change="linkPrimaryGuardian">
			                        		<option disabled value="">Select a Primary Guardian</option>
											<option v-for="(guardian in guardians" :value="guardian.id" v-bind:disabled="guardian.status !== 'active'">{{guardian.lastname}}, {{guardian.firstname}} {{guardian.mi}}</option>
										</select>
			                            <span v-if="errors && errors.primary" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.primary[0] }}</span>
			                        </div>
								</div>
							</div>
							
							                  
		                    <div class="row" style="margin-bottom:0px;">
			                    <div class="form-group col-md-4 col-sm-4 col-xs-8">		                    
			                        <label class="control-label">Firstname</label>
			                        <div :class="{'has-error': errors && errors.firstname}">
			                            <input v-model.lazy="student.firstname"
			                                   type="text"
			                                   placeholder="Firstname"
			                                   class="form-control">
			                            <span v-if="errors && errors.firstname" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.firstname[0] }}</span>
			                        </div>
			                    </div>
			                    <div class="form-group col-md-2 col-sm-2 col-xs-4">		                    
			                        <label class="control-label">MI</label>
			                        <div :class="{'has-error': errors && errors.mi}">
			                            <input v-model.lazy="student.mi"
			                                   type="text"
			                                   placeholder="mi"
			                                   class="form-control">
			                            <span v-if="errors && errors.mi" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.mi[0] }}</span>
			                        </div>
			                    </div>			                    
			                    <div class="form-group col-md-4 col-sm-4 col-xs-8">		                    
			                        <label class="control-label">Lastname</label>
			                        <div :class="{'has-error': errors && errors.lastname}">
			                            <input v-model.lazy="student.lastname"
			                                   type="text"
			                                   placeholder="Lastname"
			                                   class="form-control">
			                            <span v-if="errors && errors.lastname" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.lastname[0] }}</span>
			                        </div>
			                    </div>
			                    <div class="form-group col-md-2 col-sm-2 col-xs-4">		                    
			                        <label class="control-label">Suffix</label>
			                        <div :class="{'has-error': errors && errors.suffix}">
			                            <input v-model.lazy="student.suffix"
			                                   type="text"
			                                   placeholder="Suffix"
			                                   class="form-control">
			                            <span v-if="errors && errors.suffix" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.suffix[0] }}</span>
			                        </div>
			                    </div>
			                </div>
			                
			                
			                <div class="row" style="margin-bottom:0px;">
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label" for="edit-facility">Facility</label>	                        
			                        <div  :class="{'has-error': errors && errors.facility}">
			                        	<select class="form-control" v-model="student.facility_id" @change="loadClassrooms">
			                        		<option disabled value="">Select a facility</option>
											<option v-for="(facility in facilities" :value="facility.id">{{facility.name}}</option>
										</select>
			                            <span v-if="errors && errors.facility" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.facility[0] }}</span>
			                        </div>
								</div>
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label" for="edit-classroom">Classroom</label>	                        
			                        <div  :class="{'has-error': errors && errors.classroom}">
			                        	<select class="form-control" v-model="student.classroom_id" >
			                        		<option disabled value="">Select a classroom</option>
											<option v-for="classroom in classrooms" :value="classroom.id">{{classroom.name}}</option>
										</select>
			                            <span v-if="errors && errors.classroom" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.classroom[0] }}</span>
			                        </div>
								</div>
							</div>
			                
			                
			                <div class="row" style="margin-bottom:0px;">
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label" for="edit-dob">Date Of Birth</label>
									<div  :class="{'has-error': errors && errors.date_of_birth}">
										<input v-model.lazy="student.date_of_birth"
			                                   type="date"
			                                   style="width:auto;"
			                                   class="form-control">
									
										<span v-if="errors && errors.date_of_birth" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.date_of_birth[0] }}</span>
			                        </div>
								</div>
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label">Gender</label>
									<div  :class="{'has-error': errors && errors.gender}">
										<input id="gender-female" type="radio" value="female" v-model.lazy="student.gender">
										<span>female</span>
										&nbsp;
										<input id="gender-male" type="radio" value="male" v-model.lazy="student.gender">
										<span>male</span>
										
										<span v-if="errors && errors.gender" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.gender[0] }}</span>
									</div>
								</div>
							</div>
			                
			                
			                <div class="row" style="margin-bottom:0px;">
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label">Allergies</label>
									<div  :class="{'has-error': errors && errors.allergies}">
										<textarea v-model="student.allergies" placeholder="Specify allergies here..." class="form-control"></textarea>
										<span v-if="errors && errors.allergies" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.allergies[0] }}</span>
									</div>
								</div>
								
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label">Special Needs</label>
									<div  :class="{'has-error': errors && errors.special_needs}">
										<textarea v-model="student.special_needs" placeholder="Specify any special needs here..." class="form-control"></textarea>
										<span v-if="errors && errors.special_needs" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.special_needs[0] }}</span>
									</div>
								</div>
								
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label">State Special Code</label>
									<div  :class="{'has-error': errors && errors.special_code}">
										<input type="text" class="form-control" v-model="student.special_code" placeholder="Special Code">
										<span v-if="errors && errors.special_code" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.special_code[0] }}</span>
									</div>
								</div>
							</div>
			                
			                
			                
			                <div class="row" style="margin-bottom:0px;">
								<div class="form-group col-md-4 col-sm-4 col-xs-8">
									<label class="control-label">Link All Guardians</label>
									<ul style="list-style-type:none;margin:0;padding:0;">
										<li v-for="(guardian in guardians">
										    
											<input :id="'guardian_'+guardian.id" type="checkbox" :value="guardian.id" v-model="studentGuardians" @change="linkPrimaryGuardian" v-bind:disabled="guardian.status !== 'active'">
											<span>{{guardian.lastname}}, {{guardian.firstname}} {{guardian.mi}}</span>
											
										</li>
									</ul>
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
			<!-- END STUDENT FORM -->
			
			
			
			
			<!-- STUDENT TABLE -->
			<div class="panel panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="row">
								<div class="text-right">
									<button type="button" class="btn btn-link btn-sm" @click="addStudent()">
									Register a new Student
									</button>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(student,index) in students" v-bind:key="student.id" scope="row">
							<td>							
															
								<div class="col-md-2 col-sm-2 col-xs-2">
									<a href="#" @click.prevent="showSelfie(student)">
										<img v-if="student.image==null" :id="'s'+student.id+'img'" src="/images/students/no_img_thumb.jpg" width="60" height="60" class="img-thumbnail">
										<img v-else :id="'s'+student.id+'img'" :src="'/images/students/thumb_'+student.image" width="60" height="60" class="img-thumbnail">
									</a>
								</div>	
								<div class="col-md-5 col-sm-5 col-xs-10">
									<a @click.prevent="openStatusModal(student)" class="label label-success" v-if="student.status=='active'">{{student.status}}</a>
									<a @click.prevent="openStatusModal(student)" class="label label-danger" v-else>{{student.status}}</a>&nbsp;
									
									<a href="#" @click.prevent="editStudent(student)">
										{{student.firstname}}&nbsp;{{student.mi}}&nbsp;{{student.lastname}}&nbsp;{{student.suffix}}										</a>
									<br/>
									<b>Gender:</b> {{student.gender}}<br/>
									<b>Date of Birth:</b> {{student.date_of_birth | formatDate}}
									
									<br/>
									
									<a href="#" @click.prevent="openModal(guardian_id,student.id)">
										<span class="glyphicon glyphicon-qrcode"></span> - QR Code						
									</a>
									
									<br/>
									
									<a href="#" @click.prevent="badgeModal(student)">
										<span class="glyphicon glyphicon-user"></span>&nbsp;-&nbsp;ID Card</span>
									</a>																	
								</div>
								<div class="visible-lg visible-md visible-sm col-md-5 col-sm-5"> 																	<b>Facility:</b><br/>			      
									<span v-if="student.facility">
										{{student.facility.name}}	
									</span><br/>
									
									<b>Classroom:</b><br/>
									<span v-if="student.classroom">
										{{student.classroom.name}}	
									</span>																		
								</div>






							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- END STUDENT TABLE -->
			
			


<!-- MODAL -->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="qrcode" src="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- END MODAL -->





<!-- Status Modal form  -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Update Status</h4>
        <span>{{student.firstname}} {{student.mi}} {{student.lastname}}</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">

	  				<form @submit.prevent="updateStudentStatus">
						<fieldset>		
							<div class="row" style="margin-bottom:0px;">
								<div class="form-group col-md-6 col-sm-6 col-xs-6 text-left">
									<div  :class="{'has-error': errors && errors.primary}">
			                        	<select class="form-control" v-model="student.status">
			                        		<option disabled value="">Select a status</option>
											<option value="active" v-bind:selected="student.status == 'active'">Active</option>
											<option value="disabled" v-bind:selected="student.status === 'disabled'">Disabled</option>
											<option value="pending" v-bind:selected="student.status === 'pending'">Pending</option>
										</select>
			                            <span v-if="errors && errors.primary" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.primary[0] }}</span>
			                        </div>
								</div>
							
		                    	<div class="form-group col-md-6 col-sm-6 col-xs-6 text-right">			                    
			                        <button type="button" class="btn btn-danger btn-sm" @click="closeStatusModal">
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
<!-- end modal -->






<!-- BADGE MODAL -->
			<div class="modal fade" id="badgeModal" v-show="showBadgeModal">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
				  <div class="modal-body">
			        <div class="row" >
						<div class="col-lg-offset-2 col-lg-8 col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="border: thin solid #636b6f;max-width:380px; max-height:240px;width:380px;height:240px;border-radius:10px;">						  
						  <div class="row text-center" style="border-bottom:thin solid black">
						  	<h3>{{idcard.firstname}} {{idcard.lastname}}</h3>
						  </div>
						  <div class="row" style="color:#636b6f;">
				          	<div class="col-lg-3 col-md-3 col-sm-3" style="padding:5px;">
				          		<img v-if="idcard.image==null" src="/images/students/no_img_thumb.jpg"  class="img-thumbnail">
						  		<img v-else :src="'/images/students/thumb_'+idcard.image" class="img-thumbnail">
						  		<br/>
						  		<span v-if="idcard.special_code!=null">{{idcard.special_code}}</span>
				          	</div>
						  	<div class="col-lg-9 col-md-9 col-sm-9">							  	
								<b>Guardian:</b> {{idcard_pg.firstname}} {{idcard_pg.lastname}}									
								<br/>
								<b>Special Needs:</b> {{idcard.special_needs}}							  	
						  	</div>
						  </div>						 
						</div>
					</div>
			      </div>
			      <div class="modal-footer">
			      	<a type="button" class="btn btn-link" :href="'/student-badge-pdf/'+idcard.id" target="_blank">Download PDF</a>
		      
			        <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelBadgeModal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
 <!-- ID Badge MODAL -->







		</div>
	</div>
</div>
</template>
<script>
export default {
	mounted(){
		//onMounted action
	},
	props:['guardian_id'],
	data(){
        return {
	        
	        noImage: '/images/students/no_img.jpg',
        	noImageThumb: '/images/students/no_img_thumb.jpg',
        	
        	displayProfile: false,
            displayForm: false,            
            errors: [],
	        
	        students:[],
	        idcard:{},
	        idcard_pg:{},
	        showBadgeModal:false,
            student:{
	            id: '',
	            
	            classroom_id:'',
	            classroom:{},
	            
	            facility_id:'',
            	facility: {},
            	
	            guardians:[],
            	            	            	            	
            	primary_guardian:{},
            	primary_guardian_id: '',
            	
            	firstname: '',
            	lastname: '',
            	mi:'',
            	suffix:'',
            	gender: '',
            	allergies:'',
	            special_needs: '',
	            special_code: '',
            	date_of_birth:''
            },
            pagination:{},
                        
            guardians:[],
            facilities:[],
            classrooms:[],
            
            
            
            studentGuardians:[],
            primaryGuardian: 0
		};
	},
	
	
	created(){
		this.resetStudent();
	    this.loadStudents();
	    this.loadGuardians();
	    this.loadFacilities();	    
    },
	filters: {
		formatDate: function(d){
			return moment(d).format('MMM Do, YYYY');
		},
		
		formatTime: function(t){
			return moment(t).format('h:mm A');
		}
		
	},    
    methods: {
	    resetStudent(){
		    this.student = {
		            id: '',
		            
		            classroom_id:'',
		            classroom:{},
		            
		            facility_id:'',
	            	facility: {},
	            	
		            guardians:[],
	            	            	            	            	
	            	primary_guardian:{},
	            	primary_guardian_id: this.guardian_id,
	            	
	            	firstname: '',
	            	lastname: '',
	            	mi:'',
	            	suffix:'',
	            	gender: '',
	            	allergies:'',
		            special_needs: '',
		            special_code: '',
	            	date_of_birth:''			    
			    
		    };
		    
		    this.errors=[];
	    },
	    
	    
	    
	    loadStudents(){
		    $.get(`/api/guardian/${this.guardian_id}`, guardian => {
			    var title = guardian.data.firstname+" "+guardian.data.mi+" "+guardian.data.lastname;
			    if(guardian.data.mi==null)
			    {
				    title = guardian.data.firstname + " " + guardian.data.lastname;
			    }
			    $('#gsAdminTitle').html(title);
			    this.students = guardian.data.students;
			});	    
	    },
	    
	       
	    addStudent(){
		    this.displayForm = true;
		    this.resetStudent();
		    this.classrooms = [];
		    this.scrollTo('#student-form');
		    this.studentGuardians=[];
			this.primaryGuardian=0;
		    this.loadStudents();
		    this.primaryGuardian = this.guardian_id;
		    this.studentGuardians.push(this.guardian_id);
	    },
	    
	    
	    
	    //PREPARE FORM DATA FROM STUDENT 
	    editStudent(student){
		    //form already open so reset data bc student wasn't saved on server but updated locally
		    if(this.displayForm == true){ 
			    this.resetStudent();
			    this.loadStudents();
			    //this.currentPage(this.pagination.current_page);
			    this.studentGuardians=[];
				this.primaryGuardian=0;
		    }		    
		    this.displayForm = true;
		    this.student = student;
		    this.student.student_id = student.id;
		    this.loadClassrooms();
		    this.scrollTo('#student-form');
		    
		    //student guardian checkboxes
		    var vm=this;
		    student.guardians.forEach(function(guardian){
			    vm.studentGuardians.push(guardian.id);
		    })		    
		    this.primaryGuardian = student.primary_guardian_id;		    
	    },
	    
	    
	    
	    //SAVE STUDENT POST-PUT HTTP REQUEST
	    saveStudent(){
		    this.student.guardians = this.studentGuardians;
		    
		    var saveRequest = {
				type: 'POST',
			    url: '/api/student',
			    contentType: 'application/json',
			    data: JSON.stringify(this.student), // access in body
			};
				
		    var saveMsg = "Child record created.";
			
		    if(this.student.student_id){			    
			    saveRequest = {
			    	type: 'PUT',
					url: '/api/student',
					contentType: 'application/json',
					data: JSON.stringify(this.student)
				};
			    saveMsg = "Child record updated.";

		    } else {
			    this.student.status = 'active';
			    saveRequest = {
					type: 'POST',
				    url: '/api/student',
				    contentType: 'application/json',
				    data: JSON.stringify(this.student), // access in body
				};
				saveMsg = "Child record created.";
	        		    
		    }
		    
		    //Request: CREATE(POST)/UPDATE(PUT)		    
			$.ajax(saveRequest).done(data => {
			    if(confirm(saveMsg)){
			        this.displayForm = false;
					this.resetStudent();
					this.studentGuardians=[];
					this.primaryGuardian=0;
		        }
		        this.loadStudents();
			}).fail(function (msg) {
			    console.log(msg);
			}).always(function (msg) {
			    console.log(msg);
			});
		    		    
	    },
	    
	    
	    
	    
	    
	    
	    
	  
		/** updateStudentStatus **/
		openStatusModal(data){
			this.student=data;
			$('#statusModal').modal('show');
		},
		closeStatusModal(){
			$('#statusModal').modal('hide');
		},
		updateStudentStatus(){
			    var data = {
			    	'student_id':this.student.id,
			    	'status':this.student.status
			    }
			    
			    var saveRequest = {
			    	type: 'PUT',
					url: '/api/student/status',
					contentType: 'application/json',
					data: JSON.stringify(data)
				};
			    var saveMsg = "Child status updated.";
				$.ajax(saveRequest).done(data => {
				    if(confirm(saveMsg)){

						$('#statusModal').modal('hide');
						
			        }
			        //this.loadStudents();
				}).fail(function (msg) {
				    console.log(msg);
				}).always(function (msg) {
				    console.log(msg);
				});
							    		
		},
	  
	  
	  
	  
	  
	    
	    
	    
	    
	    onCancel(){
		    this.displayForm = false;
		    this.resetStudent();
		    this.studentGuardians=[];
			this.primaryGuardian=0;
		    this.loadStudents();
	    },
	    
	    
	    

	    
	    loadGuardians(){
		    $.get(`/api/guardians/options`, guardian => {
			    this.guardians = guardian.data;
		    });		    
	    },
	    
	    	    
	    loadFacilities(){
		    $.get(`/api/facilities/options`, facility => {
			    this.facilities = facility.data;
			});
	    },
	    	    
	    
	    loadClassrooms(){
		    var st = this.student;
		    $.get(`/api/classrooms/options/${this.student.facility_id}`, classroom => {
			    this.classrooms = classroom.data;
			});
	    },

	    
		scrollTo(pos){
	        $('html,body,.container').animate({
		        scrollTop: $(pos).offset().top
		    },'slow');
        },
        
               
        linkPrimaryGuardian(){
	        var newGuardians = [];	        
	        for(var x=0; x<this.studentGuardians.length; x++)
	        {
		        if(this.studentGuardians[x] != this.primaryGuardian)
		        	newGuardians.push(this.studentGuardians[x]);
	        }
	        newGuardians.push(this.student.primary_guardian_id);    

	        //console.log(newGuardians.length);
	        this.studentGuardians = newGuardians;
	        this.primaryGuardian = this.student.primary_guardian_id
        },
        
        
        
        
        
        /**
         * Profile IMG Uploader
         *                
		 */
        addImage(event){
			console.log(event.target);	
			let tmpImg = URL.createObjectURL(event.target.files[0]);
			document.getElementById("cancel-upload").disabled = true;
			
			//reset errors so the block disappears
			this.errors = [];		
			$('#profile_img').attr('src',tmpImg);
			$('#s'+this.student.id+'img').attr('src',tmpImg);
			console.log(this.$refs.file.files[0].name);
			this.uploadImage();
			
			$('div.progress').show();
			let percentage = 10;
			
			setInterval(function()
		    {			    
		        $('#progressbar').css('width',percentage+'%');		        
		        percentage += percentage<100 ? 10 : 0;		
		    },300);			
		},
		
		cancelImgUpload(){
			$('#profile_img').attr('src',this.noImage);
		    this.displayProfile = false;
		    $('#profile_img').attr('src',this.noImage);
	    },
	    
		showSelfie(student){
			this.scrollTo('#profile_img');
			 
			$('#progressbar').css('width','0%');
			
			this.student = student;
		    this.displayProfile = true;
		    this.student.student_id = student.id;
		    
		    let name = this.student.firstname;
		    name += this.student.mi ? " "+this.student.mi : "";
		    name += " "+this.student.lastname;
		    name += this.student.suffix ? " "+this.student.suffix : "";		    
		    $('#profile_name').text(name);
		    		   		    
		    
		    let src = '/images/students/no_img.jpg';
		    if(this.student.image!=null)		    		    	
		    	src = '/images/students/'+this.student.image;
		    $('#profile_img').attr('src',src);		   
		},


		uploadImage(){			
			/** 
			let formData = new FormData();
            formData.append('student_id', this.student.id);
            formData.append('image', this.$refs.file.files[0]);
			
			axios.post('/api/student/upload', formData, {headers: {'Content-Type': 'multipart/form-data'}})
            .then(response => {
	            if(response.data.errors){
			        $('div.progress').hide();
			        console.log(response.data.errors);			        
				} else {
		            document.getElementById("cancel-upload").disabled = false;
					this.student = response.data.data;
		            if(confirm('Profile image update successful')){
					    $('div.progress').hide();
					    $('div.progress').find('progressbar').prop('style','width: 0');
				    }
				    this.loadStudents();            
	            }	           		            
            })
            .catch(error => console.log(error));
            **/
            
            
			var vm = this;
			var theForm = $('#new-file-form');
			var formData = new FormData(theForm[0]);  
			formData.append('student_id', vm.student.id);
 
			$.ajax({
				url: '/api/student/upload',
				data: formData,	
				processData:false,
				contentType: false,
				type: 'POST',
				
				success: function(response){
					if(response.data.errors)
					{
					    $('div.progress').hide();
					    console.log(response.data.errors);			       
					} 
					else 
					{
						document.getElementById("cancel-upload").disabled = false;
						vm.student = response.data;
						if(confirm('Image upload successful.'))
						{
						    $('div.progress').hide();
						    $('div.progress').find('progressbar').prop('style','width: 0');
						}
						vm.loadStudents();            
					}	            
				},	
			      
				error: function(e) {
					console.log(e)
				}            
			}); //END AJAX POST FILE UPLOAD
			
		},//end uploadImage()

			
		
		openModal(gid,sid){
			$('#qrModal').modal('show');
			let imgUrl = 'http://162.243.170.129/qrcode/'+gid+'/'+sid+'/150';
			$('#qrcode').attr('src',imgUrl);
		},
		cancelBadgeModal(){
			this.showBadgeModal = false;
		},
		badgeModal(student){
			$('#badgeModal').modal('show');
			
			//alert(student.firstname);
			this.showBadgeModal = true;
			this.idcard = student;
			this.idcard_pg = student.guardians[0];
			console.log("CARD");
			console.log(this.idcard);			
		}

        
         
	} //end methods
}
</script>