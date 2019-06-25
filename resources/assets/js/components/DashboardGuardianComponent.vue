<template>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                
                
                
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
						      <th scope="col">Facility</th>
						      <th scope="col">In</th>
						      <th scope="col">Out</th>
						      <th scope="col">Total</th>
						    </tr>
						  </thead>
						  <tbody>
						    <tr v-for="(student, key) in students">	
						    							
								<td scope="col" style="width:50px;">
									<div v-if="student.status=='in' && student.timecards[0].confirmed_at==null" class="flagpending"></div>
									<div v-else-if="student.status=='in'" class="flagin"></div>
									<div v-else class="flagout"></div>
								</td>
								<td style="width:150px;">						      	
									{{student.name}}<br/>
									<img v-if="student.timecards[0] && student.timecards[0].image" :id="'s'+key+'img'" :src="'/images/students/thumb_'+student.timecards[0].image" width="40" height="40" class="img-thumbnail">
									<img v-else :id="'s'+key+'img'" src="/images/students/no_img_thumb.jpg"  width="60" height="60" class="img-thumbnail">									
								</td>
								<td style="width:150px;">{{student.facility.name}}</td>
								<td style="width:100px;">
									<span v-if="student.status=='in'">{{student.timecards[0].action_at}}</span>
									<span v-else>{{student.timecards[1].action_at}}</span>
								</td>
								<td style="width:100px;">									
									<span v-if="student.status=='in'"></span>
									<span v-else>{{student.timecards[0].action_at}}</span>
								</td>
								<td>{{student.total}}</td>
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
    name: 'dashboardguardian',
    
    mounted() {
        console.log('--- DashboardGuardian Component - Using-> Guardian id:' + this.guardian_id);       
        this.setDateDisplay();
    },
    
    props:['guardian_id'],
    
    data(){
        return {
	        today:'', 
	        dateDisplay: '',
	        total_checked_in: 0,
	        students: []
	    };
    },
    
    created(){
	    //handle checkouts for the prev day 		
		$.get(`/api/timecard/sync/${this.guardian_id}`);  
		
		$.get(`/api/timecard/guardian-summary/${this.guardian_id}`, data => {
		    console.log(data);
		    this.students = data.students;
		    this.total_checked_in = data.total_in;
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
		   this.today = new Date();
		   var m = 'Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec'.split(' ')[this.today.getMonth()];	
		   var day = 'Sun Mon Tue Wed Thu Fri Sat'.split(' ')[this.today.getDay()];
		   this.dateDisplay = day + " " + m + " " + this.today.getDate().toString() + ", " + this.today.getFullYear();
	    }
	}
}
</script>
