<template>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		
			<h2 id="fcAdminTitle"></h2>
		
			<!-- Classroom Form -->
			<div class="panel panel-default" id="resident-form" v-show="displayForm">
				<div class="panel-heading">
					<h4>Classroom Details</h4>
				</div>
				<div class="panel-body">
					<form @submit.prevent="saveClassroom">
						<fieldset>
							<div class="row" style="margin-bottom:0px;">
								<div class="form-group col-md-6 col-sm-6 col-xs-8">
									<label class="control-label" id="facility_name"></label>
									<p id="facility_address"></p>
									<input v-model.lazy="classroom.facility_id" type="hidden">							
								</div>
							</div>
									                    
		                    <div class="row" style="margin-bottom:0px;">
			                    <div class="form-group col-md-6 col-sm-6 col-xs-8">		                    
			                        <label class="control-label">Classroom Name:</label>
			                        <div :class="{'has-error': errors && errors.name}">
			                            <input v-model.lazy="classroom.name"
			                                   type="text"
			                                   placeholder="Classroom Name"
			                                   class="form-control">
			                            <span v-if="errors && errors.name" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.name[0] }}</span>
			                        </div>
			                    </div>
			                </div>
			                
			                
			                <div class="row">
			                    <div class="form-group col-md-12 col-sm-12 text-right">			                    
			                        <button type="button" class="btn btn-danger btn-sm" @click="onCancel()">
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
		

		
			<!-- Classrooms -->
			<div class="panel panel-body">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="row">
								<div class="text-right">
								<button type="button" class="btn btn-link btn-sm" @click="addClassroom()">
									add classroom
								</button>
								</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(classroom,index) in classrooms" v-bind:key="classroom.id" scope="row">
							<td>									
								<div class="col-md-12 col-sm-12 col-xs-12">
									<button type="button" class="btn btn-danger btn-xs" @click="deleteClassroom(classroom)">
									delete
									</button>
									&nbsp;
									
									<button type="button" class="btn btn-primary btn-xs" @click="showStudents(classroom)">
									children
									</button>
									&nbsp;
									
									<button type="button" class="btn btn-link" @click="editClassroom(classroom)">
										{{classroom.name}}
									</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>		
		
		
		
		
		
		
		
		
		</div>
	</div>
</div>
</template>



