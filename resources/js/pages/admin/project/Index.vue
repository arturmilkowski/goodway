<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
// import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { usePage } from '@inertiajs/vue3';
import { Plus } from 'lucide-vue-next';
import { CheckCircle2Icon } from 'lucide-vue-next';
import { Alert, AlertTitle } from '@/components/ui/alert';
import Editor from '@/components/Editor.vue';
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
import { index, show, create } from '@/routes/admin/projects';
import type { BreadcrumbItem } from '@/types';

const page = usePage();

defineProps({ projects: Object, path: String });

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projekty',
        href: index().url,
    },
];
</script>

<template>
    <Head title="Projekty" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Alert v-if="page.flash.message">
                <CheckCircle2Icon />
                <AlertTitle>{{ page.flash.message }}</AlertTitle>
            </Alert>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <div class="py-3 pl-2">
                    <Button variant="outline" as-child>
                        <Link :href="create().url">
                            <Plus />
                            Dodaj
                        </Link>
                    </Button>
                </div>
                <Table v-if="projects?.length">
                    <TableHeader>
                        <TableRow>
                            <TableHead class="w-10">ID</TableHead>
                            <TableHead>Grafika</TableHead>
                            <TableHead>Tytuł</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="project in projects" :key="project.id">
                            <TableCell class="font-medium">
                                {{ project.id }}
                            </TableCell>
                            <TableCell class="w-[150px]">
                                <template v-if="project.img">
                                    <img
                                        v-if="project.img"
                                        :src="path + '/' + project.img"
                                        width="150"
                                    />
                                </template>
                                <template v-else>&mdash;</template>
                            </TableCell>
                            <TableCell>
                                <Link :href="show(project.id)">
                                    {{ project.title }}
                                </Link>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <Alert v-else>
                    <CheckCircle2Icon />
                    <AlertTitle>Brak projektów</AlertTitle>
                </Alert>
            </div>
        </div>
    </AppLayout>
</template>
