<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, SendIcon } from 'lucide-vue-next';
import Editor from '@/components/Editor.vue';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import {
    Field,
    FieldGroup,
    FieldLabel,
    FieldError,
    FieldSet,
} from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { show } from '@/routes/admin/pages';
import type { BreadcrumbItem } from '@/types';

// --- Typy ---

interface Page {
    id: number;
}

// --- Props ---

const props = defineProps<{
    page: Page;
    locale: string;
}>();

const localeLabels: Record<string, string> = {
    pl: '🇵🇱 Polski',
    en: '🇬🇧 Angielski',
    de: '🇩🇪 Niemiecki',
};

// --- Formularz ---

const form = useForm({
    locale: props.locale,
    title: '',
    slug: '',
    intro: '',
    content: '',
    site_description: '',
    site_keyword: '',
});

// --- Breadcrumbs ---

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Podstrona',
        href: show(props.page.id).url,
    },
    {
        title: 'Nowe tłumaczenie',
        href: '#',
    },
];
</script>

<template>
    <Head title="Nowe tłumaczenie" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                <p class="mb-4 text-sm text-muted-foreground">
                    Język:
                    <strong>{{
                        localeLabels[locale] ?? locale.toUpperCase()
                    }}</strong>
                </p>

                <form
                    @submit.prevent="
                        form.post(`/admin/pages/${page.id}/translations`)
                    "
                >
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="title">
                                    Tytuł podstrony
                                </FieldLabel>
                                <Input
                                    id="title"
                                    type="text"
                                    v-model="form.title"
                                    placeholder="Pole obowiązkowe"
                                />
                                <FieldError v-if="form.errors.title">
                                    {{ form.errors.title }}
                                </FieldError>
                            </Field>

                            <Field>
                                <FieldLabel for="slug">
                                    Slug (adres URL)
                                </FieldLabel>
                                <Input
                                    id="slug"
                                    type="text"
                                    v-model="form.slug"
                                    placeholder="Zostaw puste — zostanie wygenerowany automatycznie"
                                />
                                <FieldError v-if="form.errors.slug">
                                    {{ form.errors.slug }}
                                </FieldError>
                            </Field>

                            <Field>
                                <FieldLabel for="intro">
                                    Wstęp do podstrony
                                </FieldLabel>
                                <Textarea
                                    id="intro"
                                    v-model="form.intro"
                                    placeholder="Pole nieobowiązkowe"
                                />
                                <FieldError v-if="form.errors.intro">
                                    {{ form.errors.intro }}
                                </FieldError>
                            </Field>

                            <Field>
                                <FieldLabel for="content">
                                    Zawartość podstrony
                                </FieldLabel>
                                <Editor
                                    id="content"
                                    v-model="form.content"
                                    placeholder="Pole nieobowiązkowe"
                                />
                                <FieldError v-if="form.errors.content">
                                    {{ form.errors.content }}
                                </FieldError>
                            </Field>

                            <Field>
                                <FieldLabel for="site_description">
                                    Opis podstrony (SEO)
                                </FieldLabel>
                                <Input
                                    id="site_description"
                                    type="text"
                                    v-model="form.site_description"
                                    placeholder="Pole nieobowiązkowe"
                                />
                                <FieldError v-if="form.errors.site_description">
                                    {{ form.errors.site_description }}
                                </FieldError>
                            </Field>

                            <Field>
                                <FieldLabel for="site_keyword">
                                    Słowa kluczowe (SEO)
                                </FieldLabel>
                                <Input
                                    id="site_keyword"
                                    type="text"
                                    v-model="form.site_keyword"
                                    placeholder="Pole nieobowiązkowe"
                                />
                                <FieldError v-if="form.errors.site_keyword">
                                    {{ form.errors.site_keyword }}
                                </FieldError>
                            </Field>
                        </FieldGroup>

                        <ButtonGroup>
                            <Button variant="outline" as-child>
                                <Link :href="show(page.id).url">
                                    <ArrowLeftIcon />
                                    Powrót
                                </Link>
                            </Button>
                            <Button
                                type="submit"
                                variant="outline"
                                :disabled="form.processing"
                            >
                                <SendIcon />
                                Wyślij
                            </Button>
                        </ButtonGroup>
                    </FieldSet>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
