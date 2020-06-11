<template>
    <div>
              	<!-- delete  alert-->
         <modal
          :value="getDeleteModalObj.showDeleteModal"
          :mask-closable="false"
          :closable="false"

           width="360">
            <p slot="header" style="color:#f60;text-align:center"> 
                <Icon type="ios-information-circle" ></Icon>
                <span>Delete Confirmation</span>
            </p> 
            <div style="text-align:center">
            <p>
                Are you sure you want to delete ?.
            </p>
            </div>
            <div slot="footer">
                <Button type="default" @click="closeModal">Close</Button>
                   <Button type="error" :disabled="isDeleting" @click="deleteTag">Delete</Button>
            </div>
        </modal>    
    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return {
            isDeleting : false,
        }
    },
    methods:{
              async deleteTag(){
                this.isDeleting = true
                const res = await this.callApi('post', this.getDeleteModalObj.deleteUrl,   this.getDeleteModalObj.data)
                if(res.status === 200){
                  
                    this.s('file has been deleted successfuly')
                    this.$store.commit('setDeleteModal', true)
                }else{ 
                    this.swr()
                    this.$store.commit('setDeleteModal', false)
                }
                    isDeleting : false
      },
      closeModal(){
         this.$store.commit('setDeleteModal', false)
      }
    },
    computed : {
        ...mapGetters(['getDeleteModalObj'])
    }
}
</script>