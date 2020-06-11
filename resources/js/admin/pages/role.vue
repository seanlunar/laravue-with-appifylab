<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Roles Management <Button 
                    v-if="isWritePermitted"
                     @click="addModal=true" type="default" size="small"><Icon type="md-add" />Add New Role</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Role Type</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(role, i) in roles" :key="i" v-if="roles.length">
								<td>{{role.id}}</td>
								<td class="_table_name">{{ role.rolename  }}</td>
								<td>{{ role.created_at }}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(role, i)" 
                                    v-if="isUpdatePermitted"
                                    >Edit</button>
									<Button  type="error" size="small" 
                                    v-if="isDeletePermitted" 
                                    @click="showDeletingModal(role, i)" :loading="role.isDeleting">Delete</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
			<!--role adding model-->
            <Modal v-model="addModal" 
             title="Add Role"
             :mask-closable = false
             :closable = false
           >
           <Input v-model="data.rolename" placeholder="Enter role name.."     />

              <div slot="footer">
                   <Button type="primary" size='small' @click="addRole" :disabled="isAdding" :loading="isAdding">{{ isAdding ? ' Adding...' : 'Add Role'}}</Button>
                      <Button type="error" size='small' @click="addModal=false">Close</Button>
              </div>
            </Modal>
            	<!-- endRole adding model-->
                <!--Role editing model-->
            <Modal v-model="editModal" 
             title="Edit Role"
             :mask-closable = false
             :closable = false
           >
           <Input v-model="editData.rolename" placeholder="edit Role name.."     />

              <div slot="footer">
                   <Button type="primary" size='small' @click="edit" :disabled="isAdding" :loading="isAdding">{{ isAdding ? ' editing...' : 'Edit Role'}}</Button>
                      <Button type="error" size='small' @click="editModal=false">Close</Button>
              </div>
            </Modal>
            	<!-- endRole editing model-->
                 	<!-- delete  alert
        <modal v-model="showDeleteModal" width="360">
            <p slot="header" style="color:#f60;text-align:center"> 
                <Icon type="ios-information-circle" ></Icon>
                <span>Delelte Confirmation</span>
            </p> 
            <div style="text-align:center">
            <p>
                Are you sure you want to delete Role?.
            </p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteRole"  >Delete</Button>
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
               rolename: ''
           },
           addModal : false,
           editModal : false,
           isAdding : false,
           roles:[],
           editData:{
                rolename: ''
           },
           index : -1,
           showDeleteModal: false,
           deleteItem: {},
           isDeleting:false,
           deletingIndex:-1 
       }
   },
   methods : {
      async addRole(){
          if (this.data.rolename.trim()=='') return this.e('role name is required')
           const res = await this.callApi('post', 'app/create_role', this.data)
           if(res.status===201){
               this.roles.unshift(res.data)
               this.s('role has been added sucessfuly')
               this.addModal = false
               this.data.rolename = ''
           }else{
             if(res.status==422){
                 if(res.data.errors.rolename){
                     this.e(res.data.errors.rolename[0])
                 }
             }else{
                   this.swr()
             }
           }

       },
        async edit(){
          if (this.editData.rolename.trim()=='') return this.e('role name is required')
           const res = await this.callApi('post', 'app/edit_role', this.editData )
           if(res.status===200){
               this.roles[this.index].rolename =this.editData.rolename
               this.s('Role has been edited  sucessfuly')
               this.editModal = false
            
           }else{
             if(res.status==422){
                 if(res.data.errors.rolename){
                     this.e(res.data.errors.rolename[0])
                 }
             }else{
                   this.swr()
             }
           }

       },
       showEditModal(role, index){
           let Obj = {
               id : role.id,
               rolename : role.rolename
           }
          this.editData = Obj
          this.editModal = true
          this.index = index
       },
       
     showDeletingModal(role, i){
          const  deleteModalObj = {
            showDeleteModal: true,
            deleteUrl:'app/delete_role',
            data : role, 
            deletingIndex: i,
            isDeleted: false,
        }
        this.$store.commit('setDeleteModalObj', deleteModalObj)
    
         //this.deleteItem = Role
           //this.deletingIndex = i
           //this.showDeleteModal = true
      },
       
    
   },
 
   async created(){
       const res = await this.callApi('get', 'app/get_roles')
       if(res.status==200){
           this.roles = res.data
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
            this.roles.splice(obj.deletingIndex,1)
       }
    }
   },
 
}
</script>