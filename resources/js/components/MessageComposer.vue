<template>
    <div class="composer">
        <textarea  class="form-control" v-model="message" @keydown.enter="send" placeholder="Type Message..."></textarea>
    </div>
</template>

<script>
    export default {
        name: "MessageComposer",

        props:{

        },

        data(){
            return {
                message: '',
            }
        },

        methods:{
            send(e){
                e.preventDefault();
                if(this.message === ''){
                    return false;
                }

                this.$emit('send',this.message);
                this.message = '';
            }
        }
    }
</script>

<style scoped>

</style>