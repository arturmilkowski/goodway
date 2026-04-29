<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import {
    ArrowLeftIcon,
    CheckCircle2Icon,
    PencilIcon,
    PlusIcon,
    Trash2Icon,
} from 'lucide-vue-next';
import { Alert, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Table, TableBody, TableCell, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { index, show, edit } from '@/routes/admin/pages';
import type { BreadcrumbItem } from '@/types';

interface Translation {
    id: number;
    locale: string;
    title: string;
    slug: string;
    intro: string;
    content: string;
    site_description: string;
    site_keyword: string;
}

interface Page {
    id: number;
    img: string | null;
    img1: string | null;
    navbar: boolean;
    hide: boolean;
    ordinal: number;
    parent: Page | null;
    children: Page[];
    translations: Translation[];
}

const page_ = usePage();

const props = defineProps<{
    page: Page;
    locales: string[];
    path: string;
}>();

const localeLabels: Record<string, string> = {
    pl: '🇵🇱 Polski',
    en: '🇬🇧 Angielski',
    de: '🇩🇪 Niemiecki',
};

function findTranslation(locale: string): Translation | undefined {
    return props.page.translations?.find((t) => t.locale === locale);
}

// URL-e dla tłumaczeń — dopasuj do swoich route helpers jeśli masz
function translationCreateUrl(locale: string): string {
    return `/admin/pages/${props.page.id}/translations/create?locale=${locale}`;
}

function translationEditUrl(translationId: number): string {
    return `/admin/pages/${props.page.id}/translations/${translationId}/edit`;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Podstrona',
        href: show(props.page?.id).url,
    },
];
</script>

<template>
    <Head :title="findTranslation('pl')?.title ?? 'Podstrona'" />

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
                <!-- Dane główne strony -->

                <Table>
                    <TableBody>
                        <TableRow>
                            <TableCell class="w-64">ID</TableCell>
                            <TableCell>{{ page?.id }}</TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Strona nadrzędna</TableCell>
                            <TableCell>
                                <template v-if="page?.parent">
                                    {{
                                        page.parent.translations?.find(
                                            (t) => t.locale === 'pl',
                                        )?.title ?? '—'
                                    }}
                                </template>
                                <span v-else>&mdash;</span>
                            </TableCell>
                        </TableRow>
                        <TableRow>
                            <TableCell>Podstrony</TableCell>
                            <TableCell>
                                <ul v-if="page?.children?.length">
                                    <li
                                        v-for="child in page.children"
                                        :key="child.id"
                                    >
                                        {{
                                            child.translations?.find(
                                                (t) => t.locale === 'pl',
                                            )?.title ?? '—'
                                        }}
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
                                        title="Tłumaczenie istnieje"
                                    />
                                </template>
                                <template v-else>
                                    <span
                                        class="text-sm text-muted-foreground italic"
                                        >Brak tłumaczenia</span
                                    >
                                    <span
                                        class="inline-block h-2 w-2 rounded-full bg-gray-300"
                                        title="Brak tłumaczenia"
                                    />
                                </template>
                            </div>

                            <div class="flex gap-2">
                                <!-- Edytuj istniejące tłumaczenie -->
                                <Button
                                    v-if="findTranslation(locale)"
                                    variant="outline"
                                    size="sm"
                                    as-child
                                >
                                    <Link
                                        :href="
                                            translationEditUrl(
                                                findTranslation(locale)!.id,
                                            )
                                        "
                                    >
                                        <PencilIcon class="mr-1 h-4 w-4" />
                                        Edytuj
                                    </Link>
                                </Button>

                                <!-- Dodaj nowe tłumaczenie -->
                                <Button
                                    v-else
                                    variant="outline"
                                    size="sm"
                                    as-child
                                >
                                    <Link :href="translationCreateUrl(locale)">
                                        <PlusIcon class="mr-1 h-4 w-4" />
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
