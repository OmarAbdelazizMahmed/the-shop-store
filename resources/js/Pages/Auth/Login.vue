<template>
    <AppLayout title="Log in">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">
            <div class="flex-1">
                <div class="flex flex-col bg-white shadow-md rounded px-8 py-6">
                    <h1 class="text-lg font-semibold text-center underline italic">Login</h1>

                    <JetValidationErrors class="mb-4" />

                    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                        {{ status }}
                    </div>

                    <form @submit.prevent="submit">
                        <div class="mt-4">
                            <JetLabel for="email" value="Email" />
                            <JetInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                        </div>

                        <div class="mt-4">
                            <JetLabel for="password" value="Password" />
                            <JetInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"  autocomplete="new-password" required />
                        </div>

                        <div class="block mt-4">
                            <label class="flex items-center">
                                <JetCheckbox name="remember" v-model:checked="form.remember" />
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-center mt-4">
                            <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                                Forgot your password?
                            </Link>

                            <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                <icon name="spinner" class="animate-spin h-5 w-5 fill-current" v-if="form.processing"></icon>
                                <span v-else>Log in</span>
                            </JetButton>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex-1">
                <div class=" flex flex-col shadow-md rounded">
                    <div class="bg-gray-300 px-4 py-6">
                        <div class="flex flex-col items-center bg-white px-4 py-2 space-y-4">
                            <Link :href="route('register')" class="underline text-gray-600 hover:text-gray-900 transition">
                                Need a new account?
                            </Link>
                            <Link :href="route('checkout.guest.index')" class="underline text-gray-600 hover:text-gray-900 transition">
                                Checkout as a guest
                            </Link>
                            <Link :href="route('shop.index')" class="underline text-gray-600 hover:text-gray-900 transition">Continue Shopping.</Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import JetButton from '@/Components/Button.vue';
    import JetInput from '@/Components/Input.vue'
    import JetCheckbox from '@/Components/Checkbox.vue'
    import JetLabel from '@/Components/Label.vue'
    import JetValidationErrors from '@/Components/ValidationErrors.vue'

    export default defineComponent({
        components: {
            Link,
            AppLayout,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
        },
        props: {
            canResetPassword: Boolean,
            status: String
        },
        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },
        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    })
</script>
