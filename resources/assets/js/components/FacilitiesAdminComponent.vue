<template>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		
			<h2 id="facilityAdminTitle"></h2>
		
		
			<div class="panel panel-default" id="facility-form" v-show="displayForm">
				<div class="panel-heading">
					<h4>Facility</h4>
				</div>
				<div class="panel-body">
					<form @submit.prevent="sendFacility">
						<fieldset>		                    
		                    <div class="row" style="margin-bottom:0px;">
			                    <div class="form-group col-md-12 col-sm-12">		                    
			                        <label class="control-label" for="edit-name">Name</label>
			                        <div :class="{'has-error': errors && errors.name}">
			                            <input v-model.lazy="facility.name"
			                                   type="text"
			                                   placeholder="Facility name"
			                                   class="form-control">
			                                   
			                            <span v-if="errors && errors.name" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.name[0] }}</span>
			                            
			                        </div>
			                        
			                    </div>
							</div>		                    
						   	<div class="row" style="margin-bottom:0px;">
			                    <div class="form-group col-md-12 col-sm-12">		                    
			                        <label class="control-label" for="edit-address">Street Address</label>
			                        <div :class="{'has-error': errors && errors.address}">
			                            <input v-model.lazy="facility.address"
			                                   type="text"
			                                   placeholder="Street address"
			                                   class="form-control">
			                            <span v-if="errors && errors.address" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.address[0] }}</span>
			                        </div>
			                    </div>
							</div>
																
							<div class="row" style="margin-bottom:0px;">
						        <div class="form-group col-md-4 col-sm-4">
						        	<label class="control-label" for="edit-city">City</label>	                    			                        
			                        <div :class="{'has-error': errors && errors.city}">			                        	
			                            <input v-model.lazy="facility.city"
			                                   type="text"
			                                   placeholder="City"
			                                   class="form-control">
			                            <span v-if="errors && errors.city" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.city[0] }}</span>
			                        </div>
			                    </div>
			                    
			                    		                    		                    
								<div class="form-group col-md-4 col-sm-4">
									<label class="control-label" for="edit-state">State</label>	                        
			                        <div  :class="{'has-error': errors && errors.state}">			                        	
			                        	<select class="form-control" v-model.lazy="facility.state">
			                            	<option disabled value="">State</option>
			                            	<option v-for="state in states" :value="state.abbreviation">{{state.abbreviation}}</option>
										</select>																				
			                            <span v-if="errors && errors.state" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.state[0] }}</span>
			                        </div>
			                    </div>		                    
								<div class="form-group col-md-4 col-sm-4">
									<label class="control-label" for="edit-zipcode">Zipcode</label>	                    
			                        <div :class="{'has-error': errors && errors.zipcode}">			                        	
			                            <input v-model.lazy="facility.zipcode"
			                                   type="text"
			                                   placeholder="Zipcode"
			                                   class="form-control">
			                            <span v-if="errors && errors.zipcode" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{errors.zipcode[0]}}</span>
			                        </div>
			                    </div>
		                    </div>
		                    	
		                    <!--  PHONE AND MOBILE CARRIER ROW -->	
		                    <div class="row" style="margin-bottom:0px;">		            
					            <div class="form-group col-md-4 col-sm-4">		                    
			                        <label class="control-label" for="edit-phone">Phone Number</label>
			                        <div :class="{'has-error': errors && errors.phone}">
			                            <input v-model.lazy="facility.phone"
			                                   type="tel"
			                                   placeholder="Phone Number"
			                                   class="form-control">
			                            <span v-if="errors && errors.phone" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.phone[0] }}</span>
			                        </div>
			                    </div>
			                    
								<!-- MOBILE CARRIER INFO -->
			                    <div class="form-group col-md-4 col-sm-4">		                    
		                        	<label class="control-label">Mobile Carrier</label>
									<div :class="{'has-error': errors && errors.carrier}">
		                            	<select class="form-control" v-model.lazy="facility.carrier_id">
			                            	<option disabled value="">Select Carrier</option>
			                            	<option v-for="carrier in carriers" :value="carrier.id">{{carrier.name}}</option>
										</select>
										<span v-if="errors && errors.carrier" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.carrier[0] }}</span>
									</div>
								</div>			                    
			                                        		                    
							</div>
							<!-- END MOBILE PHONE AND CARRIER ROW -->	
							
							
							
							
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
			
			
			
			
			
			<div class="panel panel-default">
				<div class="panel-heading text-right">
					<button type="button" class="btn btn-link btn-sm" @click="addFacility()">
						create facility
					</button>
				</div>
				<div class="panel-body">		
					<div class="row" v-for="(facility, index) in facilities" v-bind:key="facility.id">
						<div class="col-md-12 col-sm-12 col-xs-12" style="border-radius:0px; border-bottom:1px solid #d3e0e9; ">								
								<div class="well-sm">
									<strong>{{facility.name}}</strong>
									</br>													  
								  	{{facility.address}}<br>
								  	{{facility.city}}, {{facility.state}} {{facility.zipcode}}<br>
								  	<span class="glyphicon glyphicon-phone" aria-hidden="true"></span> {{facility.phone}}
								  	<br/>
								
									<button type="button" class="btn btn-link btn-xs" @click="editFacility(facility)">
										<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
										edit
									</button>
									
									
									<button v-if="(facility.classrooms.length>0 || facility.students.length>0 || facility.timecards!=null)" type="button" class="btn btn-link btn-xs" @click="deleteFacility(facility.id)" disabled>
										<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										delete
									</button>
									<button v-else type="button" class="btn btn-link btn-xs" @click="deleteFacility(facility.id)">
										<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										delete
									</button>
									
									<a v-if="facility.classrooms.length>0" v-bind:href="'/admin/classrooms/'+facility.id" class="btn btn-link btn-xs">
										({{facility.classrooms.length}}) classrooms
									</a>
									<a v-else v-bind:href="'/admin/classrooms/'+facility.id" class="btn btn-link btn-xs" style="color:red;">
										add classrooms
									</a>
								</div>												    						
						</div>	
					</div>
					
					
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
	
	
	
				</div>
			</div>
			
			
						
		</div>
	</div>
