<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ArrowLeftIcon, CheckCircle2Icon } from 'lucide-vue-next';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { index, show, edit } from '@/routes/admin/pages';
import type { BreadcrumbItem } from '@/types';

const page_ = usePage();

const props = defineProps({ page: Object, path: String });

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Podstrona',
        href: show(props.page?.id).url,
    },
];
</script>

<template>
    <Head :title="props.page?.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Alert v-if="page_.flash.message">
                <CheckCircle2Icon />
                <AlertTitle>{{ page_.flash.message }}</AlertTitle>
            </Alert>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <Table>
                    <TableBody>
                        <TableRow>
                            <TableCell class="w-64">ID</TableCell>
                            <TableCell>{{ page?.id }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Tytuł</TableCell>
                            <TableCell>{{ page?.title }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Przyjazny adres</TableCell>
                            <TableCell>{{ page?.slug }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Strona nadrzędna</TableCell>
                            <TableCell>
                                <template v-if="page?.parent">
                                    {{ page?.parent?.title }}
                                </template>
                                <span v-else>&mdash;</span>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Podstrony</TableCell>
                            <TableCell>
                                <ul v-if="page?.children?.length">
                                    <li
                                        v-for="site in page?.children"
                                        :key="site.id"
                                    >
                                        {{ site.title }}
                                    </li>
                                </ul>
                                <template v-else>&mdash;</template>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Grafika 1</TableCell>
                            <TableCell>
                                <img
                                    v-if="page?.img"
                                    :src="path + '/' + page.img"
                                />
                                <template v-else>&mdash;</template>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Grafika 2</TableCell>
                            <TableCell>
                                <img
                                    v-if="page?.img1"
                                    :src="path + '/' + page.img1"
                                />
                                <template v-else>&mdash;</template>
                            </TableCell>
                        </TableRow>

                        <!-- <TableRow>
                            <TableCell>Wstęp</TableCell>
                            <TableCell>{{ page?.intro }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Zawartość</TableCell>
                            <TableCell>
                                <span v-html="page?.content"></span>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Opis strony</TableCell>
                            <TableCell>{{ page?.site_description }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Słowa kluczowe</TableCell>
                            <TableCell>{{ page?.site_keyword }}</TableCell>
                        </TableRow> -->

                        <TableRow>
                            <TableCell>Umieść w głównym menu</TableCell>
                            <TableCell>{{ page?.navbar }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Ukryj</TableCell>
                            <TableCell>{{ page?.hide }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Kolejność</TableCell>
                            <TableCell>{{ page?.ordinal }}</TableCell>
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
                            <Link :href="edit(page?.id).url">Edycja</Link>
                        </Button>
                    </ButtonGroup>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
