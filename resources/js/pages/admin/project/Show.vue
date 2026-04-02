<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ArrowLeftIcon, CheckCircle2Icon } from 'lucide-vue-next';
import { Alert, AlertTitle } from '@/components/ui/alert';
import Editor from '@/components/Editor.vue';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { index, show, edit } from '@/routes/admin/projects';
import type { BreadcrumbItem } from '@/types';

const page = usePage();

const props = defineProps({ project: Object, path: String });

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Projekt',
        href: show(props.project?.id).url,
    },
];
</script>

<template>
    <Head :title="props.project?.title" />

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
                <Table>
                    <TableBody>
                        <TableRow>
                            <TableCell class="w-64">ID</TableCell>
                            <TableCell>{{ project?.id }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Grafika 1</TableCell>
                            <TableCell>
                                <img
                                    v-if="project?.img"
                                    :src="path + '/' + project.img"
                                />
                                <template v-else>&mdash;</template>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Grafika 2</TableCell>
                            <TableCell>
                                <img
                                    v-if="project?.img1"
                                    :src="path + '/' + project.img1"
                                />
                                <template v-else>&mdash;</template>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Tytuł</TableCell>
                            <TableCell>{{ project?.title }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell> Przyjazny adres </TableCell>
                            <TableCell>{{ project?.slug }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Wstęp</TableCell>
                            <TableCell>{{ project?.intro }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Zawartość</TableCell>
                            <TableCell>
                                <span v-html="project?.content"></span>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Opis strony</TableCell>
                            <TableCell>{{
                                project?.site_description
                            }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Słowa kluczowe</TableCell>
                            <TableCell>{{ project?.site_keyword }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Zaakceptowano</TableCell>
                            <TableCell>{{ project?.approved }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Ukryj</TableCell>
                            <TableCell>{{ project?.hide }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                <div class="pt-3 pb-5 pl-2">
                    <ButtonGroup>
                        <Button variant="outline" as-child>
                            <Link :href="index().url">
                                <ArrowLeftIcon />
                                Powrót
                            </Link>
                        </Button>
                        <Button as-child variant="outline">
                            <Link :href="edit(project?.id).url">Edycja</Link>
                        </Button>
                    </ButtonGroup>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
