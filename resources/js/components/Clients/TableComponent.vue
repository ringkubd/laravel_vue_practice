<template>
    <div>
        <b-button
            :class="showCollapse ? 'collapsed btn-danger' : 'btn-success'"
            :aria-expanded="showCollapse ? 'true' : 'false'"
            aria-controls="collapse-4"
            @click="addFormOpen" v-html="showCollapse ? 'Close': 'Add'" >
            Add
        </b-button>


        <b-collapse id="collapse-4" v-model="showCollapse" class="mt-2">
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
        </b-collapse>

        <b-collapse id="collapse-4" v-model="showEditCollapse" class="mt-2">
            <form action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="e_name" v-html="translation.name" ></label>
                            <input type="text" id="e_name" required name="name" v-model="input.name" class="form-control" value="">
                            <input type="hidden" id="id" required name="id" v-model="input.index_id" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="e_contact_number" v-html="translation.mobile"></label>
                            <input type="text" id="e_contact_number" required v-model="input.contact_number" name="mobile" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="e_address" v-html="translation.address"></label>
                            <input type="text" id="e_address" required v-model="input.address" name="address" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="e_email" v-html="translation.email"></label>
                            <input type="email" required v-model="input.email" id="e_email" name="email" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <input type="submit" v-on:click="editFormSubmit" v-model="translation.update" value="" class="btn btn-primary">
                        </div>
                    </div>


                </div>

            </form>
        </b-collapse>

        <div class="table-responsive">
            <table class="table table-striped" id="content_table">
                <thead>
                <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item, index in items">
                    <td>{{item.id}}</td>
                    <td>{{item.name}}</td>
                    <td>{{item.contact_number}}</td>
                    <td>{{item.email}}</td>
                    <td>{{item.address}}</td>
                    <td>
                        <span class="btn btn-sm btn-warning" v-on:click="deleteEntry(item.id,index)">Delete</span>
                        <span class="btn btn-sm" v-on:click="editEntry(item.id,index)" :class="showEditCollapse && openEditFormIndex == index ? 'btn-danger' : null" v-html="showEditCollapse && openEditFormIndex == index ? 'Close' : translation.edit"></span>
                    </td>
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
                    name:"",
                    index_id:""
                },
                showCollapse: false,
                showEditCollapse: false,
                openEditFormIndex: 0
            }
        },
        mounted(){
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

                })
            },
            editEntry(id,index){
                var app = this;
                var data = this.items[index];
                this.input.name  = data.name;
                this.input.index_id  = data.id;
                this.input.contact_number = data.contact_number;
                this.input.address = data.address;
                this.input.email = data.email;

                this.showCollapse = false;
                if (this.openEditFormIndex !== index) {
                    this.showEditCollapse = true;
                }else{
                    this.showEditCollapse = this.showEditCollapse == false ? true : false;
                }
                if (this.showEditCollapse == false) {
                    this.input.name  = "";
                    this.input.contact_number ="";
                    this.input.address = "";
                    this.input.email = "";
                }

                this.openEditFormIndex = index;
            },
            editFormSubmit(){
                event.preventDefault();
                let name = this.input.name;
                let index_id = this.input.index_id;
                let mobile = this.input.contact_number;
                let address = this.input.address;
                let email = this.input.email;

                var app = this;

                axios.post('/users/update/'+index_id,{
                    name: name,
                    contact_number: mobile,
                    email: email,
                    address: address
                }).then(function (response) {
                    updateData = app.items[this.openEditFormIndex];
                    updateData.email=email
                    updateData.address=address
                    updateData.mobile=mobile
                    updateData.name=name

                }).catch(function (error) {

                })
            },
            addFormOpen(){
                this.input.name  = "";
                this.input.contact_number ="";
                this.input.address = "";
                this.input.email = "";
                this.showEditCollapse = false;
                this.showCollapse = !this.showCollapse;
            }
        }
    }

</script>

<style scoped>

</style>
