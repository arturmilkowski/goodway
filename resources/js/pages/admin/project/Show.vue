<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import { ArrowLeftIcon, CheckCircle2Icon } from 'lucide-vue-next';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { index, show, edit } from '@/routes/admin/projects';
import type { BreadcrumbItem } from '@/types';

interface Translation {
    id: number;
    locale: string;
    title: string;
    slug: string;
    intro: string;
    content: string;
    result: string;
    site_description: string;
    site_keyword: string;
}

interface Project {
    id: number;
    img: string | null;
    img1: string | null;
    approved: boolean;
    hide: boolean;
    translations: Translation[];
}

const page_ = usePage();

const props = defineProps<{
    project: Project;
    locales: string[];
    path: string;
}>();

const localeLabels: Record<string, string> = {
    pl: '🇵🇱 Polski',
    en: '🇬🇧 Angielski',
    de: '🇩🇪 Niemiecki',
};

function findTranslation(locale: string): Translation | undefined {
    return props.project.translations?.find((t) => t.locale === locale);
}

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Projekt', href: show(props.project?.id).url },
];
</script>

<template>
    <Head :title="findTranslation('pl')?.title ?? 'Projekt'" />

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
                <!-- Dane główne -->
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
                            <TableCell>Zaakceptowano</TableCell>
                            <TableCell>{{ project?.approved }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Ukryj</TableCell>
                            <TableCell>{{ project?.hide }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>

                <!-- Tłumaczenia -->
                <div class="border-t border-sidebar-border/70 p-4">
                    <h2 class="mb-3 text-sm font-semibold">Tłumaczenia</h2>

                    <div class="flex flex-col gap-3">
                        <div
                            v-for="locale in props.locales"
                            :key="locale"
                            class="flex items-center justify-between rounded border border-sidebar-border/70 px-4 py-3"
                        >
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium">
                                    {{
                                        localeLabels[locale] ??
                                        locale.toUpperCase()
                                    }}
                                </span>
                                <template v-if="findTranslation(locale)">
                                    <span class="text-sm text-muted-foreground">
                                        {{ findTranslation(locale)?.title }}
                                    </span>
                                    <span
                                        class="inline-block h-2 w-2 rounded-full bg-green-500"
                                    />
                                </template>
                                <template v-else>
                                    <span
                                        class="text-sm text-muted-foreground italic"
                                        >Brak tłumaczenia</span
                                    >
                                    <span
                                        class="inline-block h-2 w-2 rounded-full bg-gray-300"
                                    />
                                </template>
                            </div>

                            <div class="flex gap-2">
                                <Button
                                    v-if="findTranslation(locale)"
                                    variant="outline"
                                    size="sm"
                                    as-child
                                >
                                    <Link
                                        :href="`/admin/projects/${project.id}/translations/${findTranslation(locale)!.id}/edit`"
                                    >
                                        Edytuj
                                    </Link>
                                </Button>
                                <Button
                                    v-else
                                    variant="outline"
                                    size="sm"
                                    as-child
                                >
                                    <Link
                                        :href="`/admin/projects/${project.id}/translations/create?locale=${locale}`"
                                    >
                                        Dodaj
                                    </Link>
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-3 pb-5 pl-2">
                    <ButtonGroup>
                        <Button variant="outline" as-child>
                            <Link :href="index().url"
                                ><ArrowLeftIcon />Powrót</Link
                            >
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
