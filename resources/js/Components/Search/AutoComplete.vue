<template>
    <AisInstantSearch
        index-name="products"
        :search-client="searchClient"
        class="w-full"
    >
        <AisConfigure
            :attributesToSnippet="['name', 'details', 'description', 'categories']"
            :hits-per-page.camel="5"
        >
            <AisAutocomplete class="relative">
                <template v-slot="{ currentRefinement, indices, refine }">
                    <span class="relative">
                        <input
                            type="search"
                            :value="currentRefinement"
                            placeholder="Search for products"
                            class="rounded w-full pl-8"
                            autofocus
                            autocomplete="off"
                            @input="refine($event.currentTarget.value)"
                            @keypress.enter="search"
                        >
                        <icon name="search" class="fill-current opacity-75 absolute mt-1 ml-2 w-4 h-4 top-0"></icon>
                    </span>
                    <div class="absolute z-10 transform mt-3 px-2 w-full sm:px-0" v-if="currentRefinement.length">
                        <div class="rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-gray-900 text-gray-100 px-5 py-6 sm:gap-8 sm:p-8">
                                <div class="divide-y divide-blue-900" v-for="item in indices" :key="item.objectID">
                                    <div class="flex justify-between items-center" v-if="indices.length">
                                        <h2 class="uppercase text-yellow-500 py-1 px-2">
                                            {{ item.indexName }}
                                        </h2>
                                        <AisStats class="text-gray-100" />
                                    </div>
                                    <Link :href="route('shop.show', hit.slug)" class="flex items-center space-x-4 px-2 py-2 transition hover:bg-gray-700 focus:outline-none focus:bg-gray-700 " v-for="(hit, index) in item.hits" :key="index">
                                        <div class="flex w-24 h-24">
                                            <img
                                                :src="'/storage/'+hit.main_image"
                                                :alt="hit.name"
                                                class="object-cover"
                                            />
                                        </div>
                                        <div>
                                            <AisHighlight attribute="name" :hit="hit" class="block text-blue-300 font-medium"></AisHighlight>
                                            <AisSnippet attribute="details" :hit="hit" class="block text-gray-100"></AisSnippet>
                                            <AisSnippet attribute="description" :hit="hit" class="block text-gray-100"></AisSnippet>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </AisAutocomplete>
        </AisConfigure>
    </AisInstantSearch>
    <MainButton
        :href="route('shop.index')"
        like="href"
        class="ml-2 h-10 text-sm"
        @click="search"
        >search</MainButton>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import MainButton from '@/Components/Buttons/MainButton.vue'
    import algoliasearch from 'algoliasearch/lite'
    export default defineComponent({
        components: {
            Link,
            MainButton,
        },
        data() {
            console.log('algolia', import.meta.env.VITE_ALGOLIA_APP_ID, import.meta.env.VITE_ALGOLIA_SEARCH_KEY)

            return {
                searchClient: algoliasearch(
                    import.meta.env.VITE_ALGOLIA_APP_ID,
                    import.meta.env.VITE_ALGOLIA_SECRET
                )
            }
        },
        methods: {
            search() {
                this.$inertia.get(this.route('search-algolia'))
            }
        }
    })
</script>