</div>
</template>

<script>
export default {
    data() {
        return {
           
            displayForm: false,            
            errors: [],           

			carriers:[],
			states:[],
			
            facilities: [],
            facility:{
	            id:'',
            	name: '', 
            	address: '', 
            	city: '',
            	state: '',
            	zipcode: '',
            	phone: ''
            },
            pagination:{}
        };
    },
    created() {
       this.initFacilities();      
       this.resetFacility();
       this.loadCarriers();
       this.loadStates();
    },
    methods: {
	    	    
	    prevPage(){
		    let vm = this;
		    let page = this.pagination.current_page - 1;
		    if(this.pagination.current_page > 1){	
			    /*		   			    
			    fetch(`/api/facilities?page=${page}`)
				    .then(res=>res.json())
		        	.then(facility => {
			        	this.facilities = facility.data;		        	
			        	vm.setPagination(facility.meta, facility.links);
		        	})
		        	.catch(err => console.log(err));
		        */
		        	
		        $.get(`/api/facilities?page=${page}`, facility => {
					this.facilities = facility.data;		        	
			        this.setPagination(facility.meta, facility.links);
				});	        		        	
		    }
	    },
	    nextPage(){
		    let vm = this;
		    let page = this.pagination.current_page + 1;  
		    if(this.pagination.current_page < this.pagination.last_page){		
			    /*	    			    
			    fetch(`/api/facilities?page=${page}`)
				    .then(res=>res.json())
		        	.then(facility => {
			        	this.facilities = facility.data;		        	
			        	vm.setPagination(facility.meta, facility.links);
		        	})
		        	.catch(err => console.log(err));	
		        */
		        
		        $.get(`/api/facilities?page=${page}`, facility => {
					this.facilities = facility.data;		        	
			        this.setPagination(facility.meta, facility.links);
				});	        		        	
		    }
	    },
	    currentPage(page){
		    let vm = this;
		    //if(this.pagination.current_page != page){	
			    /*		    
				fetch(`/api/facilities?page=${page}`)
					.then(res=>res.json())
		        	.then(facility => {
			        	this.facilities = facility.data;		        	
			        	vm.setPagination(facility.meta, facility.links);
		        	})
		        	.catch(err => console.log(err));
		        */
		        
		       	$.get(`/api/facilities?page=${page}`, facility => {
					this.facilities = facility.data;		        	
			        vm.setPagination(facility.meta, facility.links);
				});	        			    
		    //}
	    },
	    
	    initFacilities(){
		    let vm = this;	
		    
		    /*	    
		    fetch('/api/facilities',{
		            method:'get',
		            headers:{
			            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		            }
	            })
			    .then(res=>res.json())
		        .then(facility => {
			        $('#facilityAdminTitle').html('Facility Locations'); //page title
			        this.facilities = facility.data;		        	
			        vm.setPagination(facility.meta, facility.links);			        
		        })
		        .catch(err => console.log(err));
		    */
		    
		    $.get('/api/facilities', facility => {
				$('#facilityAdminTitle').html('Facility Locations'); //page title
				this.facilities = facility.data;		        	
				this.setPagination(facility.meta, facility.links);
			});	
	    },
           
        
        loadCarriers(){
	        /*
			fetch('/api/options/carriers')
			    .then(res=>res.json())
		        .then(carrier => {
			        this.carriers = carrier.data;
		        })
		        .catch(err => console.log(err));
		    */
		    
		    $.get('/api/options/carriers', carrier => {
				this.carriers = carrier.data;
			});	    
	    },
	    
	    
        loadStates(){
	        /*
			fetch('/api/options/states')
			    .then(res=>res.json())
		        .then(states => {
			        this.states = states.data;
		        })
		        .catch(err => console.log(err));
		    */
		    
		    $.get('/api/options/states', states => {
				this.states = states.data;
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
        
        resetFacility(){
            this.facility = {
	            id:'',
            	name: '', 
            	address: '', 
            	city: '',
            	state: '',
            	zipcode: '',
            	phone: ''
            };
            this.errors = [];
        },
        onCancel(){	        	        
	        this.displayForm = false;
	        this.currentPage(this.pagination.current_page);
	        this.resetFacility();
        },       
        scrollTo(pos){
	        $('html,body').animate({
		        scrollTop: $(pos).offset().top
		    },'slow');
        },
        
        editFacility(facility){	        
	        this.displayForm = true;
	        this.currentPage(this.pagination.current_page);
	        this.resetFacility();
	        this.facility = facility;
	        this.facility.facility_id = facility.id;
			this.scrollTo('#facility-form'); 
        },
        addFacility(){	        
	        this.displayForm = true;
	        this.currentPage(this.pagination.current_page);	        
	        this.resetFacility();
	        this.scrollTo('#facility-form');
        },
        
        
        
		sendFacility(){
			//update
			if(this.facility.facility_id)
			{
				/*
				fetch('/api/facility', {
			        method: 'put',
			        body: JSON.stringify(this.facility),
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
  						this.errors = data.errors;
			        } else {
				        if(confirm('Facility update successful')){
					        this.displayForm = false;
							this.resetFacility();
				        }
				        this.currentPage(this.pagination.current_page);				
			        }			        			       
		        })
		        .catch(err => console.log(err));
		        */
		        
		        $.ajax({
			        url: '/api/facility',
			        type: 'PUT',
			        data: JSON.stringify(this.facility),
			        headers: {
						'content-type': 'application/json',
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			        },
			        success: data => {
                    	//alert(data.data.firstname);
                    	if(data.errors){
	  						this.errors = data.errors;
				        } else {
					        if(confirm('Facility update successful')){
						        this.displayForm = false;
								this.resetFacility();
					        }
					        this.currentPage(this.pagination.current_page);				
				        }
					},
	                error: function( jqXhr, textStatus, errorThrown ){
	                    console.log( errorThrown );
	                }
			    });
			} else {
				//add new
				/*
				fetch('/api/facility', {
			        method: 'post',
			        body: JSON.stringify(this.facility),
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
				        if(confirm("New facility created")){
					        this.initFacilities();
							this.displayForm = false;
							this.resetFacility();
				        }
				        this.currentPage(this.pagination.current_page);			        
			        }
		        })
		        .catch(err => console.log(err));
		        */
		        
		        $.ajax({
				    url: '/api/facility',
				    dataType: 'text',
				    type: 'POST',
				    contentType: 'application/json',
				    data: JSON.stringify(this.facility),
				    headers: {
						'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					},					
				    success: data => {
						if(data.errors){
  							this.errors = data.errors;
				        } else {
					        if(confirm("New facility created")){
						        this.initFacilities();
								this.displayForm = false;
								this.resetFacility();
					        }
					        this.currentPage(this.pagination.current_page);			        
				        }																		
				    },
				    error: function( jqXhr, textStatus, errorThrown ){
				        console.log( errorThrown );
				    }
				});
			}//end POST
		},
		
		
		
        deleteFacility(id){
	        console.log('deleting facility ' + id);
	        if(confirm('Are you sure you want to delete this facility?')){	
		        /*			
				fetch(`/api/facility/${id}`,{
					method: 'delete'
				})
				.then(res => res.json())
				.then(data => {
					alert(`Facility Deleted:\n${data.data.id}: ${data.data.name}`);
					this.currentPage(this.pagination.current_page);
				})
				.catch(err => console.log(err));	
				*/
				
				$.ajax({
				    url: `/api/facility/${id}`,
				    type: 'DELETE',
				    success: data => {
				        console.log(`Facility Deleted:\n${data.data.id}: ${data.data.name}`);
				        this.currentPage(this.pagination.current_page);
				    }
				});			
			}			
        }      
    }    //end methods
}
</script>		