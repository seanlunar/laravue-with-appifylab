import Axios from "axios";
import { mapGetters } from 'vuex'
export default {
    data(){
        return{

        }
    },
    methods:{
       async callApi(method, url, dataObj){
            try {
                return await Axios({
                    method: method,
                    url: url,
                    data: dataObj
                });

            } catch (e){
             
                  return e.response
            }
        },
        i (desc, title="hey"){
            this.$Notice.info({
                title: title,
                desc:desc
            });
        },
        s(desc, title = "Great") {
                this.$Notice.success({
                    title: title,
                    desc: desc
                });
        },  
        w(desc, title = "ooppps!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        swr(desc='something went wrong! please try again', title = "ooppps!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },  
        e(desc, title = "ooops!!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },   
        checkUserPermission(key){
            if(!this.userPermission) return true
            let isPermitted = false;
            for (let d of this.userPermission){
           
              if(this.$route.name == d.name){
                 if(d[key]){
                     isPermitted = true
                     break;
                 } else {
                     break;
                 }
              }
            }
            return isPermitted
        }    
    },  
    
    computed: {
        ...mapGetters({
            'userPermission': 'getUserPermision'
        }),
        isReadPermitted(){
         return this.checkUserPermission('read')
        },
        isWritePermitted() {
            return this.checkUserPermission('write')
        },
        isUpdatePermitted() {
            return this.checkUserPermission('update')
        },
        isDeletePermitted() {
            return this.checkUserPermission('delete')
        },
    }
}