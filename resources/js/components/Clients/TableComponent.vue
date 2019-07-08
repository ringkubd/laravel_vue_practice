<template>
    <div>
        <button class="btn btn-sm btn-primary" onclick="$('.collapse').collapse('toggle')">Add</button>

        <div class="collapse" id="formCollapse">
            <form action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" v-html="translation.name" ></label>
                            <input type="text" id="name" required name="name" v-model="input.name" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="contact_number" v-html="translation.mobile"></label>
                            <input type="text" id="contact_number" required v-model="input.contact_number" name="mobile" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" v-html="translation.address"></label>
                            <input type="text" id="address" required v-model="input.address" name="address" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="email" v-html="translation.email"></label>
                            <input type="email" required v-model="input.email" id="email" name="email" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <input type="submit" v-on:click="saveForm" v-model="translation.add" value="" class="btn btn-primary">
                        </div>
                    </div>


                </div>

            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-striped" id="content_table">
                <thead>
                <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item, index in items">
                    <td>{{item.id}}</td>
                    <td>{{item.name}}</td>
                    <td>{{item.contact_number}}</td>
                    <td>{{item.email}}</td>
                    <td><span class="btn btn-sm" v-on:click="deleteEntry(item.id,index)">Delete</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TableComponent",
        props: ['data','trans'],
        data(){
            return {
                items:this.data,
                translation: this.trans,
                input:{
                    email:"",
                    address: "",
                    contact_number:"",
                    name:""
                }
            }
        },
        mounted(){
            console.log(this.translation.add)
            $("#content_table").DataTable({
                dom: 'Bfrtip',
                buttons:[
                    'print',
                    'pdf',
                    'excel'
                ]
            })
        },
        methods: {
            deleteEntry(itemid,index){
                if(confirm("Do you really want to delete it ?")){
                    var app = this;
                    axios.delete('/users/delete/'+itemid).then(function(response){
                        app.data.splice(index,1)
                    })
                }

            },
            saveForm(){
                event.preventDefault();
                let name = this.input.name;
                let mobile = this.input.contact_number;
                let address = this.input.address;
                let email = this.input.email;

                var app = this;

                axios.post('/users',{
                    name: name,
                    contact_number: mobile,
                    email: email,
                    address: address
                }).then(function (response) {
                    app.data.push(response.data);

                }).catch(function (error) {

                    console.log(error)
                    
                })
            }
        }
    }

</script>

<style scoped>

</style>
