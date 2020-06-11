import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state:{
        counter:1000,
        deleteModalObj:{ 
            showDeleteModal: false,
            deleteUrl:'',
            data : null,
            deletingIndex: -1,
            isDeleted: false,
        },
        user : false,
        userPermission: null,
    },
    getters:{
    
        getDeleteModalObj(state){
            return state.deleteModalObj
        },
        getUserPermision(state){
           return state.userPermission
        }
      
          //  getCounter(state){
        //    return state.counter},
         /*   if(state.counter > 1000) return 'oh this is huge..'
            return state.counter
        },
        getCounterByHalf(state) {
            return state.counter/2
        }       */
    },
    mutations : {
        cchangeThecounter(state, data){
           state.counter += data
        },
        setDeleteModal(state, data){
            const deleteModalObj= {
                showDeleteModal: false,
                deleteUrl: '',
                data: null,
                deletingIndex: -1,
                isDeleted: data,
            }
            state.deleteModalObj  = deleteModalObj   
        
        },
         setDeleteModalObj(state, data) {
            state.deleteModalObj = data
        },
        setUpdateUser(state, data){
            state.user = data
        },
        setUserPermission(state, data){
            state.userPermission = data
        },
    }
})