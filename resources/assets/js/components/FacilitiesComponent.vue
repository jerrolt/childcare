<template>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0">
		
		
		
		
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
	<option selected="selected">AL</option>
	<option>AK</option>
	<option>AZ</option>
	<option>AR</option><option>CA</option><option>CO</option><option>CT</option><option>DE</option><option>DC</option><option>FL</option><option>GA</option><option>HI</option><option>ID</option><option>IL</option><option>IN</option><option>IA</option><option>KS</option><option>KY</option><option>LA</option><option>ME</option><option>MD</option><option>MA</option><option>MI</option><option>MN</option><option>MS</option><option>MO</option><option>MT</option><option>NE</option><option>NV</option><option>NH</option><option>NJ</option><option>NM</option><option>NY</option><option>NC</option><option>ND</option><option>OH</option><option>OK</option><option>OR</option><option>PA</option><option>RI</option><option>SC</option><option>SD</option><option>TN</option><option>TX</option><option>UT</option><option>VT</option><option>VA</option><option>WA</option><option>WV</option><option>WI</option><option>WY</option>
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
		                    	
		                    <div class="row" style="margin-bottom:0px;">		            
					            <div class="form-group col-md-12 col-sm-12">		                    
			                        <label class="control-label" for="edit-phone">Phone</label>
			                        <div :class="{'has-error': errors && errors.phone}">
			                            <input v-model.lazy="facility.phone"
			                                   type="tel"
			                                   placeholder="Phone Number"
			                                   class="form-control">
			                            <span v-if="errors && errors.phone" class="help-block text-danger alert alert-danger" style="padding:5px;margin-bottom:0px;">{{ errors.phone[0] }}</span>
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
			
			
			
			
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<button type="button" class="btn btn-link btn-sm" @click="addFacility()">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
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
									<button type="button" class="btn btn-link btn-xs" @click="deleteFacility(facility.id)">
										<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										delete
									</button>
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
    },
    methods: {
	    	    
	    prevPage(){
		    let vm = this;
		    let page = this.pagination.current_page - 1;
		    if(this.pagination.current_page > 1){			   			    
			    fetch(`api/facilities?page=${page}`)
				    .then(res=>res.json())
		        	.then(facility => {
			        	this.facilities = facility.data;		        	
			        	vm.setPagination(facility.meta, facility.links);
		        	})
		        	.catch(err => console.log(err));	        		        	
		    }
	    },
	    nextPage(){
		    let vm = this;
		    let page = this.pagination.current_page + 1;  
		    if(this.pagination.current_page < this.pagination.last_page){			    			    
			    fetch(`api/facilities?page=${page}`)
				    .then(res=>res.json())
		        	.then(facility => {
			        	this.facilities = facility.data;		        	
			        	vm.setPagination(facility.meta, facility.links);
		        	})
		        	.catch(err => console.log(err));	        		        	
		    }
	    },
	    currentPage(page){
		    let vm = this;
		    if(this.pagination.current_page != page){			    
				fetch(`api/facilities?page=${page}`)
					.then(res=>res.json())
		        	.then(facility => {
			        	this.facilities = facility.data;		        	
			        	vm.setPagination(facility.meta, facility.links);
		        	})
		        	.catch(err => console.log(err));	        			    
		    }
	    },
	    
	    initFacilities(){
		    let vm = this;		    
		    fetch('api/facilities',{
		            method:'get',
		            headers:{
			            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		            }
	            })
			    .then(res=>res.json())
		        .then(facility => {
			        this.facilities = facility.data;		        	
			        vm.setPagination(facility.meta, facility.links);
		        })
		        .catch(err => console.log(err));
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
	        this.resetFacility();
        },       
        scrollTo(pos){
	        $('html,body').animate({
		        scrollTop: $(pos).offset().top
		    },'slow');
        },
        
        editFacility(facility){
	        this.displayForm = true;
	        this.facility = facility;
	        this.facility.facility_id = facility.id;
			this.scrollTo('#facility-form'); 
        },
        addFacility(){
	        this.displayForm = true;	        
	        this.resetFacility();
	        this.scrollTo('#facility-form');
        },
		sendFacility(){
			//update
			if(this.facility.facility_id)
			{
				fetch('api/facility', {
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
		        
			} else {
				//add new
				fetch('api/facility', {
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
			}
		},
        deleteFacility(id){
	        console.log('deleting facility ' + id);
	        if(confirm('Are you sure you want to delete this facility?')){				
				fetch(`api/facility/${id}`,{
					method: 'delete'
				})
				.then(res => res.json())
				.then(data => {
					alert(`Facility Deleted:\n${data.data.id}: ${data.data.name}`);
					this.currentPage(this.pagination.current_page);
				})
				.catch(err => console.log(err));				
			}			
        }      
    }    //end methods
}
</script>		