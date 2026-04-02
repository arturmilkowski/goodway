<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ArrowLeftIcon, CheckCircle2Icon } from 'lucide-vue-next';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { index, show, edit } from '@/routes/admin/blog/posts';
import type { BreadcrumbItem } from '@/types';

const page = usePage();

const props = defineProps({ post: Object, path: String });

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Wpis',
        href: show(props.post?.id).url,
    },
];
</script>

<template>
    <Head :title="props.post?.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <Alert v-if="page.flash.message">
                <CheckCircle2Icon />
                <AlertTitle>{{ page.flash.message }}</AlertTitle>
            </Alert>
            <!--;
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
            </div>
            -->
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >
                <!-- <PlaceholderPattern /> -->
                <Table>
                    <TableBody>
                        <TableRow>
                            <TableCell class="w-64">ID</TableCell>
                            <TableCell>{{ post?.id }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Grafika 1</TableCell>
                            <TableCell>
                                <img
                                    v-if="post?.img"
                                    :src="path + '/' + post.img"
                                />
                                <template v-else>&mdash;</template>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Grafika 2</TableCell>
                            <TableCell>
                                <img
                                    v-if="post?.img1"
                                    :src="path + '/' + post.img1"
                                />
                                <template v-else>&mdash;</template>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Tytuł</TableCell>
                            <TableCell>{{ post?.title }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell> Przyjazny adres </TableCell>
                            <TableCell>{{ post?.slug }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Wstęp</TableCell>
                            <TableCell>{{ post?.intro }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Zawartość</TableCell>
                            <TableCell>
                                <span v-html="post?.content"></span>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Opis strony</TableCell>
                            <TableCell>{{ post?.site_description }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Słowa kluczowe</TableCell>
                            <TableCell>{{ post?.site_keyword }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Zaakceptowano</TableCell>
                            <TableCell>{{ post?.approved }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Opublikowano</TableCell>
                            <TableCell>{{ post?.published }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Komentarze dozwolone</TableCell>
                            <TableCell>{{ post?.comments_allowed }}</TableCell>
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
                            <Link :href="edit(post?.id).url">Edycja</Link>
                        </Button>
                    </ButtonGroup>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
