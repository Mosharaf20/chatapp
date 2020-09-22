<template>
    <div class="contact-list border-left border-secondary ">
        <ul class="list-unstyled ml-3 overflow-auto" style="max-height: 600px">
            <li class="d-flex mb-1 align-items-lg-center bg-light position-relative" style="max-height: 120px" v-for="contact in sortedContacts" @click="selectContact(contact)" :class="{'selected' : contact === selected}">
                <div class="avatar">
                    <img class="rounded-circle" style="width: 60px; height: 60px"  :src="contact.avatar" alt="">
                </div>
                <div class="contact  px-3 mt-2 text-left">
                    <p class="m-0 h5">{{contact.name}}</p>
                    <p class="">{{contact.email}}</p>
                </div>
                <span class="unread" v-if="contact.unread">{{contact.unread}}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "ContactList",

        props:{
            contacts: {
                type: Array,
                default: [],
            }
        },

        data(){
            return {
                selected: this.contacts.length ? this.contacts[0] : null,
            }
        },

        methods: {
            selectContact(contact){
                this.selected = contact;

                this.$emit('selected',contact);
            }
        },

        computed:{
            sortedContacts(){
                return _.sortBy(this.contacts,(contact)=>{
                    if(this.selected == contact){
                        return  Infinity
                    }
                    return contact.unread;
                }).reverse();
            }
        }
    }
</script>

<style scoped>
    .contact-list ul li{
        border-radius: 5px;
        padding:5px 10px
    }

     .contact-list ul li:hover{
         cursor: pointer;
         background-color: #cddaff !important;
         color: #1b1e21;
         transition:all .5s;
     }

    .selected{
        background: #d9d9d9b8!important
    }

    .unread{
        background: #d92210;
        color: white;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: 11px;
        text-align: center;
        font-weight: 900;
        position: absolute;
        right: 12px;
        top: 10px;
    }
</style>