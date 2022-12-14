<template>
    <AppLayout :title="`Shop ${ categoryName }`">
        <SecondaryHeader>
            <template #breadcrumbs>
                <icon name="angle-right" class="w-4 h-4 fill-current"></icon>
                <span>Shop {{ categoryName }}</span>
            </template>
        </SecondaryHeader>
        <div class="flex">
            <div class="border-r w-1/5">
                <div>
                    <div class="text-white text-center bg-amber-500 py-4">
                        <p>Shop By Category</p>
                    </div>
                    <div class="flex flex-col divide-y">
                        <Link :href="route('shop.index', { category: category.slug })" class="text-left px-4 py-4 transition hover:text-white hover:bg-amber-500 sm:px-6 lg:px-8" :class="route().current('shop.index', { category: category.slug}) ? 'bg-amber-500 text-white' : ''" v-for="(category, index) in categories" :key="index">
                            {{ category.name }}
                        </Link>
                    </div>
                </div>
            </div>
            <div class="border-l w-4/5">
                <div class="flex justify-end space-x-2 pt-4 pr-4" v-if="categorySlug">
                    <span class="font-bold">Price:</span>
                    <Link :href="route('shop.index', { category: categorySlug, sort: 'low_high'})" class="hover:text-yellow-500">Low to High</Link>
                    <span>|</span>
                    <Link :href="route('shop.index', { category: categorySlug, sort: 'high_low'})" class="hover:text-yellow-500">High to Low</Link>
                </div>
                <div class="container flex flex-wrap mx-auto">
                    <template v-if="products.length === 0">
                        <NoItemsFound></NoItemsFound>
                    </template>
                    <Link :href="route('shop.show', product.slug)" class="flex flex-col w-full p-4 rounded sm:w-1/2 md:w-1/3" v-for="(product, index) in products" :key="index" v-else>
                        <img :src="'/storage/'+product.main_image" :alt="product.name" class="h-72 object-cover md:w-72 lg:w-96">
                        <div class="flex justify-around bg-amber-500 text-white p-2">
                            <!-- text bold -->
                            <span class="font-bold">{{ $filters.formatCurrency(product.price) }}</span>
                            <span class="text-white">{{ product.name }}</span>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout.vue';
    import AutoComplete from '@/Components/Search/AutoComplete.vue';
    import NoItemsFound from '@/Components/NoItemsFound.vue';
    import SecondaryHeader from '@/Components/SecondaryHeader.vue';
    defineProps({
        categorySlug: {
            type: String,
            default: null
        },
        categoryName: {
            type: String,
            default: null
        },
        products: {
            type: Array,
            default: () => []
        },
        categories: {
            type: Array,
            default: () => []
        }
    });
</script>
