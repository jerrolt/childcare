<template>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		
			<h2 id="gAdminTitle">Parents/Guardians</h2>
			
			

<!-- POPUP MODAL IFRAME -->
			<div class="modal fade" tabindex="-1" role="dialog" id="fpscanModal" >
			  <div class="modal-dialog" role="document" style="min-width:1000px;">
			    <div class="modal-content" >
			
			      <div class="modal-body">
			        <iframe id="fpscanFrame" name="fpscanner" frameborder="0" src="#" style="min-width:99%;min-height:400px;">
			        	<p>Your browser does not support iframes.</p>
					</iframe>
			      </div>
			      
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
<!-- END POPUP MODAL IFRAME -->

			
			
			<!-- IMAGE UPLOAD FORM -->
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<div class="thumbnail" id="profile" v-show="displayProfile"  style="background:#FFF;">     
						<div class="caption text-center">
							<h3 id="profile_name"></h3>
							<p>
								<form id="new-file-form" action="#" method="#" @submit.prevent>
									<label class="btn btn-default btn-sm">
										<span class="glyphicon glyphicon-file" aria-hidden="true"></span>
										Browse 
										<input id="img-input" type="file" style="display: none;" ref="file" @change="addImage" @keydown="this.errors=[]">
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



			
			<!-- GUARDIAN FORM -->
			<div class="panel panel-default" id="guardian-form" v-show="displayForm">
				<div class="panel-heading">
					<h4>Guardian Details</h4>
				</div>
				<div class="panel-body">
					<form @submit.prevent="saveGuardian">
						<fieldset>
							<!-- USER LOGIN INFO -->
							<div class="row" style="margin-bottom:0px;">
			                    <div class="form-group col-md-6 col-sm-6 col-xs-8">		                    
			                        <label class="control-label">Email</label>
			                        <div :class="{'has-error': errors && errors.email}">
			                            <input v-model.lazy="guardian.email"
			                                   type="text"
			                                   placeholder="Email"
			                                   class="form-control" :disabled=disableInput>
			                            <span v-if="errors && errors.email" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.email[0] }}</span>
			                        </div>
			                    </div>
			                </div>
			                <div class="row" style="margin-bottom:0px;">   
			                    <div class="form-group col-md-6 col-sm-6 col-xs-8">		                    
			                        <label class="control-label">Password</label>
			                        <div :class="{'has-error': errors && errors.password}">
			                            <input v-model.lazy="guardian.password"
			                                   type="password"
			                                   placeholder="Password"
			                                   class="form-control" :disabled=disableInput>
			                            <span v-if="errors && errors.password" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.password[0] }}</span>
			                        </div>
			                    </div>
			                    <div class="form-group col-md-6 col-sm-6 col-xs-8">		                    
			                        <label class="control-label">Confirm Password</label>
			                        <div :class="{'has-error': errors && errors.password}">
			                            <input v-model.lazy="guardian.password_confirmation"
			                                   type="password"
			                                   placeholder="Confirm Password"
			                                   class="form-control" :disabled=disableInput>
			                            <span v-if="errors && errors.password" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.password[0] }}</span>
			                        </div>
			                    </div>
			                </div>
							<!-- END USER LOGIN INFO password_confirmation -->
					
					
							<!-- NAME INPUT: firstname, lastname, mi, suffix -->	
							<div class="row" style="margin-bottom:0px;">
			                    <div class="form-group col-md-4 col-sm-4 col-xs-8">		                    
			                        <label class="control-label">Firstname</label>
			                        <div :class="{'has-error': errors && errors.firstname}">
			                            <input v-model.lazy="guardian.firstname"
			                                   type="text"
			                                   placeholder="Firstname"
			                                   class="form-control">
			                            <span v-if="errors && errors.firstname" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.firstname[0] }}</span>
			                        </div>
			                    </div>
			                    <div class="form-group col-md-2 col-sm-2 col-xs-4">		                    
			                        <label class="control-label">MI</label>
			                        <div :class="{'has-error': errors && errors.mi}">
			                            <input v-model.lazy="guardian.mi"
			                                   type="text"
			                                   placeholder="mi"
			                                   class="form-control">
			                            <span v-if="errors && errors.mi" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.mi[0] }}</span>
			                        </div>
			                    </div>			                    
			                    <div class="form-group col-md-4 col-sm-4 col-xs-8">		                    
			                        <label class="control-label">Lastname</label>
			                        <div :class="{'has-error': errors && errors.lastname}">
			                            <input v-model.lazy="guardian.lastname"
			                                   type="text"
			                                   placeholder="Lastname"
			                                   class="form-control">
			                            <span v-if="errors && errors.lastname" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.lastname[0] }}</span>
			                        </div>
			                    </div>
			                    <div class="form-group col-md-2 col-sm-2 col-xs-4">		                    
			                        <label class="control-label">Suffix</label>
			                        <div :class="{'has-error': errors && errors.suffix}">
			                            <input v-model.lazy="guardian.suffix"
			                                   type="text"
			                                   placeholder="Suffix"
			                                   class="form-control">
			                            <span v-if="errors && errors.suffix" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.suffix[0] }}</span>
			                        </div>
			                    </div>
			                </div>
							<!-- END NAME INPUT -->
										
					
							<!-- ADDRESS INPUT -->
							<div class="row" style="margin-bottom:0px;">
			                    <div class="form-group col-md-12 col-sm-12">		                    
			                        <label class="control-label">Street Address</label>
			                        <div :class="{'has-error': errors && errors.address}">
			                            <input v-model.lazy="guardian.address"
			                                   type="text"
			                                   placeholder="Street address"
			                                   class="form-control">
			                            <span v-if="errors && errors.address" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.address[0] }}</span>
			                        </div>
			                    </div>
							</div>																
							<div class="row" style="margin-bottom:0px;">
						        <div class="form-group col-md-4 col-sm-4">
						        	<label class="control-label">City</label>	                    			                        
			                        <div :class="{'has-error': errors && errors.city}">			                        	
			                            <input v-model.lazy="guardian.city"
			                                   type="text"
			                                   placeholder="City"
			                                   class="form-control">
			                            <span v-if="errors && errors.city" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.city[0] }}</span>
			                        </div>
			                    </div>			                    		                    		                    
								<div class="form-group col-md-4 col-sm-4">
									<label class="control-label">State</label>	                        
			                        <div  :class="{'has-error': errors && errors.state}">			                        										<select class="form-control" v-model.lazy="guardian.state">
			                            	<option disabled value="">State</option>
			                            	<option v-for="state in states" :value="state.abbreviation">{{state.abbreviation}}</option>
										</select>										
			                            <span v-if="errors && errors.state" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.state[0] }}</span>
			                        </div>
			                    </div>		                    
								<div class="form-group col-md-4 col-sm-4">
									<label class="control-label">Zipcode</label>	                    
			                        <div :class="{'has-error': errors && errors.zipcode}">			                        	
			                            <input v-model.lazy="guardian.zipcode"
			                                   type="text"
			                                   placeholder="Zipcode"
			                                   class="form-control">
			                            <span v-if="errors && errors.zipcode" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{errors.zipcode[0]}}</span>
			                        </div>
			                    </div>
		                    </div>
		                    	
		                    <div class="row" style="margin-bottom:0px;">		            
					            <div class="form-group col-md-4 col-sm-4">		                    
			                        <label class="control-label">Phone</label>
			                        <div :class="{'has-error': errors && errors.phone}">
			                            <input v-model.lazy="guardian.phone"
			                                   type="tel"
			                                   placeholder="Phone Number"
			                                   class="form-control"
			                                   id="input_phone">
			                            <span v-if="errors && errors.phone" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.phone[0] }}</span>
			                        </div>
			                    </div>  
			                    
			                    
			                    
			                    
			                    
			                    <!-- MOBILE CARRIER INFO -->
			                    <div class="form-group col-md-4 col-sm-4">		                    
		                        	<label class="control-label">Mobile Carrier</label>
									<div :class="{'has-error': errors && errors.carrier}">
		                            	<select class="form-control" v-model.lazy="guardian.carrier_id">
			                            	<option disabled value="">Select Carrier</option>
			                            	<option v-for="carrier in carriers" :value="carrier.id">{{carrier.name}}</option>
										</select>
										<span v-if="errors && errors.carrier" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.carrier[0] }}</span>
									</div>
								</div>
																	                    		                    
							</div>
							<!-- END ADDRESS INPUT -->
					
				
										
							<!-- FORM ACTIONS -->
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
							<!-- END FORM ACTIONS -->
							
						</fieldset>
					</form>
				</div>
			</div>	
			<!-- END GUARDIAN FORM -->
			
			



			
			
			

			<!-- GUARDIAN TABLE -->
			<div class="panel panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="row">
								<div class="text-right">
									<button type="button" class="btn btn-link btn-sm" @click="addGuardian()">
									Register a New Guardian
									</button>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(guardian,index) in guardians" v-bind:key="guardian.id" scope="row">
							<td>							
																
								<div class="col-md-2 col-sm-2 col-xs-2">
									<a style="cursor:pointer;" @click.prevent="showSelfie(guardian)">
										<img v-if="guardian.image==null" :id="'s'+guardian.id+'img'" src="/images/guardians/no_img_thumb.jpg" width="40" height="40" >
										<img v-else :id="'s'+guardian.id+'img'" :src="'/images/guardians/thumb_'+guardian.image" width="40" height="40" style="border-radius:3px;">
									</a>
									
									<br/>
									
									<a v-if="guardian.fingerprint_raw==null" @click.prevent="showFingerprint(guardian)" style="cursor:pointer;">add fp</a>
									<a v-else @click.prevent="showFingerprint(guardian)" style="cursor:pointer;">edit fp</a>
								</div>	
								<div class="col-md-5 col-sm-5 col-xs-5">
									
									
									<a @click.prevent="openStatusModal(guardian)" v-if="guardian.user.status=='active'" class="btn btn-success btn-xs">{{guardian.user.status}}</a>
									<a @click.prevent="openStatusModal(guardian)" v-else class="btn btn-danger btn-xs">{{guardian.user.status}}</a>
									&nbsp;
									
									
									
									<a :id="'g'+guardian.id" style="cursor:pointer;" @click.prevent="editGuardian(guardian)">
										{{guardian.firstname}}&nbsp;{{guardian.mi}}&nbsp;{{guardian.lastname}}&nbsp;{{guardian.suffix}}					</a>	
										
										
									<ul class="list-unstyled">									
										<li>
											<span class="glyphicon glyphicon-phone" aria-hidden="true"></span> {{guardian.phone}}
										</li>
										<li>
											<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> {{guardian.user.email}}
										</li>
									</ul>
								</div>
								<div class="visible-lg visible-md visible-sm visible-xs col-md-5 col-sm-5 col-xs-5"> 												<button class="btn btn-primary btn-xs" style="padding:0 3px;" @click="redirStudents(guardian.id)">children</button>
									<ul class="list-unstyled">											      
										<li v-for="(student,index) in guardian.students">
											<span class="glyphicon glyphicon-user" aria-hidden="true"></span> {{student.firstname}} {{student.mi}} {{student.lastname}}
										</li>
									</ul>																					
								</div>

							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- END GUARDIAN TABLE -->
					
			<div class="row">
				<nav aria-label="Page navigation" class="col-md-12 col-sm-12 col-xs-12 text-center">
					<ul class="pagination">
					    <li v-bind:class="[{disabled:!pagination.prev_page_url}]">
					      <span aria-label="Previous" @click="prevPage">
					        <span aria-hidden="true">&laquo;</span>
					      </span>
					    </li>
					    
					    <li v-for="page in pagination.last_page" v-bind:class="[{active:page==pagination.current_page}]">
					    	<span @click="currentPage(page)">{{page}} <span class="sr-only">(current)</span></span>
					    </li>

					    <li v-bind:class="[{disabled:!pagination.next_page_url}]">
					      <span aria-label="Next" @click="nextPage">
					        <span aria-hidden="true">&raquo;</span>
					      </span>
					    </li>
					</ul>
				</nav>	
			</div>
		
		
		
		
		
		



