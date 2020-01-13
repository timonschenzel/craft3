<template>
    <div class="bg-white max-w-md mx-auto mb-4 border border-grey-light rounded-lg w-full">
        <div class="flex pt-4 px-4">
            <div class="w-16 mr-2">
                <img class="p-2 rounded rounded-full" src="header.jpg">
            </div>
            <div class="px-2 pt-2 flex-grow">
                <header>
                    <a href="#" class="text-black no-underline">
                        <span class="font-medium">{{ message.title }}</span>
                        <span class="font-normal text-grey">@{{ message.community.title }}</span>
                    </a>
                    <div class="text-xs text-grey flex items-center my-1">
                        <i class="far fa-user mr-1"></i>
                        <span class="mr-1">{{ message.author.username }}</span>
                        <i class="far fa-calendar-alt mr-1"></i>
                        <span>{{ message.postDate }}</span>
                    </div>
                </header>
                <article class="py-4 text-grey-600">
                    {{ message.body }}
                </article>
                <footer class="border-t border-grey-lighter text-sm flex">
                    <a href="#"
                        class="block no-underline text-blue flex px-4 py-2 items-center hover:bg-grey-lighter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-thumbs-up h-6 w-6 mr-1 stroke-current">
                            <path
                                d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                            </path>
                        </svg>
                        <span>Liked</span>
                    </a>
                    <a href="#"
                        class="block no-underline text-black flex px-4 py-2 items-center hover:bg-grey-lighter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-message-circle h-6 w-6 mr-1">
                            <path
                                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                            </path>
                        </svg>
                        <span>Reply</span>
                    </a>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props: ['message'],

    data()
    {
        return {
            
        }
    }
}
</script>