require('./bootstrap');

window.Vue = require('vue');

import { createApp} from "vue";

//import ResendMembershipInvitation from "../components/admin/ResendMembershipInvitation";

//console.log('from inside app.js source');

createApp({
    components: {
  //      ResendMembershipInvitation
    }
}).mount('#app');
