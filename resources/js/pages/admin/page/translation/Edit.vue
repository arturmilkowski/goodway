<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, SendIcon, Trash2Icon } from 'lucide-vue-next';
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

// --- Props ---

const props = defineProps<{
    page: Page;
    translation: Translation;
}>();

const localeLabels: Record<string, string> = {
    pl: '🇵🇱 Polski',
    en: '🇬🇧 Angielski',
    de: '🇩🇪 Niemiecki',
};

// --- Formularz ---

const form = useForm({
    title: props.translation.title,
    slug: props.translation.slug,
    intro: props.translation.intro,
    content: props.translation.content,
    site_description: props.translation.site_description,
    site_keyword: props.translation.site_keyword,
});

// --- Akcje ---

const destroy = () => {
    if (confirm('Na pewno chcesz usunąć to tłumaczenie?')) {
        form.delete(
            `/admin/pages/${props.page.id}/translations/${props.translation.id}`,
        );
    }
};

// --- Breadcrumbs ---

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Podstrona',
        href: show(props.page.id).url,
    },
    {
        title: 'Edycja tłumaczenia',
        href: '#',
    },
];
</script>

<template>
    <Head title="Edycja tłumaczenia" />

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
                        localeLabels[translation.locale] ??
                        translation.locale.toUpperCase()
                    }}</strong>
                </p>

                <form
                    @submit.prevent="
                        form.put(
                            `/admin/pages/${page.id}/translations/${translation.id}`,
                        )
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
                            <Button
                                type="button"
                                variant="destructive"
                                :disabled="form.processing"
                                @click="destroy"
                            >
                                <Trash2Icon />
                                Usuń tłumaczenie
                            </Button>
                        </ButtonGroup>
                    </FieldSet>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
