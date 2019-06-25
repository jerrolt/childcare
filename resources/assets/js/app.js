
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');
window.moment = require('moment');
window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('facilities-component', require('./components/FacilitiesComponent.vue'));
Vue.component('facilitiesadmin-component', require('./components/FacilitiesAdminComponent.vue'));

//classroom admin comp
Vue.component('facilityclassroomsadmin-component', require('./components/FacilityclassroomsAdminComponent.vue'));

//students
Vue.component('studentsadmin-component', require('./components/StudentsAdminComponent.vue'));
Vue.component('guardianstudentsadmin-component', require('./components/GuardianstudentsAdminComponent.vue'));

Vue.component('guardianstudent-component', require('./components/GuardianStudentComponent.vue'));

Vue.component('classroomstudentsadmin-component', require('./components/ClassroomstudentsAdminComponent.vue'));

//Guardians
Vue.component('guardiansadmin-component', require('./components/GuardiansAdminComponent.vue'));

Vue.component('guardianscheckin-component', require('./components/GuardiansCheckinComponent.vue'));

//Guardian's Dashboard
Vue.component('dashboardguardian-component', require('./components/DashboardGuardianComponent.vue'));


//Admin's Dashboard 
Vue.component('dashboardadmin-component', require('./components/DashboardAdminComponent.vue'));


//Admin's view of attendance records
Vue.component('activityadmin-component', require('./components/ActivityAdminComponent.vue'));
Vue.component('activityguardian-component', require('./components/ActivityGuardianComponent.vue'));

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
