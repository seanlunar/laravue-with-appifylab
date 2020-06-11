<template>
    <div class="container-fluid">
       <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4" >
           <div class="login_header">
               <h1>Login to the Dashboard</h1>
           </div>
             <div class="space">
              <Input type="email" v-model="data.email"  placeholder="Enter email.." />
           </div>
           <div class="space">
              <Input type="password" v-model="data.password" placeholder="Enter password.." />
           </div>
           <div class="login_footer">
               <Button @click="login"  :disabled="this.isLogging" :loading="isLogging " type="primary">{{isLogging ? 'Loging....': 'login'}}</Button>
           </div>
       </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            data : {
                email: '',
                password: ''
            },
            isLogging : false,
        }
    },
    methods : {
        async login(){
              if (this.data.email.trim()=='') return this.e('email  is required')  
              if (this.data.password.trim()=='') return this.e('password is required')
              if (this.data.password.length < 6) return this.e('Incorect login details')
              this.isLogging = true
              const res = await this.callApi('post', 'app/admin_login', this.data)

              if(res.status===200){
                  this.s(res.data.msg)
                  window.location = '/'
              }else{
                  if(res.status===401){
                       this.e(res.data.msg)
                  } else if(res.status===422){
                      for (let i in res.data.errors){
                          this.e(res.data.errors[i][0])
                      }
                  }
                  
                  else{
                      this.swr() 
                  }
              }
                this.isLogging = false
        }
    }
}
</script>

<style scoped>
     ._1adminOverveiw_table_recent {
    margin: 0 auto;
    margin-top:220px;
}
.login_footer{
    text-align: center; 
}
.login_header{
    text-align: center;
}
</style>