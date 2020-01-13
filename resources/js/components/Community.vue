<template>
    <footer class="border-t border-grey-lighter text-sm flex">
        <div v-if="subscribed" class="block no-underline text-blue flex px-4 py-2 items-center hover:bg-grey-lighter">
            <i class="fas fa-bullhorn mr-2 text-teal-500 font-bold"></i>
            <span @click="unsubscribe" class="cursor-pointer">- Unscribe me</span>
        </div>
        <div v-else class="block no-underline text-blue flex px-4 py-2 items-center hover:bg-grey-lighter">
            <i class="fas fa-bullhorn mr-2"></i>
            <span @click="subscribe" class="cursor-pointer">- Subscribe me</span>
        </div>
    </footer>
</template>

<script>
import axios from 'axios';

export default {

    props: ['community'],

    data()
    {
        return {
            subscribed: false,
        }
    },

    created()
    {
        Event.$on('updateSubscriptions', subscriptions => {
            for (let i in subscriptions) {
                if (subscriptions[i] == this.community.id) {
                    this.subscribed = true;
                }
            }
        });
    },

    methods:
    {
        subscribe()
        {
            axios.post('actions/subscription//subscribe/store', {community_id: this.community.id}).then(({ data }) => {
                this.subscribed = true;
            });
        },

        unsubscribe()
        {
            axios.post('actions/subscription//subscribe/destroy', {community_id: this.community.id}).then(({ data }) => {
                this.subscribed = false;
            });
        }
    },
}
</script>