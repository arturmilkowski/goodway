<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { CheckCircle2Icon } from 'lucide-vue-next';
// import Editor from '@/components/Editor.vue';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { index, show, create } from '@/routes/admin/pages';
import type { BreadcrumbItem } from '@/types';

const page = usePage();

defineProps({ pages: Object, path: String });

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Podstrony',
        href: index().url,
    },
];
</script>

<template>
    <Head title="Podstrony" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Alert v-if="page.flash.message">
                <CheckCircle2Icon />
                <AlertTitle>{{ page.flash.message }}</AlertTitle>
            </Alert>
            <div
                class="relative min-h-screen flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="py-3 pl-2">
                    <Button variant="outline" as-child>
                        <Link :href="create().url">
                            <Plus />
                            Dodaj
                        </Link>
                    </Button>
                </div>
                <Table v-if="pages?.length">
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-10">ID</TableHead>
                            <!-- <TableHead class="w-10">Rodzic</TableHead> -->
                            <TableHead>Grafika</TableHead>
                            <TableHead>Tytuł</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="page in pages" :key="page.id">
                            <TableCell class="font-medium">
                                {{ page.id }}
                            </TableCell>
                            <TableCell class="w-[150px]">
                                <template v-if="page.img">
                                    <img
                                        v-if="page.img"
                                        :src="path + '/' + page.img"
                                        width="150"
                                    />
                                </template>
                                <template v-else>&mdash;</template>
                            </TableCell>
                            <TableCell>
                                <Link :href="show(page.id)">
                                    {{ page.translations[0].title }}
                                </Link>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Alert v-else>
                    <CheckCircle2Icon />
                    <AlertTitle>Brak podstron</AlertTitle>
                </Alert>
            </div>
        </div>
    </AppLayout>
</template>
