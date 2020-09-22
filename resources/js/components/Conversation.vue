<template>
    <div class="conversation d-flex flex-column justify-content-between flex-grow-1 mr-3" >
        <h2>{{contact ? contact.name : 'Select a Contact'}}</h2>
        <MessagesFeed :contact="contact" :messages="messages" />
        <MessageComposer @send="sendMessage"/>
    </div>
</template>

<script>
    import MessagesFeed  from './MessagesFeed';
    import MessageComposer  from './MessageComposer';

    export default {
        name: "Conversation",

        components:{MessageComposer, MessagesFeed},

        props:{
            contact: {
                type:Object,
                default: null,
            },

            messages: {
                type: Array,
                default: [],
            }
        },

        methods:{
            sendMessage(message){
                if(!this.contact){
                    return false;
                }

                axios.post('/conversation/send',{
                    'contact_id': this.contact.id,
                    'text': message,
                }).then(response=>{
                    this.$emit('new',response.data)
                })
            }
        }

    }
</script>

<style scoped>

</style>