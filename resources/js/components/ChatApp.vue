<template>
    <div class="chat-app d-flex" >
        <Conversation :contact="selectContact" :messages="messages" @new="saveNewMessage"/>
        <ContactList :contacts="contacts" @selected="SelectConversationWith" />
    </div>
</template>

<script>
    import Conversation from "./Conversation";
    import ContactList from "./ContactList";

    export default {
        name: "ChatApp",

        components:{Conversation, ContactList},

        props: {
            user:{
                type:Object,
                required: true,
            }
        },

        data(){
            return {
                selectContact: null,
                messages: [],
                contacts: [],
            }
        },

        mounted() {
            axios.get('/contacts')
                .then(response=>{
                    this.contacts = response.data;
                    console.log(response.data)
                });


            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage',(e)=>{

                    this.handleIncoming(e.message);
                })
        },

        methods:{
            SelectConversationWith(contact){
                this.updateUnreadCount(contact,true);

                axios.get('/conversation/' + contact.id)
                    .then(response=>{
                        this.messages =response.data;
                        this.selectContact = contact
                    })
            },

            saveNewMessage(message){
                this.messages.push('new',message)
            },

            handleIncoming(message){

                if(this.selectContact && message.from == this.selectContact.id){
                    this.saveNewMessage(message);
                }

                this.updateUnreadCount(message.from_contact,false)
            },

            updateUnreadCount(contact,reset){
                this.contacts = this.contacts.map((single)=>{
                    if(single.id != contact.id){
                        return single
                    }

                    if(reset)
                        single.unread = 0;
                    else
                        single.unread += 1;

                    return single
                })
            }

        },
    }
</script>

<style scoped>

</style>
