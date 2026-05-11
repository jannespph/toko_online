<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    totalProduk: Number,
    totalPenjual: Number,
});
</script>

<template>

    <AppLayout>

        <Head title="Beranda" />

        <!-- Hero Section -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 text-white">

            <div class="max-w-7xl mx-auto px-4 py-20 text-center">

                <h1 class="text-5xl font-bold mb-4">
                    Selamat Datang di Toko Online
                </h1>

                <p class="text-blue-100 text-lg">
                    {{ totalProduk }} produk dari {{ totalPenjual }} penjual.
                </p>

            </div>

        </div>

        <!-- Statistik -->
        <div class="max-w-7xl mx-auto px-4 py-12">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Produk -->
                <div class="rounded-xl bg-white p-8 shadow-md text-center">

                    <p class="text-4xl mb-3">📦</p>

                    <p class="text-3xl font-bold text-blue-600">
                        {{ totalProduk }}
                    </p>

                    <p class="mt-1 text-gray-500">
                        Produk Tersedia
                    </p>

                </div>

                <!-- Penjual -->
                <div class="rounded-xl bg-white p-8 shadow-md text-center">

                    <p class="text-4xl mb-3">🏪</p>

                    <p class="text-3xl font-bold text-blue-600">
                        {{ totalPenjual }}
                    </p>

                    <p class="mt-1 text-gray-500">
                        Penjual Aktif
                    </p>

                </div>

            </div>

        </div>

    </AppLayout>

</template>