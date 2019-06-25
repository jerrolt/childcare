<template>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		

			<h2 id="PageHeader">Registered Children</h2>





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
						
						<img src="/images/guardians/no_img.jpg" id="profile_img" alt="profile image">
						
					</div>
				</div>
			</div>
			<!-- END IMAGE UPLOAD FORM -->


			


<!-- STUDENT FORM -->
<div class="panel panel-default" id="student-form" v-show="displayForm">
	<div class="panel-heading">
		<h4>Edit Child: {{student.firstname}} <span v-if="student.mi!=null">{{student.mi}}</span> {{student.lastname}} <span v-if="student.suffix!=null">{{student.suffix}}</span></h4>
	</div>
	<div class="panel-body">
		<form @submit.prevent="saveStudent">
			<fieldset>		
				<div class="row" style="margin-bottom:0px;">
					<div class="form-group col-md-4 col-sm-4 col-xs-8">
						<label class="control-label">Primary Guardian:</label> {{student.primary_guardian.firstname}} {{student.primary_guardian.mi}} {{student.primary_guardian.lastname}}<br/>
						<label class="control-label">Facility:</label> {{student.facility.name}}<br/>
						<label class="control-label">Classroom:</label> {{student.classroom.name}}<br/>
						<label class="control-label" for="edit-dob">Date Of Birth:</label>{{student.date_of_birth}}<br/>
						<label class="control-label">Gender:</label>{{student.gender}}
					</div>
					
					<!--
				</div>
                <div class="row" style="margin-bottom:0px;">
                -->
                	<div  class="col-md-2 col-sm-2">&nbsp;</div>
					<div class="form-group col-md-4 col-sm-4 col-xs-8">
						<label class="control-label">Linked Guardians:</label>
						<ul style="list-style-type:none;margin:0;padding:0;">
							<li v-for="(guardian in student.guardians">							
								{{guardian.lastname}}, {{guardian.firstname}} {{guardian.mi}}
								<span v-if="student.primary_guardian.id==guardian.id">&nbsp;(primary guardian)</span>
							</li>
						</ul>
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
						<label class="control-label">Allergies:</label>
						<div  :class="{'has-error': errors && errors.allergies}">
							<textarea v-model="student.allergies" placeholder="Specify allergies here..." class="form-control"></textarea>
							<span v-if="errors && errors.allergies" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.allergies[0] }}</span>
						</div>
					</div>
					
					<div class="form-group col-md-4 col-sm-4 col-xs-8">
						<label class="control-label">Special Needs:</label>
						<div  :class="{'has-error': errors && errors.special_needs}">
							<textarea v-model="student.special_needs" placeholder="Specify any special needs here..." class="form-control"></textarea>
							<span v-if="errors && errors.special_needs" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.special_needs[0] }}</span>
						</div>
					</div>
					<div class="form-group col-md-4 col-sm-4 col-xs-8">
						<label class="control-label">State Special Code</label>
						<div  :class="{'has-error': errors && errors.special_code}">
							<input type="text"  v-model="student.special_code" placeholder="Special Code">
							<span v-if="errors && errors.special_code" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.special_code[0] }}</span>
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
<!-- END STUDENT FORM -->



				
				
<!-- STUDENT TABLE -->
<div class="panel panel-body">
	<table class="table table-hover">
		<thead>
			<tr>
				<th scope="row">
					<div class="text-right"></div>
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
				{{student.firstname}}&nbsp;{{student.mi}}&nbsp;{{student.lastname}}&nbsp;{{student.suffix}}					
						</a>
						<br/>
						<b>Gender:</b> {{student.gender}}<br/>
						<b>DOB:</b> {{student.date_of_birth|formatDOB}}<br/>
						
						<ul style="list-style:none;padding:0;">
							<li class="text-left" style="padding-left:0.5em;">
								<a href="#" @click.prevent="openModal(guardian_id,student.id)">
									<span class="glyphicon glyphicon-qrcode"></span>&nbsp;-&nbsp;QR Code</span>	
								</a>							
							</li>
						
							<li class="text-left" style="padding-left:0.5em;">			
								<a href="#" @click.prevent="badgeModal(student)">
									<span class="glyphicon glyphicon-user"></span>&nbsp;-&nbsp;ID Card</span>
								</a>								
							</li>
						</ul>
					</div>
					<div class="visible-lg visible-md visible-sm col-md-5 col-sm-5"> 													
						<b>Facility:</b><br/>			      
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
				


<!-- BADGE MODAL -->
			<div class="modal fade" id="badgeModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
								<b>Guardian:</b> {{idcard_pg.firstname}} {{idcard_pg.lastname}}									<br/>
								<b>Special Needs:</b> {{idcard.special_needs}}							  	
						  	</div>
						  </div> 
						 
						</div>
					</div>
			      </div>
			      <div class="modal-footer">
			      	<a type="button" class="btn btn-link" :href="'/student-badge-pdf/'+idcard.id" target="_blank">Download PDF</a>
		      
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
 <!-- MODAL -->



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





		</div>
	</div>
