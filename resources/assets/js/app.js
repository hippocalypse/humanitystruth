/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('donate-component', require('./components/DonateComponent.vue'));
Vue.component('paginator', require('./../../../Modules/Developers/Resources/assets/js/components/Paginator.vue'));
Vue.component('user-notifications', require('./../../../Modules/Developers/Resources/assets/js/components/UserNotifications.vue'));
Vue.component('avatar-form', require('./../../../Modules/Developers/Resources/assets/js/components/AvatarForm.vue'));
Vue.component('wysiwyg', require('./../../../Modules/Developers/Resources/assets/js/components/Wysiwyg.vue'));
Vue.component('thread-view', require('./../../../Modules/Developers/Resources/assets/js/pages/Thread.vue'));
Vue.component('investigation-view', require('./../../../Modules/Investigations/Resources/assets/js/pages/Investigation.vue'));

// Import the individual js components
import bCard from 'bootstrap-vue/es/components/card/card';
import bCardHeader from 'bootstrap-vue/es/components/card/card-header';
import bCardBody from 'bootstrap-vue/es/components/card/card-body';
import bCardFooter from 'bootstrap-vue/es/components/card/card-footer';
import bTable from 'bootstrap-vue/es/components/table/table';
import bTabs from 'bootstrap-vue/es/components/tabs/tabs';
import bTab from 'bootstrap-vue/es/components/tabs/tab';

// Add components globally:
Vue.component('b-card', bCard);
Vue.component('b-card-header', bCardHeader);
Vue.component('b-card-body', bCardBody);
Vue.component('b-card-footer', bCardFooter);
Vue.component('b-table', bTable);
Vue.component('b-tabs', bTabs);
Vue.component('b-tab', bTab);

//// Or make available to your component or app:
//export default {
//  components: {
//    bCard,
//    bCardHeader,
//    bCardBody,
//    bCardFooter,
//    bTable,
//    bTabs,
//    bTab
//  } 
//  // ...
//}

const app = new Vue({
    el: '#vue_app'
});