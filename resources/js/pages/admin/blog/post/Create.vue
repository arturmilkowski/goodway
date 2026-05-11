<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ArrowLeftIcon, SendIcon } from 'lucide-vue-next';
import Editor from '@/components/Editor.vue';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import { Checkbox } from '@/components/ui/checkbox';
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
import { index, create, store } from '@/routes/admin/blog/posts';
import type { BreadcrumbItem } from '@/types';

interface Translation {
    locale: string;
    slug: string;
    title: string;
    intro: string;
    content: string;
    site_description: string;
    site_keyword: string;
}

const props = defineProps<{
    locales: string[];
}>();

const activeLocale = ref(props.locales[0] ?? 'pl');

const localeLabels: Record<string, string> = {
    pl: '🇵🇱 PL',
    en: '🇬🇧 EN',
    de: '🇩🇪 DE',
};

const emptyTranslations = Object.fromEntries(
    props.locales.map((locale) => [
        locale,
        {
            locale,
            slug: '',
            title: '',
            intro: '',
            content: '',
            site_description: '',
            site_keyword: '',
        },
    ]),
) as Record<string, Translation>;

const form = useForm<{
    img: string | null;
    img1: string | null;
    imgFile: File | null;
    imgFile1: File | null;
    approved: boolean;
    published: boolean;
    comments_allowed: boolean;
    translations: Record<string, Translation>;
}>({
    img: null,
    img1: null,
    imgFile: null,
    imgFile1: null,
    approved: true,
    published: true,
    comments_allowed: true,
    translations: emptyTranslations,
});

function translationError(locale: string, field: string): string | undefined {
    return (form.errors as Record<string, string>)[
        `translations.${locale}.${field}`
    ];
}

function handleFileInput(event: Event) {
    const input = event.target as HTMLInputElement;
    form.imgFile = input.files?.[0] ?? null;
}
function handleFileInput1(event: Event) {
    const input = event.target as HTMLInputElement;
    form.imgFile1 = input.files?.[0] ?? null;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tworzenie wpisu',
        href: create().url,
    },
];
</script>

