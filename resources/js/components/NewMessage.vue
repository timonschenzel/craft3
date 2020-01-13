<template>
  <div class="bg-white max-w-md mx-auto mb-4 border border-grey-light rounded-lg w-full">
    <div class="flex pt-4 px-4">
      <div class="w-16 mr-2">
        <img class="p-2 rounded rounded-full" src="header.jpg" />
      </div>
      <div class="px-2 pt-2 flex-grow">
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
          <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="title"
            type="text"
            placeholder="Title"
            v-model="title"
          />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="body">Message</label>
          <textarea
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            id="body"
            placeholder="Message"
            v-model="body"
          ></textarea>
        </div>
        <div class="flex">
          <div
            v-if="! loading"
            class="bg-blue-500 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded mb-4 cursor-pointer"
            @click="store"
          >Post</div>
          <div
            v-else
            class="bg-blue-500 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded mb-4 cursor-pointer"
            @click="store"
          >
            <i class="fas fa-spin fa-spinner text-grey-light"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ["community"],

  data() {
    return {
      title: null,
      body: null,
      loading: false
    };
  },

  methods: {
    store() {
      this.loading = true;
      graphqlClient
        .request(
          `
            mutation createNewEntry($title: String, $body: String, $authorId: Int) {
                upsertMessage(
                    title:$title,
                    body:$body,
                    authorId:$authorId,
                    community:${this.community},
                ) {
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
        `,
          {
            title: this.title,
            body: this.body,
            authorId: this.$root.$data.userId
          }
        )
        .then(({ upsertMessage }) => {
          upsertMessage.community = upsertMessage.community[0];
          this.$parent.$data.messages.unshift(upsertMessage);

          this.title = null;
          this.body = null;

          this.loading = false;

          axios.post('actions/subscription/subscription/new-message', {community_id: this.community_id});
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
};
</script>