<script>
export default {
	props:['facility_id'],
    data() {
        return {           
            displayForm: false,            
            errors: [],            
            facility:{
	            id:'',
            	name: '', 
            	address: '', 
            	city: '',
            	state: '',
            	zipcode: '',
            	phone: ''
            },
            classrooms: [],
            classroom:{
	            id:'',
	            name:'',
	            facility_id:this.facility_id,
	            facility:{}
            },
            pagination:{}
        };
    },
    created(){
	    /*
	    fetch(`/api/classrooms/${this.facility_id}`)
		    .then(res=>res.json())
	        .then(classrooms => {
		        this.classrooms = classrooms.data;
		        this.loadFacility();
	        })
	        .catch(err => console.log(err));
	    */
	    
	    $.get(`/api/classrooms/${this.facility_id}`, classrooms => {
			this.classrooms = classrooms.data;
		    this.loadFacility();
		});
    },
    
    
    methods:{
	    loadClassrooms(){
		    /*
		    fetch(`/api/classrooms/${this.facility_id}`)
			    .then(res=>res.json())
		        .then(classrooms => {
			        this.classrooms = classrooms.data;
			        this.loadFacility();
		        })
		        .catch(err => console.log(err));
			*/
			
			
			$.get(`/api/classrooms/${this.facility_id}`, classrooms => {
				this.classrooms = classrooms.data;
			    this.loadFacility();
			});
	    },
	    

		loadFacility(){
			/*
			fetch(`/api/facility/${this.facility_id}`).then(r=>r.json()).then(facility=>{
				this.facility = facility.data;
				$('label#facility_name').html(`${this.facility.name}:`);
				$('#fcAdminTitle').html(`${this.facility.name}`);
			    $('p#facility_address').html(`${this.facility.address}<br/>${this.facility.city}, ${this.facility.state} ${this.facility.zipcode}`);
			});
			*/
			
			$.get(`/api/facility/${this.facility_id}`, facility => {
				this.facility = facility.data;
				$('label#facility_name').html(`${this.facility.name}:`);
				$('#fcAdminTitle').html(`${this.facility.name}`);
			    $('p#facility_address').html(`${this.facility.address}<br/>${this.facility.city}, ${this.facility.state} ${this.facility.zipcode}`);
			});
		},
	    
	    
	    addClassroom(){		   	   
		    this.resetClassroom();
		    this.displayForm = true; 
	    },
	    
	    
	    editClassroom(classroom){
		    this.classroom = classroom;
		    this.classroom.classroom_id = classroom.id;
		    this.displayForm = true;
	    },
	    
	    
	    
	    
	    deleteClassroom(classroom){
			if(confirm(`Are you sure you want to delete this classroom (${classroom.name})?`)){	
				
				/**			
				fetch(`/api/classroom/${classroom.id}`,{
					method: 'delete'
				})
				.then(res => res.json())
				.then(data => {
					//this.currentPage(this.pagination.current_page);
					this.loadClassrooms();
				})
				.catch(err => console.log(err));
				**/
				
				$.ajax({
				    url: `/api/classroom/${classroom.id}`,
				    type: 'DELETE',
				    success: data => {				        
				        this.loadClassrooms();
					},
	                error: function( jqXhr, textStatus, errorThrown ){
	                    console.log( errorThrown );
	                }
				});
											
			}		    
	    },
	    
	    
	    saveClassroom(){
		    if(this.classroom.classroom_id)
		    {	
			    /**
			    fetch('/api/classroom', {
			        method: 'put',
			        body: JSON.stringify(this.classroom),
			        headers: {
				        'content-type': 'application/json',
				        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			        }
		        })
		        .then(function(res){
			        return res.json();
		        })
		        .then(data => {			        			        
				    if(data.errors){
					    console.log(data.errors);
  						this.errors = data.errors;
			        } else {
				        if(confirm('Classroom details update successful.')){
					        this.displayForm = false;
							this.resetClassroom();
				        }												
			        }
			        this.loadClassrooms();			        			       
		        })
		        .catch(err => console.log(err));			    
			    **/
			    
			    $.ajax({
			        url: '/api/classroom',
			        type: 'PUT',
			        data: JSON.stringify(this.classroom),
			        headers: {
						'content-type': 'application/json',
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			        },
			        success: data => {
                    	if(data.errors){
					    	console.log(data.errors);
							this.errors = data.errors;
				        } else {
					        if(confirm('Classroom details update successful.')){
						        this.displayForm = false;
								this.resetClassroom();
					        }												
				        }
				        this.loadClassrooms();
					},
	                error: function( jqXhr, textStatus, errorThrown ){
	                    console.log( errorThrown );
	                }
			    });
			    
			    
		    } else {
			    
			    /**
				fetch('/api/classroom', {
			        method: 'post',
			        body: JSON.stringify(this.classroom),
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
				        if(confirm("New Classroom created.")){
					        this.displayForm = false;
							this.resetClassroom();
				        }				        				        
			        }
			        this.loadClassrooms();
		        })
		        .catch(err => console.log(err));
		        **/
		        
		        $.ajax({
				    url: '/api/classroom',
				    dataType: 'text',
				    type: 'POST',
				    contentType: 'application/json',
				    data: JSON.stringify(this.classroom),
				    headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},					
				    success: data => {
						if(data.errors){
	  						this.errors = data.errors;
				        } else {
					        if(confirm("New Classroom created.")){
						        this.displayForm = false;
								this.resetClassroom();
					        }				        				        
				        }
				        this.loadClassrooms();																		
				    },
				    error: function( jqXhr, textStatus, errorThrown ){
				        console.log( errorThrown );
				    }
				});
		        		           			    
		    }		    
	    },
	    
	    
	    resetClassroom(){
		    this.errors = [];
		    this.classroom = {
	            id:'',
	            name:'',
	            facility_id: this.facility_id,
	            facility:{}
            }
	    },
	    
	    
	    onCancel(){
		    this.resetClassroom();
		    this.displayForm = false;
		    this.loadClassrooms();
	    },
	    	    
	    
	    showStudents(classroom){
		    //window.location.replace("/admin/students/classroom/" + classroom.id);
		    window.location.href = "/admin/students/classroom/" + classroom.id;
	    }
	    
	    
    }
}
</script>

