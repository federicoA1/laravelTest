<template>
    
        <section class="space-y-6">
            <PrimaryButton @click="likePost">♥ Like {{ likeCount }}</PrimaryButton>
            
        </section>
    
    
</template>
<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { nextTick, ref } from 'vue';
import { defineProps } from 'vue';

const props = defineProps({
    likeCount: {
        type: Number,
        required: true
    },
    postId: {
        type: Number,
        required: true
    }

});

const likePost = async () => {
    try {
        const response = await axios.get(`/posts/like`, {
            params: {
                id: props.postId
            }
        });
        if (response.status === 200) {
            //props.likeCount++;
            await nextTick();
        }
    } catch (error) {
        console.error('Error liking the post:', error);
    }
};
</script>