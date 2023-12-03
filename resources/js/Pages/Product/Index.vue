<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {usePage} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import {ref, onMounted} from "vue";

const products = ref(usePage().props.products)
const modalIsOn = ref(false)
const message = ref('')
const wrongImportMsg = ref('')
const productToDelete = ref({
    index: null,
    id:null
})

const fileInput = ref(null);
const importExcel = ()=>{
    fileInput.value.click();
}

onMounted(() => {
    const items = localStorage.getItem('products');
    if (items) {
         products.value = JSON.parse(items)
    }
    else {
        axios.get(route('products.get.all'))
            .then(res => {
                localStorage.setItem('products', JSON.stringify(res.data.data))
                products.value = JSON.parse(localStorage.getItem('products'))
            })
    }
});

const handleExcelFile = () =>{
    const selectedFile = fileInput.value.files[0];
    const formData = new FormData
    formData.append('file', selectedFile)
    axios.post(route('product.import.store'), formData)
        .then(res =>{
            localStorage.setItem('products', JSON.stringify(res.data.data));
        }).catch(function (error){
        wrongImportMsg.value = error.response.data.message
    })
}

const modalCall = (product, index) =>{
    productToDelete.value.id =product.id
    productToDelete.value.index = index
    modalIsOn.value = true
}

const deleteProduct = () =>{
    axios.delete(route('product.delete', productToDelete.value.id))
        .then(res =>{
            products.splice(productToDelete.value.index, 1)
            message.value = res.data.message
            modalIsOn.value = false
        })
}


</script>

<template>
    <AppLayout>
        <Modal :show="modalIsOn" @close="modalIsOn = false">
            <div class="py-5 text-center">
                <div class="flex justify-center">
                    <h2 class=" text-2xl text-center w-96">Вы уверены, что хотите удалить пользователя?</h2>
                </div>
                <div class="flex justify-center gap-6 mt-5">
                    <button @click.prevent="modalIsOn=false" class="py-2 px-4 bg-sky-700 rounded-xl text-white">Отмена</button>
                    <button @click.prevent="deleteProduct" class="py-2 px-4 bg-red-700 rounded-xl text-white">Удалить</button>
                </div>
            </div>
        </Modal>
        <div class="p-4">
            <p class="text-3xl text-center">Продукты</p>
            <p class="text-red-600 text-center">{{message}}</p>
        </div>
        <div class="text-right px-4 flex gap-2 justify-end">
            <div>
                <a @click="importExcel" href="#" class="bg-indigo-500 py-2 px-4 rounded-xl text-white">Загрузить файл</a>
                <p class="text-right text-red-600 py-2 ">{{wrongImportMsg}}</p>
                <input ref="fileInput" type="file" class="hidden" @change="handleExcelFile">
            </div>
            <div>
                <a :href="route('product.store')" class="bg-indigo-500 py-2 px-4 rounded-xl text-white">Добавить запись</a>
            </div>
        </div>
        <div class="flex justify-center mt-5 mb-5 py-3">
            <table class="table-auto w-5/6">
                <thead>
                <tr>
                    <th>Артикул</th>
                    <th>Номенклатура</th>
                    <th>Ед. Изм.</th>
                    <th>Кол-во</th>
                    <th>Цена за шт</th>
                    <th>Upd</th>
                    <th>Rm</th>
                </tr>
                </thead>
                <tbody class="">
                <tr v-for="(product, index) in products" class="py-2 border border-b-gray-500">
                    <td class="text-sky-700">{{product.article}}</td>
                    <td class="text-center">{{product.name}}</td>
                    <td class="text-center">{{product.unit}}</td>
                    <td class="text-center">{{product.quantity}}</td>
                    <td class="text-center">{{product.price}}</td>
                    <td class="text-center">
                        <div class=" flex justify-center">
                            <a :href="route('product.create', product.article)" class="text-sky-500">
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </i>
                            </a>
                        </div>
                    </td>
                    <td class="text-sm flex justify-center">
                        <a href="#" @click.prevent="modalCall(product, index)" class="text-red-500">
                            <i>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </i>
                        </a>
                    </td>

<!--                    <td class="text-sky-700 ">-->
<!--                        <div class="flex justify-center">-->
<!--&lt;!&ndash;                            <a href="#" @click.prevent="modalCall(project, index)" class="text-red-500">&ndash;&gt;-->
<!--&lt;!&ndash;                                <i>&ndash;&gt;-->
<!--&lt;!&ndash;                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />&ndash;&gt;-->
<!--&lt;!&ndash;                                    </svg>&ndash;&gt;-->
<!--&lt;!&ndash;                                </i>&ndash;&gt;-->
<!--&lt;!&ndash;                            </a>&ndash;&gt;-->
<!--                        </div>-->
<!--                    </td>-->
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
