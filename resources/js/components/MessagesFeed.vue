<template>
    <div class="feed overflow-auto" style="max-height: 500px" ref="feed">
        <ul class="contact" v-if="contact">
            <li v-for="message in messages" class="message">
                <div class="text" :class="` ${message.to == contact.id ? 'sent' : 'received'}`">
                    {{message.text}}
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "MessagesFeed",

        props:{
            messages:{
                type: Array,
            },
            contact: {
                type: Object,
                required: null,
            }
        },

        methods:{
            scrollToBottom(){
                setTimeout(()=>{
                    this.$refs.feed.scrollTop =this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight
                },500);

            }
        },

        watch:{
            contact(contact){
                this.scrollToBottom();
            },

            messages(messages){
                this.scrollToBottom();
            },
        }
    }
</script>

<style scoped>
    .contact{
        background: #4370f11f;
        border-radius: 5px;
        padding: 15px 15px;
        list-style: none;
        font-size: 18px;
        min-height: 480px;
        overflow: hidden;
    }

    .message {
        width: 100%;

    }

    .sent.text{
        background: #cacaca;
        color: black;
        padding: 5px 10px;
        border-radius: 5px;
        margin: 10px;
        text-align: left;
        float: left;
    }

    .received.text {
        text-align: right;
        color: white;
        background: #529fff;
        padding: 5px 10px;
        border-radius: 5px;
        margin: 10px;
        float: right;
    }


    .text{
        max-width: 200px;
        display: inline-block;
        clear: both;
    }

</style>