</div>
</template>



<script>
Vue.filter('formatDOB', function(value) {
	/*	
	if formatDOB filter stops working remove 
		require(moment) from app.js 
	and then add 
		import moment from 'moment' 
	right after above this filter definition.
	*/
	
	if(value) 
	{
		return moment(String(value)).format('M/D/YYYY');		
	}
});


export default {
    name: 'guardianstudent',
    mounted() {
        
    },
    props:['guardian_id'],
    data(){
    	return {
        	dateDisplay: '',
        	displayForm: false,
        	displayProfile: false,
        	errors: [],
        	guardian:{},
        	studentGuardians:[],
        	students:[],
	        student:{
	            id: '',
	            
		        classroom:{},
		        classroom_id:'',
		        
	            facility: {},
	            facility_id:'',	   
	                     	
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
	            special_code:'',
            	date_of_birth:'',
            },
            idcard:{},
            idcard_pg:{}
        };
    },
    
    created(){	
        console.log(this.guardian_id);
        		        	    
	    $.get(`/api/guardian/${this.guardian_id}`, guardian => {
		    this.students = guardian.data.students;
		    this.guardian = guardian.data;			    
		   
		    console.log(this.guardian);
		    console.log(this.students);
		});
		
    }, //end created()
    	    
    methods: {
	    resetStudent(){
		    this.student = {
		        id: '',
		        classroom:{},
		        classroom_id:'',
		        
	            facility: {},
	            facility_id:'',	   
	                     	
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
	            special_code:'',
            	date_of_birth:''
		    };
		    
		    this.errors=[];
	    },
	    
	    editStudent(student){
		    
		    //form already open so reset data bc student wasn't saved on server but updated locally
		    if(this.displayForm == true){ 
			    this.resetStudent();
			    this.loadStudents();
		    }		    
		    this.displayForm = true;
		    this.student = student;
		    
		    for(let x=0; x<this.student.guardians.length; ++x){ 
			    if(this.student.guardians[x].id==this.student.primary_guardian_id){
				    this.student.primary_guardian=this.student.guardians[x];
				    break;
			    }   
		    }
		    
		    //Set to indicate PUT Request to VueJS
		    this.student.student_id = student.id;  
		    this.scrollTo('#student-form');
		    
		    //student guardian checkboxes
		    /*
		    var vm=this;
		    student.guardians.forEach(function(guardian){
			    vm.studentGuardians.push(guardian.id);
		    })
		    */			   		    
		},

	    loadStudents() {
		    $.get(`/api/guardian/${this.guardian_id}`, guardian => {
			    this.students = guardian.data.students;
			    this.guardian = guardian.data;
			});		    
	    },
		 
		onCancel(){
		    this.displayForm = false;
		    this.resetStudent();
		    this.loadStudents();
	    },
	    
	    scrollTo(pos){
        	$('html,body,.container').animate({
	        	scrollTop: $(pos).offset().top
			},'slow');
		},
		
	    saveStudent(){	
		    
		    var vm=this;
		    this.student.guardians.forEach(function(guardian){
			    vm.studentGuardians.push(guardian.id);
		    })
		    this.student.guardians = vm.studentGuardians;
		    			       
		    $.ajax({
		        url: '/api/student',
		        type: 'PUT',
		        data: JSON.stringify(this.student),
		        headers: {
					'content-type': 'application/json',
					'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		        },
		        success: data => {
                	if(data.errors){
  						this.errors = data.errors;
			        } else {
				        if(confirm("Student details updated.")){
					        this.displayForm = false;
							this.resetStudent();							
				        }
				        this.loadStudents();		        
			        }
				},
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
		    });	
		    		
	    },
	    
	    
	    
	    //QR Modal Tool
	    openModal(gid,sid){
			$('#qrModal').modal('show');
			let imgUrl = 'http://162.243.170.129/qrcode/'+gid+'/'+sid+'/150';
			$('#qrcode').attr('src',imgUrl);
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
		    
		    for(let x=0; x<this.student.guardians.length; ++x)
		    { 
			    if(this.student.guardians[x].id==this.student.primary_guardian_id)
			    {
				    this.student.primary_guardian=this.student.guardians[x];
				    break;
			    }   
		    }
		    
		    
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
		
		
		
		badgeModal(student){
			$('#badgeModal').modal('show');
			this.idcard = student;
			this.idcard_pg = student.guardians[0];
			console.log("CARD");
			console.log(this.idcard_pg);			
		}
	    
	}    
}
</script>
