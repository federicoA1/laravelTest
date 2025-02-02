<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import LikeButton from './Partials/LikeButton.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, defineProps, reactive } from 'vue';

const props = defineProps({
    posts: {
        type: Array,
        required: true
    }
});

const state = reactive({
    posts: props.posts
});

onMounted(() => {
    Echo.channel("post.1.like")
        .listen('LikeSent', (response) => {
            // Find the post and update its like count
            const post = state.posts.find(post => post.id === response.post.id);
            if (post) {
                post.like_count = response.post.like_count;
            }
        });
});
</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>
       
        <div class="py-12">
          
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h1 class="text-gray-900 mb-4" style="font-size:20pt;"> Posts</h1>
                <div v-for="post in state.posts" :key="post.id" class="pt-3 sm:pt-5">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div>
                                <h2
                                    class="text-xl font-semibold text-black dark:text-white"
                                >
                                    {{ post.title }}
                                </h2>

                                <p class="mt-4 text-sm/relaxed">
                                    {{ post.content }}
                                </p>
                                <div class="mt-4 text-sm/relaxed flex justify-between items-center">
                                    
                                    <LikeButton :likeCount="post.like_count" :postId="post.id" />
                                    <span>{{ new Date(post.created_at).toISOString().split('T')[0] }}</span>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
  props: {
    posts: {
      type: Array,
      required: true
    }
  }
}
</script>
