
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
        Head
    },    
    props: {
        items: Object,
    },
    data() {
        return {
            localItems: this.items || [],
        }
    },
    computed: {
        completedBoolean: {
            get() {
                return this.item.completed === 1
            },
            set(newValue) {
                this.item.completed = newValue ? 1 : 0
            },
        },
    }, 
    methods: {
        updateItem(item) {
            this.$inertia.put(`/items/update/${item.id}`, item)
        },
        removeItem(item) {
            this.$inertia.delete(`items/destroy/${item.id}`)
                .then(() => {
                    this.localItems = this.localItems.filter(i => i.id !== item.id)
                })
        },        
    },
    mounted() {
        if (!this.items) {
            this.$inertia.get('/items')
                .then(response => {
                    this.localItems = response.data
                })
        }
    },
}
</script>



<template>
    <Head title="Items" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">To-do list</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-for="item in localItems" :key="item.id">
                            <input type="checkbox" :id="item.id" v-model="item.completedBoolean"  @change="updateItem(item)">
                            <label :for="item.id">{{ item.name }}</label>
                            <button @click="removeItem(item)">X</button>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900">
                        <input type="text" v-model="newItemName" placeholder="New item name">
                        <button class="btn btn-blue" @click="addItem">Add Item</button>
                    </div>                    
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
