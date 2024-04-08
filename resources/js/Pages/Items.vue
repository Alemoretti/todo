
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
            localItems: this.items.map(item => ({
                ...item,
                completedBoolean: item.completed === 1
            })),
            newItemName: '',
        }
    },
    methods: {
        updateItem(item) {
            this.$inertia.put(`/items/update/${item.id}`, item)
        },
        removeItem(item) {
            this.$inertia.delete(`items/delete/${item.id}`, {
                onSuccess: () => {
                    this.localItems = this.localItems.filter(i => i.id !== item.id)
                }
            })
        },
        addItem() {
            if (this.newItemName.trim()) {
                this.$inertia.post('/items/store', { name: this.newItemName }, {
                    onSuccess: (page) => {
                        this.localItems = page.props.items;
                        this.newItemName = '';
                    }
                });
            }
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
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-for="item in localItems" :key="item.id" class="flex items-center space-x-4 mb-4">
                            <input type="checkbox" :id="item.id" v-model="item.completed" @change="updateItem(item)" class="h-5 w-5 text-blue-600 rounded">
                            <label :for="item.id" class="text-lg" :class="{ 'line-through': item.completed, 'text-gray-500': item.completed }">{{ item.name }}</label>
                            <button @click="removeItem(item)" class="text-red-500 hover:text-red-700">X</button>
                        </div>
                    </div>
                    <div class="p-6 text-gray-900">
                        <input type="text" v-model="newItemName" name="item" placeholder="New item name" class="border rounded-lg p-2 w-full">
                        <button class="btn btn-blue mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="addItem">Add Item</button>
                    </div>                    
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
