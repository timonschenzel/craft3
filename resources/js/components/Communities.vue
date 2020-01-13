<template>
    <div class="flex font-sans h-full justify-center flex-col mt-4">
        <div v-if="! communities.length" class="absolute flex h-screen items-center justify-center w-full" style="top: 0; left: 0;">
            <i class="fas fa-9x fa-spin fa-spinner text-gray-500"></i>
        </div>

        <div v-if="selected" class="flex justify-center">
            <div class="bg-blue-500 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded mb-4 cursor-pointer" @click="selected = null">Terug naar overzicht</div>
        </div>

        <div v-for="community in visibleCommunities" :key="community.id">
            <div class="bg-white max-w-md mx-auto mb-4 border border-grey-light rounded-lg w-full">
                <div class="flex p-4">
                    <div class="w-16 mr-2">
                        <img class="p-2 rounded rounded-full" src="header.jpg">
                    </div>
                    <div class="px-2 pt-2 flex-grow">
                        <header @click="loadCommunityTimeline(community.id)" class="cursor-pointer">
                            <a href="#" class="text-black no-underline">
                                <span class="font-medium">{{ community.title }}</span>
                            </a>
                            <div class="text-xs text-grey flex items-center my-1">
                                <i class="far fa-user mr-1"></i>
                                <span class="mr-1">{{ community.author.username }}</span>
                                <i class="far fa-calendar-alt mr-1"></i>
                                <span>{{ community.dateCreated }}</span>
                            </div>
                        </header>
                        <community :community="community"></community>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="selected">
            <timeline :community="selected" :limit="null"></timeline>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Community from './Community.vue';
import Timeline from './Timeline.vue';

export default {
    components: {
        Community,
        Timeline,
    },

    created()
    {
        graphqlClient.request(`
            {
                entries (section:[community]) {
                    ...on Community {
                        title,
                        url,
                        id,
                        dateCreated @date(as:"d-m-Y"),
                        author {
                            username,
                        }
                    }
                }
            }
      `).then(response => {
            this.communities = response.entries;
        });
 
        axios.get('actions/subscription/subscription').then(({ data }) => {
            Event.$emit('updateSubscriptions', data);
        });
    },

    data()
    {
        return {
            communities: [],
            selected: null,
        }
    },

    methods: {
        loadCommunityTimeline(id)
        {
            this.selected = id;
        }
    },

    computed: {
        visibleCommunities()
        {
            if (! this.selected) {
                return this.communities;
            }

            return this.communities.filter(community => {
                return community.id == this.selected;
            });
        }
    }
}
</script>