<!-- Status Modal form  -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4>Update Status</h4>
        <span>{{guardian.firstname}} {{guardian.mi}} {{guardian.lastname}}</span>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">

	  				<form @submit.prevent="updateGuardianStatus">
						<fieldset>		
						
							<div class="row" style="margin-bottom:0px;">
								
								<div class="form-group col-md-6 col-sm-6 col-xs-6 text-left">
									<div  :class="{'has-error': errors && errors.primary}">
			                        	<select class="form-control" v-model="user.status">
			                        	
			                        		<option disabled value="">Select a status</option>		                       		
											<option value="active" v-bind:selected="user.status == 'active'">Active</option>
											<option value="disabled" v-bind:selected="user.status === 'disabled'">Disabled</option>
											<option value="pending" v-bind:selected="user.status === 'pending'">Pending</option>
											
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
		
		
		
		
		
		
		
		
		</div>
	</div>
</div>
</template>


<script>
export default {
	data(){
        return {
	        displayForm: false,
	        disableInput: false,
	        
	        pagination:{},
	        
	        noImage: '/images/guardians/no_img.jpg',
        	noImageThumb: '/images/guardians/no_img_thumb.jpg',
        	           
            errors: [],
	        
	        guardians:[],
            guardian:{
	            id: '',
	            	                        	
            	firstname: '',
            	lastname: '',
            	mi:'',
            	suffix:'',
            	
            	address:'',
            	city:'',
            	state:'',
            	zipcode:'',
            	         
				phone:'',
				carrier_id:'',
				
				email:'',
				password:'',
				password_confirmation:''
            },
            //,guardianStudents:[]
            
            displayProfile: false,
            displayFingerprint: false,
            carriers:{},
            states:[],
            user:{}
		};
	},
	
	created(){
		this.loadGuardians();
		this.loadCarriers();
		this.loadStates();
	},
	
	methods:{
		loadGuardians(){
			/***
			*
			* 
				//
				// AJAX - fetch API
				//
				fetch('/api/guardians')
				    .then(res=>res.json())
			        .then(guardian => {
				        this.guardians = guardian.data;
				        this.setPagination(guardian.meta, guardian.links);
			        })
			        .catch(err => console.log(err));
			    
			    //
			    //AJAX - axios API
			    //
			    let formData = new FormData();
	            formData.append('guardian_id', this.guardian.id);
	            formData.append('image', this.$refs.file.files[0]);			    
			    axios.post('/api/guardians', formData, {headers: {'Content-Type': 'multipart/form-data'}})
	            .then(response => {
		            if(response.data.errors){
				        this.errors.image = response.data.errors.guardian;
				        console.log(this.errors.image[0]);
		            } else {
			            this.guardians = response.data.data;
				        this.setPagination(response.data.meta, response.data.links);        
		            }	           		            
	            })
	            .catch(error => console.log(error));
	        *
	        *	    
		    ***/
		    //alert("loading guardians ")
		    
		    
		    var vm = this;
		    $.get('/api/guardians', function(data, status){
			    vm.guardians = data.data;
			    vm.setPagination(data.meta, data.links);
			});    
	    },
	    
	    
	    loadCarriers(){
		    var vm = this;
		    $.get('/api/options/carriers', function(data, status){
			    vm.carriers = data.data;
			});	    
	    },
	    
	    loadStates(){
		    var vm = this;
		    $.get('/api/options/states', function(data, status){
				vm.states = data.data;
			});		    
	    },
	    	    
	    resetGuardian(){
		    this.guardian = {
				id: '',	            	                        	
            	firstname: '',
            	lastname: '',
            	mi:'',
            	suffix:'',            	
            	address:'',
            	city:'',
            	state:'',
            	zipcode:'',           
				phone:'',
				phone_carrier:'',
				email:'',
				password:'',
				password_confirmation:''	    
		    };
		    this.errors = [];
	    },
	    
	    addGuardian(){
		    this.disableInput = false;
		    //this.displayFingerprint = false;
		    this.displayForm = true;
		    this.resetGuardian();
		    this.scrollTo('#guardian-form');
		    //this.guardianStudents=[];
		    //this.loadGuardians();
		    this.currentPage(this.pagination.current_page);	    
	    },
	    
	    editGuardian(guardian){
		    if(this.displayForm == true){ 
			    this.resetGuardian();
			    this.currentPage(this.pagination.current_page);
		    }
		    this.displayProfile = false;
		    //this.displayFingerprint = false;
		    this.disableInput = true;	    
		    this.displayForm = true;
		    
		    this.guardian = guardian;
		    this.guardian.email = guardian.user.email;
		    this.guardian.password = guardian.user.password;
		    this.guardian.guardian_id = guardian.id;
		    this.scrollTo('#guardian-form');		    
	    },
	    
	    
	    
	    
	    
	    
	    //
	    //REPLACE fetch() AJAX - .ajax()  and  $.post()   
	    // https://community.brightspace.com/s/question/0D56100001LkXlACAV/what-is-the-proper-format-for-making-an-ajax-put-request
	    saveGuardian(){
		    var vm = this;
		    
			if(this.guardian.guardian_id){
			    //$.ajax - PUT - update guardian		    
			    /**
			    fetch('/api/guardian', {
			        method: 'put',
			        body: JSON.stringify(this.guardian),
			        headers: {
				        'content-type': 'application/json',
				        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			        }
		        })
		        .then(response=>response.json())
		        .then(data => {
			        if(data.errors){
  						this.errors = data.errors;
			        } else {
				        if(confirm("Guardian details updated.")){
					        this.displayForm = false;
							this.resetGuardian();
				        }
				        //this.loadGuardians();
				        this.currentPage(this.pagination.current_page);			        
			        }
		        })
		        .catch(err => console.log(err));
			    **/
			    
			    
			    $.ajax({
			        url: '/api/guardian',
			        type: 'PUT',
			        data: JSON.stringify(vm.guardian),
			        headers: {
						'content-type': 'application/json',
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			        },
			        success: function( data, textStatus, jQxhr ){
                    	//alert(data.data.firstname);
                    	if(data.errors){
  							vm.errors = data.errors;
  						} else {
                    		if(confirm("Guardian details updated.")){
					       		vm.displayForm = false;
						    	vm.resetGuardian();
							}
							vm.currentPage(vm.pagination.current_page);  						
						}
					},
	                error: function( jqXhr, textStatus, errorThrown ){
	                    console.log( errorThrown );
	                }
			    });
		        
			    
			    
		    } else {
			    //$.post - POST - create guardian			    
			    /**
			    fetch('/api/guardian', {
			        method: 'post',
			        body: JSON.stringify(this.guardian),
			        headers: {
				        'content-type': 'application/json',
				        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			        }
		        })
		        .then(response=>response.json())
		        .then(data => {
			        if(data.errors){
  						this.errors = data.errors;
			        } else {
				        if(confirm("Guardian created")){
					        this.displayForm = false;
							this.resetGuardian();
				        }
				        //this.loadGuardians();	
				        this.currentPage(this.pagination.current_page);			        
			        }
		        })
		        .catch(err => console.log(err));
		        **/
		        
		        
		        $.ajax({
				    url: '/api/guardian',
				    dataType: 'text',
				    type: 'POST',
				    contentType: 'application/json',
				    data: JSON.stringify(vm.guardian),
				    headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},					
				    success: function( data, textStatus, jQxhr ){
						if(data.errors){
  							vm.errors = data.errors;
  						} else {
                    		if(confirm("Guardian profile created.")){
					       		vm.displayForm = false;
						    	vm.resetGuardian();
							}
							vm.currentPage(vm.pagination.current_page);
							//vueobj.loadGuardians();  						
						}																		
				    },
				    error: function( jqXhr, textStatus, errorThrown ){
				        console.log( errorThrown );
				    }
				});
			    			    
			}//END else	    
	    },
	    //END UPDATE AJAX
	    
	    
	    
	    
	    
	    
	    
	    
	    



		/** updateStudentStatus **/
		openStatusModal(data){
			this.guardian=data;
			console.log('STATUS:' + this.guardian.user.status);
			this.user=this.guardian.user;
			$('#statusModal').modal('show');
		},
		closeStatusModal(){
			$('#statusModal').modal('hide');
		},
		updateGuardianStatus(){
				this.guardian.user.status = this.user.status;
			    var data = {
			    	'guardian_id':this.guardian.id,
			    	'user_id':this.user.id,
			    	'status':this.user.status
			    }
			    
			    var saveRequest = {
			    	type: 'PUT',
					url: '/api/guardian/status',
					contentType: 'application/json',
					data: JSON.stringify(data)
				};
				console.log(data);
			
			    var saveMsg = "Guardian status updated.";
				$.ajax(saveRequest).done(data => {
				    if(confirm(saveMsg)){
						$('#statusModal').modal('hide');						
			        }
				}).fail(function (msg) {
				    console.log(msg);
				}).always(function (msg) {
				    console.log(msg);
				});						    		
		},








	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    onCancel(){
		    this.displayForm = false;
		    this.resetGuardian();
		    //this.guardianStudents=[];
		    //this.loadGuardians();
		    this.currentPage(this.pagination.current_page);
	    },
	    scrollTo(pos){
	        $('html,body,.container').animate({
		        scrollTop: $(pos).offset().top
		    },'slow');
        },
        
        redirStudents(guardian_id){
	        window.location = `/admin/students/guardian/${guardian_id}`;
        },

 
	    prevPage(){
		    let vm = this;
		    let page = this.pagination.current_page - 1;
		    if(this.pagination.current_page > 1){	
			    /**		   			    
			    fetch(`/api/guardians?page=${page}`)
				    .then(res=>res.json())
		        	.then(guardian => {
			        	this.guardians = guardian.data;		        	
			        	vm.setPagination(guardian.meta, guardian.links);
		        	})
		        	.catch(err => console.log(err));
		        **/
		        
		        $.get(`/api/guardians?page=${page}`, function(data, status){
					vm.guardians = data.data;		        	
					vm.setPagination(data.meta, data.links);
				});        		        	
		    }
	    },	    	    
	    
	    nextPage(){
		    let vm = this;
		    let page = this.pagination.current_page + 1;  
		    if(this.pagination.current_page < this.pagination.last_page){	
			    /**		    			    
			    fetch(`/api/guardians?page=${page}`)
				    .then(res=>res.json())
		        	.then(guardian => {
			        	this.guardians = guardian.data;		        	
			        	vm.setPagination(guardian.meta, guardian.links);
		        	})
		        	.catch(err => console.log(err));
		        **/
		        
		        $.get(`/api/guardians?page=${page}`, function(data, status){
					vm.guardians = data.data;		        	
					vm.setPagination(data.meta, data.links);
				});     		        	
		    }
	    },	    
	    
	    currentPage(page){
		    let vm = this;
		    //if(this.pagination.current_page != page){	
			    /*		    
				fetch(`/api/guardians?page=${page}`)
					.then(res=>res.json())
		        	.then(guardian => {
			        	this.guardians = guardian.data;		        	
			        	vm.setPagination(guardian.meta, guardian.links);
		        	})
		        	.catch(err => console.log(err));	 
		        */       			    
		    //}
		    
		    
		    $.get(`/api/guardians?page=${page}`, function(data, status){
				vm.guardians = data.data;		        	
			    vm.setPagination(data.meta, data.links);
			});		    
	    },
	    	      
		setPagination(meta, links){
	        let pagination = {
		        current_page: meta.current_page,
		        last_page: meta.last_page,
		        next_page_url: links.next,
		        prev_page_url: links.prev
	        }	        	        
	        this.pagination = pagination;	        
        },       
               
        //IMAGE UPLOAD METHODS
		cancelImgUpload(){
			this.displayProfile = false;
		    $('#profile_img').attr('src',this.noImage);
	    },
	    	    
		showSelfie(guardian){
			this.scrollTo('#profile_img');
			 
			$('#progressbar').css('width','0%');
			
			this.guardian = guardian;
		    this.displayProfile = true;
		    this.guardian.guardian_id = guardian.id;
		    
		    let name = this.guardian.firstname;
		    name += this.guardian.mi ? " "+this.guardian.mi : "";
		    name += " "+this.guardian.lastname;
		    name += this.guardian.suffix ? " "+this.guardian.suffix : "";		    
		    $('#profile_name').text(name);
		    		   		    
		    
		    let src = '/images/guardians/no_img.jpg';
		    if(this.guardian.image!=null)		    		    	
		    	src = '/images/guardians/'+this.guardian.image;
		    $('#profile_img').attr('src',src);		   
		},

		uploadImage(){		
			let formData = new FormData();
            formData.append('guardian_id', this.guardian.id);
            formData.append('image', this.$refs.file.files[0]);
			
			var vm = this;
			                      
            $.ajax({ 
	            url : '/api/guardian/upload',
	            type: 'POST',
	            data : formData,
	         
	            contentType: false,
	            cache: false,
	            processData:false,
	            
	            success: function(data, textStatus, jQxhr){
			        if(data.data.errors){
				        $('div.progress').hide();
				        vm.errors.image = data.data.errors.guardian;
				        console.log(vm.errors.image[0]);
		            } else {
			            console.log(data.data);
			            document.getElementById("cancel-upload").disabled = false;
						vm.guardian = data.data;
			            if(confirm('Profile image update successful')){
						    $('div.progress').hide();
						    $('div.progress').find('progressbar').prop('style','width: 0');
					    }
						vm.currentPage(vm.pagination.current_page);
					}
				},
				
				error: function(jqXhr, textStatus, errorThrown){
		        	console.log(errorThrown)
	        	}	        	
	        });
           
		},
				

		addImage(event){
			console.log(event.target);	
			let tmpImg = URL.createObjectURL(event.target.files[0]);
			document.getElementById("cancel-upload").disabled = true;
			
			//reset errors so the block disappears
			this.errors = [];		
			$('#profile_img').attr('src',tmpImg);
			$('#r'+this.guardian.id+'img').attr('src',tmpImg);
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
		
		
		
		
		
		readFile(e) {
			//if (this.files && this.files[0])
			console.log($('#img_input'))
			if(e.target.files && e.target.files[0])
			{
				var FR= new FileReader();
				FR.onload = function(e){
					//document.getElementById("img_profile").src=e.target.result;
					$('#profile_img').attr('src',e.target.result);
					//document.getElementById("b64").innerHTML=e.target.result;
				};
				//FR.readAsDataURL( this.files[0] );
				FR.readAsDataURL( e.target.files[0] );
				this.uploadImage();
			}
			else
			{
			  alert("in else");
			}
		},
		
		
		
		
		
		
		/** Fingerprint Scanner **/
		showFingerprint(guardian){						
			this.guardian = guardian;		    
		    this.guardian.guardian_id = guardian.id;
			$('#fpscanModal').modal('show');
			$("#fpscanFrame").attr('src','/guardian/scan/' + guardian.id);
			console.log("guardian id: " + guardian.id);
		},
		
		
		
		
		
		
		
		
		/** 
		function fixExifOrientation($img) {
		    $img.on('load', function() {
		        EXIF.getData($img[0], function() {
		            console.log('Exif=', EXIF.getTag(this, "Orientation"));
		            switch(parseInt(EXIF.getTag(this, "Orientation"))) {
		                case 2:
		                    $img.addClass('flip'); break;
		                case 3:
		                    $img.addClass('rotate-180'); break;
		                case 4:
		                    $img.addClass('flip-and-rotate-180'); break;
		                case 5:
		                    $img.addClass('flip-and-rotate-270'); break;
		                case 6:
		                    $img.addClass('rotate-90'); break;
		                case 7:
		                    $img.addClass('flip-and-rotate-90'); break;
		                case 8:
		                    $img.addClass('rotate-270'); break;
		            }
		        });
		    });
		},
		
		
		fixExifOrientation(){
	        EXIF.getData(document.getElementById("profile_img"), function() {
	            console.log('Exif=', EXIF.getTag(this, "Orientation"));
	            switch(parseInt(EXIF.getTag(this, "Orientation"))) {
	                case 2:
	                    document.getElementById("profile_img").addClass('flip'); break;
	                case 3:
	                    document.getElementById("profile_img").addClass('rotate-180'); break;
	                case 4:
	                    document.getElementById("profile_img").addClass('flip-and-rotate-180'); break;
	                case 5:
	                    document.getElementById("profile_img").addClass('flip-and-rotate-270'); break;
	                case 6:
	                    document.getElementById("profile_img").addClass('rotate-90'); break;
	                case 7:
	                    document.getElementById("profile_img").addClass('flip-and-rotate-90'); break;
	                case 8:
	                    document.getElementById("profile_img").addClass('rotate-270'); break;
	            }
	        });
	    }
	    **/	
	    	
	    	
	}//methods
}
</script>