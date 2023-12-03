<script setup>
import {ref} from "vue";
import {router, usePage} from "@inertiajs/vue3";


</script>

<template class="">
    <div class="">
        <div class="sticky">
            <nav class=" bg-sky-500 p-4 flex items-center justify-between ">
                <div>
                    <h1 class="text-white text-xl font-semibold">Products</h1>
                </div>
            </nav>
        </div>
        <div class="mx-auto max-w-5xl w-3/4 flex  overflow-hidden">
            <div class="w-full bg-gray-100 h-screen overflow-y-auto">
                <slot/>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
