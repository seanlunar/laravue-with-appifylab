<template>
    <div>
       <div class="content">
			<div class="container-fluid">
				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Users <Button  @click="addModal=true" v-if="isWritePermitted"  type="default" size="small"><Icon type="md-add" />Add Admin</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th> Name</th>
								<th>email</th>
								<th>Role Id</th>
                                	<th>Created at</th>
                                    	<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(user, i) in users" :key="i" v-if="users.length">
								<td>{{user.id}}</td>
								<td class="_table_name">{{ user.FullName }}</td>
								<td>{{ user.email }}</td>
                                <td>{{ user.role_id }}</td>
                                <td>{{ user.created_at }}</td>
								<td>
									<Button type="info" v-if="isUpdatePermitted" size="small" @click="showEditModal(user, i)" >Edit</button>
									<Button  type="error" size="small" v-if="isDeletePermitted"  @click="showDeletingModal(user, i)" :loading="user.isDeleting">Delete</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
			<!--user adding model-->
            <Modal v-model="addModal" 
             title="Add User"
             :mask-closable = false
             :closable = false
           >
           <div class="space">
              <Input type="text" v-model="data.FullName" placeholder="Enter Fullname.." />
           </div>
           <div class="space">
              <Input type="email" v-model="data.email" placeholder="Enter email.." />
           </div>
           <div class="space">
             <Input type="password" v-model="data.password" placeholder="Enter password.." />
           </div>
           <div class="space">
            <Select v-model="data.role_id"  placeholder="select admintype " >
            <Option  :value="r.id" v-for="(r,i) in roles" :key="i" v-if="roles.length" > {{ r.rolename }}</Option>
                   <!-- <Option value="editor"> Editor</Option> -->
            </Select> 
           </div>
          
           
           

              <div slot="footer">
                   <Button type="primary" size='small' @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{ isAdding ? ' Adding...' : 'Add Admin'}}</Button>
                      <Button type="error" size='small' @click="addModal=false">Close</Button>
              </div>
            </Modal>
            	<!-- enduser adding model-->
                <!--user editing model-->
            <Modal v-model="editModal" 
             title="Edit User"
             :mask-closable = false
             :closable = false
           >
             <div class="space">
              <Input type="text" v-model="editData.FullName" placeholder="Enter Fullname.." />
           </div>
           <div class="space">
              <Input type="email" v-model="editData.email" placeholder="Enter email.." />
           </div>
           <div class="space">
             <Input type="password" v-model="editData.password" placeholder="Enter password.." />
           </div>
           <div class="space">
                  <Select v-model="editData.role_id"  placeholder="select admintype " >
            <Option  :value="r.id" v-for="(r,i) in roles" :key="i" v-if="roles.length" > {{ r.rolename }}</Option>
                   <!-- <Option value="editor"> Editor</Option> -->
            </Select> 
           </div> 
              <div slot="footer">
                   <Button type="primary" size='small' @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{ isAdding ? ' editing...' : 'Edit Admin'}}</Button>
                      <Button type="error" size='small' @click="editModal=false">Close</Button>
              </div>
            </Modal>
            	<!-- enduser editing model-->
                 	<!-- delete  alert
        <modal v-model="showDeleteModal" width="360">
            <p slot="header" style="color:#f60;text-align:center"> 
                <Icon type="ios-information-circle" ></Icon>
                <span>Delelte Confirmation</span>
            </p> 
            <div style="text-align:center">
            <p>
                Are you sure you want to delete user?.
            </p>
            </div>
            <div slot="footer">
                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteuser"  >Delete</Button>
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
               FullName: '',
               email: '',
               password: '',
               role_id: null
           },
           addModal : false,
           editModal : false,
           isAdding : false,
           users:[],
           editData:{
                FullName: '',
               email: '',
               password: ''
           },
           index : -1,
           showDeleteModal: false,
           deleteItem: {},
           isDeleting:false,
           deletingIndex:-1 ,
           roles: []
       }
   },
   methods : {
      async addAdmin(){
           if (this.data.FullName.trim()=='') return this.e('FullName name is required')  
           if (this.data.email.trim()=='') return this.e('email is required')
           if (this.data.password.trim()=='') return this.e('password is required')
           if (!this.data.role_id) return this.e('role_id is required') 
           
           const res = await this.callApi('post', 'app/create_user', this.data)
           if(res.status===201){
               this.users.unshift(res.data)
               this.s('admin user has been added sucessfuly')
               this.addModal = false
            //    this.data.userName = ''
           }else{  
             if(res.status==422){
                 console.log(res.data.errors)
                 for(let i in res.data.errors){
                       this.e(res.data.errors[i])
                 }
             }else{
                   this.swr()
             }
           }

       },
        async editAdmin(){
           if (this.editData.FullName.trim()=='') return this.e('FullName name is required')  
           if (this.editData.email.trim()=='') return this.e('email is required')
           if (!this.editData.role_id) return this.e('role_id is required')      
           const res = await this.callApi('post', 'app/edit_user', this.editData )
           if(res.status===200){
               this.users[this.index] = this.editData
               this.s('Admin has been edited  sucessfuly')
               this.editModal = false
            
           }else{
             if(res.status==422){
                 for(let i in res.data.errors){
                     this.e(res.data.errors[i])
                 }
             }else{ 
                   this.swr()
             }
           }

       },
       showEditModal(user, index){
           let Obj = {
               id : user.id,
               FullName : user.FullName,
               email: user.email,
               role_id:user.role_id
           }
          this.editData = Obj
          this.editModal = true
          this.index = index
       },
    //      async deleteuser(){
    //          this.isDeleting = true
    //         const res = await this.callApi('post', 'app/delete_user',   this.deleteItem)
    //         if(res.status===200){
    //             this.users.splice(this.deletingIndex,1)
    //             this.s('user has been deleted successfuly')
    //         }else{ 
    //             this.swr()
    //         }
    //         this.isDeleting = false     
    //         this.showDeleteModal = false
    //   },
     showDeletingModal(user, i){
          const  deleteModalObj = {
            showDeleteModal: true,
            deleteUrl:'app/delete_user',
            data : user, 
            deletingIndex: i,
            isDeleted: false,
        }
        this.$store.commit('setDeleteModalObj', deleteModalObj)
    
         //this.deleteItem = user
           //this.deletingIndex = i
           //this.showDeleteModal = true
      },
       
    
   },
 
   async created(){
     const [res, resRole] = await Promise.all([
          this.callApi('get', 'app/get_users'),
          this.callApi('get', 'app/get_roles')
     ])

    
       if(res.status==200){
           this.users = res.data
       } else { 
              this.swr()
       }
       if(resRole.status==200){
           this.roles = resRole.data
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
            this.users.splice(obj.deletingIndex,1)
       }
    }
   },
 
}
</script>