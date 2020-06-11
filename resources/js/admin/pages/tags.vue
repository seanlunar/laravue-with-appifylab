<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tags <Button  @click="addModal=true"  v-if="isWritePermitted" type="default" size="small"><Icon type="md-add" />AddTag</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Tag Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
								<td>{{tag.id}}</td>
								<td class="_table_name">{{ tag.tagName }}</td>
								<td>{{ tag.created_at }}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(tag, i)"  v-if="isUpdatePermitted">Edit</button>
									<Button  type="error" size="small" v-if="isDeletePermitted" @click="showDeletingModal(tag, i)" :loading="tag.isDeleting">Delete</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
			<!--tag adding model-->
            <Modal v-model="addModal" 
             title="Add Tag"
             :mask-closable = false
             :closable = false
           >
           <Input v-model="data.tagName" placeholder="Enter Tag name.."     />

              <div slot="footer">
                   <Button type="primary" size='small' @click="addTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? ' Adding...' : 'Add Tag'}}</Button>
                      <Button type="error" size='small' @click="addModal=false">Close</Button>
              </div>
            </Modal>
            	<!-- endtag adding model-->
                <!--tag editing model-->
            <Modal v-model="editModal" 
             title="Edit Tag"
             :mask-closable = false
             :closable = false
           >
           <Input v-model="editData.tagName" placeholder="edit Tag name.."     />

              <div slot="footer">
                   <Button type="primary" size='small' @click="editTag" :disabled="isAdding" :loading="isAdding">{{ isAdding ? ' editing...' : 'Edit Tag'}}</Button>
                      <Button type="error" size='small' @click="editModal=false">Close</Button>
              </div>
            </Modal>
            	<!-- endtag editing model-->
                 	<!-- delete  alert
        <modal v-model="showDeleteModal" width="360">
            <p slot="header" style="color:#f60;text-align:center"> 
                <Icon type="ios-information-circle" ></Icon>
                <span>Delelte Confirmation</span>
            </p> 
            <div style="text-align:center">
            <p>
                Are you sure you want to delete tag?.
            </p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag"  >Delete</Button>
            </div>
        </modal>    -->
        <deleteModal> </deleteModal>
			</div>
		</div>
    </div>
</template>

<script>
import deleteModal from '../components/deleteModal.vue'
import {mapGetters} from 'vuex'
export default {
   data(){
       return {
           data :{
               tagName: ''
           },
           addModal : false,
           editModal : false,
           isAdding : false,
           tags:[],
           editData:{
                tagName: ''
           },
           index : -1,
           showDeleteModal: false,
           deleteItem: {},
           isDeleting:false,
           deletingIndex:-1 
       }
   },
   methods : {
      async addTag(){
          if (this.data.tagName.trim()=='') return this.e('Tag name is required')
           const res = await this.callApi('post', 'app/create_tag', this.data)
           if(res.status===201){
               this.tags.unshift(res.data)
               this.s('Tag has been added sucessfuly')
               this.addModal = false
               this.data.tagName = ''
           }else{
             if(res.status==422){
                 if(res.data.errors.tagName){
                     this.e(res.data.errors.tagName[0])
                 }
             }else{
                   this.swr()
             }
           }

       },
        async editTag(){
          if (this.editData.tagName.trim()=='') return this.e('Tag name is required')
           const res = await this.callApi('post', 'app/edit_tag', this.editData )
           if(res.status===200){
               this.tags[this.index].tagName =this.editData.tagName
               this.s('Tag has been edited  sucessfuly')
               this.editModal = false
            
           }else{
             if(res.status==422){
                 if(res.data.errors.tagName){
                     this.e(res.data.errors.tagName[0])
                 }
             }else{
                   this.swr()
             }
           }

       },
       showEditModal(tag, index){
           let Obj = {
               id : tag.id,
               tagName : tag.tagName
           }
          this.editData = Obj
          this.editModal = true
          this.index = index
       },
         async deleteTag(){
             this.isDeleting = true
            const res = await this.callApi('post', 'app/delete_tag',   this.deleteItem)
            if(res.status===200){
                this.tags.splice(this.deletingIndex,1)
                this.s('Tag has been deleted successfuly')
            }else{ 
                this.swr()
            }
            this.isDeleting = false     
            this.showDeleteModal = false
      },
     showDeletingModal(tag, i){
          const  deleteModalObj = {
            showDeleteModal: true,
            deleteUrl:'app/delete_tag',
            data : tag, 
            deletingIndex: i,
            isDeleted: false,
        }
        this.$store.commit('setDeleteModalObj', deleteModalObj)
    
         //this.deleteItem = tag
           //this.deletingIndex = i
           //this.showDeleteModal = true
      },
       
    
   },
 
   async created(){
      
       const res = await this.callApi('get', 'app/get_tags')
       if(res.status==200){
           this.tags = res.data
       } else { 
              this.swr()
       }
   },
    components:{
        deleteModal
   },
   computed:{
     ...mapGetters(['getDeleteModalObj'])
   },
   watch : {
    getDeleteModalObj(obj){
          if(obj.isDeleted){
            this.tags.splice(obj.deletingIndex,1)
       }
    }
   },
 
}
</script>