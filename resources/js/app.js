import Vue from 'vue';
import axios from 'axios';

const graphqlRequest = require('graphql-request');
window.graphqlClient = new graphqlRequest.GraphQLClient('http://craft.test/graphql', { headers: {
    Authorization: 'bearer THGMavgZ5Ol-sLvp8L3lZnzlhNNQd4qugGOlrmKwVN0RIysBes5_GlcBTnkghN4R',
}});

Vue.component('app', require('./components/App.vue').default);

window.Event = new Vue;

const app = new Vue({
    el: '#app',

    created()
    {
        axios.get('api/session').then(({ data }) => {
            this.userId = parseInt(data.id);
            this.username = data.username;
        });
    },

    data: {
        userId: null,
        username: null,
    }
});