<template>
    <div class="flex font-sans h-full justify-center flex-col mt-4">
        <div v-if="! messages.length" class="absolute flex h-screen items-center justify-center w-full" style="top: 0; left: 0;">
            <i class="fas fa-9x fa-spin fa-spinner text-gray-500"></i>
        </div>
        
        <new-message v-show="messages.length" v-if="community" :community="community"></new-message>
        <message v-for="message in messages" :key="message.id" :message="message"></message>
    </div>
</template>

<script>
import NewMessage from './NewMessage.vue';
import Message from './Message.vue';

export default {
    components: {
        NewMessage,
        Message,
    },

    props: {
        limit: {
            default: 10,
        },
        community: {
            default: null,
        }
    },

    created()
    {
        let message = graphqlClient.request(`
            {
                entries (${this.communityFilter}section:[message]${this.limitPart}) {
                    ...on Message {
                        title,
                        url,
                        body,
                        postDate @date(as:"d-m-Y"),
                        community {
                            title,
                            url
                        },
                        author {
                            username,
                        }
                    }
                }
            }
      `).then(response => {
            this.messages = response.entries.map(entry => {
                return {
                    ...entry,
                    community: entry.community[0],
                }
            });
        });
    },

    data()
    {
        return {
            messages: [],
        }
    },

    computed: {
        limitPart()
        {
            if (! this.limit) {
                return '';
            }

            return `, limit:${this.limit}`;
        },

        communityFilter()
        {
            if (! this.community) {
                return '';
            }

            return `relatedTo:[{element:${this.community}}], `;
        }
    }
}
</script>