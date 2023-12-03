<script setup>

import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";

const product = usePage().props.product

const form = useForm({
    id: product.id ?? null,
    article: product.article ?? null,
    name: product.name ?? null,
    quantity: product.quantity ?? null,
    price: product.price ?? null,
})

const updateOrCreateProduct = () => {
    form.post(route('product.store'), {
        onSuccess:() =>{
          localStorage.clear()
        },
        onError:() =>{
        }
    })
}

</script>

<template>
    <AppLayout>
        <div class="flex justify-center items-center h-full">
            <div>
                <h2 class="text-2xl text-center">Новый продукт</h2>
                <form @submit.prevent="updateOrCreateProduct">
                    <div class="mt-5">
                        <InputLabel>Артикул</InputLabel>
                        <TextInput v-model="form.article" name="article" placeholder="Article" class="w-full"></TextInput>
                        <InputLabel class="mt-3">Номенклатура</InputLabel>
                        <TextInput v-model="form.name" name="name" placeholder="Name" class="w-full "></TextInput>
                        <InputLabel class="mt-3">Количество</InputLabel>
                        <TextInput type="number" v-model="form.quantity" name="quantity" placeholder="Quantity" class="w-full "></TextInput>
                        <InputLabel class="mt-3">Цена за шт</InputLabel>
                        <TextInput type="number" v-model="form.price" name="price" placeholder="Price" class="w-full"></TextInput>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-indigo-500 text-white py-2 px-4 rounded-xl">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