<template>
    <Head title="Tworzenie wpisu" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                <form @submit.prevent="form.post(store().url)">
                    <FieldSet>
                        <FieldGroup>
                            <!-- Zakładki języków -->
                            <div class="mt-4">
                                <div
                                    class="mb-4 flex gap-2 border-b border-sidebar-border/70 pb-2"
                                >
                                    <button
                                        v-for="locale in props.locales"
                                        :key="locale"
                                        type="button"
                                        @click="activeLocale = locale"
                                        :class="[
                                            'rounded-t px-4 py-1.5 text-sm font-medium transition-colors',
                                            activeLocale === locale
                                                ? 'bg-primary text-primary-foreground'
                                                : 'bg-muted text-muted-foreground hover:bg-muted/80',
                                        ]"
                                    >
                                        {{
                                            localeLabels[locale] ??
                                            locale.toUpperCase()
                                        }}
                                        <span
                                            :class="[
                                                'ml-1 inline-block h-2 w-2 rounded-full',
                                                form.translations[locale].title
                                                    ? 'bg-green-500'
                                                    : 'bg-gray-300',
                                            ]"
                                        />
                                    </button>
                                </div>

                                <template
                                    v-for="locale in props.locales"
                                    :key="locale"
                                >
                                    <div
                                        v-show="activeLocale === locale"
                                        class="flex flex-col gap-7"
                                    >
                                        <Field>
                                            <FieldLabel
                                                :for="`title-${locale}`"
                                            >
                                                Tytuł wpisu
                                                <span
                                                    v-if="locale === 'pl'"
                                                    class="text-destructive"
                                                    >*</span
                                                >
                                            </FieldLabel>
                                            <Input
                                                :id="`title-${locale}`"
                                                type="text"
                                                v-model="
                                                    form.translations[locale]
                                                        .title
                                                "
                                                :placeholder="
                                                    locale === 'pl'
                                                        ? 'Pole obowiązkowe'
                                                        : 'Pole nieobowiązkowe'
                                                "
                                            />
                                            <FieldError
                                                v-if="
                                                    translationError(
                                                        locale,
                                                        'title',
                                                    )
                                                "
                                            >
                                                {{
                                                    translationError(
                                                        locale,
                                                        'title',
                                                    )
                                                }}
                                            </FieldError>
                                        </Field>

                                        <Field>
                                            <FieldLabel :for="`slug-${locale}`"
                                                >Slug (adres URL)</FieldLabel
                                            >
                                            <Input
                                                :id="`slug-${locale}`"
                                                type="text"
                                                v-model="
                                                    form.translations[locale]
                                                        .slug
                                                "
                                                placeholder="Zostaw puste — zostanie wygenerowany automatycznie"
                                            />
                                            <FieldError
                                                v-if="
                                                    translationError(
                                                        locale,
                                                        'slug',
                                                    )
                                                "
                                            >
                                                {{
                                                    translationError(
                                                        locale,
                                                        'slug',
                                                    )
                                                }}
                                            </FieldError>
                                        </Field>

                                        <Field>
                                            <FieldLabel :for="`intro-${locale}`"
                                                >Wstęp do wpisu</FieldLabel
                                            >
                                            <Textarea
                                                :id="`intro-${locale}`"
                                                v-model="
                                                    form.translations[locale]
                                                        .intro
                                                "
                                                placeholder="Pole nieobowiązkowe"
                                            />
                                            <FieldError
                                                v-if="
                                                    translationError(
                                                        locale,
                                                        'intro',
                                                    )
                                                "
                                            >
                                                {{
                                                    translationError(
                                                        locale,
                                                        'intro',
                                                    )
                                                }}
                                            </FieldError>
                                        </Field>

                                        <Field>
                                            <FieldLabel
                                                :for="`content-${locale}`"
                                                >Zawartość wpisu</FieldLabel
                                            >
                                            <Editor
                                                :id="`content-${locale}`"
                                                v-model="
                                                    form.translations[locale]
                                                        .content
                                                "
                                                placeholder="Pole nieobowiązkowe"
                                            />
                                            <FieldError
                                                v-if="
                                                    translationError(
                                                        locale,
                                                        'content',
                                                    )
                                                "
                                            >
                                                {{
                                                    translationError(
                                                        locale,
                                                        'content',
                                                    )
                                                }}
                                            </FieldError>
                                        </Field>

                                        <Field>
                                            <FieldLabel
                                                :for="`site_description-${locale}`"
                                                >Opis wpisu (SEO)</FieldLabel
                                            >
                                            <Input
                                                :id="`site_description-${locale}`"
                                                type="text"
                                                v-model="
                                                    form.translations[locale]
                                                        .site_description
                                                "
                                                placeholder="Pole nieobowiązkowe"
                                            />
                                            <FieldError
                                                v-if="
                                                    translationError(
                                                        locale,
                                                        'site_description',
                                                    )
                                                "
                                            >
                                                {{
                                                    translationError(
                                                        locale,
                                                        'site_description',
                                                    )
                                                }}
                                            </FieldError>
                                        </Field>

                                        <Field>
                                            <FieldLabel
                                                :for="`site_keyword-${locale}`"
                                                >Słowa kluczowe
                                                (SEO)</FieldLabel
                                            >
                                            <Input
                                                :id="`site_keyword-${locale}`"
                                                type="text"
                                                v-model="
                                                    form.translations[locale]
                                                        .site_keyword
                                                "
                                                placeholder="Pole nieobowiązkowe"
                                            />
                                            <FieldError
                                                v-if="
                                                    translationError(
                                                        locale,
                                                        'site_keyword',
                                                    )
                                                "
                                            >
                                                {{
                                                    translationError(
                                                        locale,
                                                        'site_keyword',
                                                    )
                                                }}
                                            </FieldError>
                                        </Field>
                                    </div>
                                </template>
                            </div>

                            <!-- Grafiki -->
                            <Field class="mb-6">
                                <FieldLabel for="imgFile">Grafika 1</FieldLabel>
                                <Input
                                    id="imgFile"
                                    name="imgFile"
                                    type="file"
                                    @input="handleFileInput"
                                />
                                <FieldError v-if="form.errors.imgFile">{{
                                    form.errors.imgFile
                                }}</FieldError>
                                <progress
                                    v-if="form.progress"
                                    :value="form.progress.percentage"
                                    max="100"
                                >
                                    {{ form.progress.percentage }}%
                                </progress>
                            </Field>

                            <Field class="mb-6">
                                <FieldLabel for="imgFile1"
                                    >Grafika 2</FieldLabel
                                >
                                <Input
                                    id="imgFile1"
                                    name="imgFile1"
                                    type="file"
                                    @input="handleFileInput1"
                                />
                                <FieldError v-if="form.errors.imgFile1">{{
                                    form.errors.imgFile1
                                }}</FieldError>
                                <progress
                                    v-if="form.progress"
                                    :value="form.progress.percentage"
                                    max="100"
                                >
                                    {{ form.progress.percentage }}%
                                </progress>
                            </Field>

                            <!-- Ustawienia -->
                            <Field>
                                <div class="flex items-center gap-3">
                                    <Checkbox
                                        id="approved"
                                        name="approved"
                                        v-model="form.approved"
                                    />
                                    <FieldLabel for="approved"
                                        >Zaakceptowano</FieldLabel
                                    >
                                </div>
                            </Field>
                            <Field>
                                <div class="flex items-center gap-3">
                                    <Checkbox
                                        id="published"
                                        name="published"
                                        v-model="form.published"
                                    />
                                    <FieldLabel for="published"
                                        >Opublikowano</FieldLabel
                                    >
                                </div>
                            </Field>
                            <Field>
                                <div class="flex items-center gap-3">
                                    <Checkbox
                                        id="comments_allowed"
                                        name="comments_allowed"
                                        v-model="form.comments_allowed"
                                    />
                                    <FieldLabel for="comments_allowed"
                                        >Komentarze dozwolone</FieldLabel
                                    >
                                </div>
                            </Field>
                        </FieldGroup>

                        <ButtonGroup>
                            <Button variant="outline" as-child>
                                <Link :href="index().url"
                                    ><ArrowLeftIcon />Powrót</Link
                                >
                            </Button>
                            <Button
                                type="submit"
                                variant="outline"
                                :disabled="form.processing"
                            >
                                <SendIcon />Wyślij
                            </Button>
                        </ButtonGroup>
                    </FieldSet>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
