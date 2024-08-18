// Import Bootstrap's JavaScript bundle for functionality like modals and dropdowns
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Import custom bootstrap configurations if you have any
import './bootstrap';

// Import Vue and create an app instance
import { createApp } from 'vue';

// Import Vue components
import ExampleComponent from './components/ExampleComponent.vue';

// Create a new Vue application instance
const app = createApp({});

// Register Vue components globally
app.component('example-component', ExampleComponent);

// Mount the Vue application to an HTML element with id="app"
app.mount('#app');
