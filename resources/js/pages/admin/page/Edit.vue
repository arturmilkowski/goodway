<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ArrowLeftIcon, SendIcon, Trash2Icon } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import ImgController from '@/actions/App/Http/Controllers/Admin/Page/ImgController';
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
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput,
} from '@/components/ui/number-field';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
    SelectLabel,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { show, update, edit, destroy } from '@/routes/admin/pages';
import type { BreadcrumbItem } from '@/types';

interface Translation {
    id: number | null;
    locale: string;
    slug: string;
    title: string;
    intro: string;
    content: string;
    site_description: string;
    site_keyword: string;
}

interface Page {
    id: number;
    parent_id: string | null;
    img: string | null;
    img1: string | null;
    navbar: boolean;
    hide: boolean;
    ordinal: number;
    translations: Translation[];
}

const props = defineProps<{
    page: Page;
    pages: Page[];
    locales: string[];
    path: string;
}>();

//  Zakładki języków
const activeLocale = ref(props.locales[0] ?? 'pl');

const localeLabels: Record<string, string> = {
    pl: '🇵🇱 PL',
    en: '🇬🇧 EN',
    de: '🇩🇪 DE',
};

// znajdź tłumaczenie dla danego locale lub zwróć pusty obiekt
function findTranslation(locale: string): Translation {
    return (
        props.page.translations?.find((t) => t.locale === locale) ?? {
            id: null,
            locale,
            slug: '',
            title: '',
            intro: '',
            content: '',
            site_description: '',
            site_keyword: '',
        }
    );
}

// Budowa obiektu translations dla useForm
const initialTranslations = Object.fromEntries(
    props.locales.map((locale) => [locale, findTranslation(locale)]),
) as Record<string, Translation>;

const form = useForm<{
    parent_id: string | null;
    img: string | null;
    img1: string | null;
    imgFile: File | null;
    imgFile1: File | null;
    navbar: boolean;
    hide: boolean;
    ordinal: number;
    translations: Record<string, Translation>;
}>({
    parent_id: props.page?.parent_id,
    img: props.page?.img,
    img1: props.page?.img1,
    imgFile: null,
    imgFile1: null,
    navbar: props.page?.navbar,
    hide: props.page?.hide,
    ordinal: props.page?.ordinal ?? 1,
    translations: initialTranslations,
});

// Skrót do tłumaczenia aktywnego języka (dla czytelności w template)
const t = computed(() => form.translations[activeLocale.value]);

// Obsługa błędów per język
// Laravel zwróci np. errors['translations.pl.title']
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

const destroy_ = () => {
    if (confirm('Na pewno?')) {
        form.delete(destroy(props.page?.id).url);
    }
};

const destroyImg = (pageId: number, imgId: number) => {
    if (confirm('Na pewno?')) {
        router.delete(ImgController(pageId).url, {
            data: { img_id: imgId },
        });
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Edycja podstrony',
        href: edit(props.page?.id).url,
    },
];
</script>

<template>
    <Head title="Edycja podstrony" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                <form @submit.prevent="form.put(update(props.page?.id).url)">
                    {{ form.errors }}
                    <FieldSet>
                        <FieldGroup>
                            <Field>
                                <FieldLabel for="parent_id">
                                    Strona &mdash; rodzic
                                </FieldLabel>
                                <Select v-model="form.parent_id">
                                    <SelectTrigger class="w-[200px]">
                                        <SelectValue
                                            placeholder="Brak rodzica"
                                        />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectLabel>Strony</SelectLabel>
                                            <SelectItem
                                                v-for="page in props.pages"
                                                :key="page.id"
                                                :value="page.id"
                                            >
                                                {{
                                                    page.translations?.find(
                                                        (t) =>
                                                            t.locale === 'pl',
                                                    )?.title ?? '—'
                                                }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                            </Field>

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
                                    </button>
                                </div>

                                <template
                                    v-for="locale in props.locales"
                                    :key="locale"
                                >
                                    <div v-show="activeLocale === locale">
                                        <Field>
                                            <FieldLabel
                                                :for="`title-${locale}`"
                                            >
                                                Tytuł podstrony
                                            </FieldLabel>
                                            <Input
                                                :id="`title-${locale}`"
                                                type="text"
                                                v-model="
                                                    form.translations[locale]
                                                        .title
                                                "
                                                placeholder="Pole obowiązkowe"
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
                                            <FieldLabel :for="`slug-${locale}`">
                                                Slug (adres URL)
                                            </FieldLabel>
                                            <Input
                                                :id="`slug-${locale}`"
                                                type="text"
                                                v-model="
                                                    form.translations[locale]
                                                        .slug
                                                "
                                                placeholder="np. o-nas"
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
                                            <FieldLabel
                                                :for="`intro-${locale}`"
                                            >
                                                Wstęp do podstrony
                                            </FieldLabel>
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
                                            >
                                                Zawartość podstrony
                                            </FieldLabel>
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
                                            >
                                                Opis podstrony (SEO)
                                            </FieldLabel>
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
                                            >
                                                Słowa kluczowe (SEO)
                                            </FieldLabel>
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

                            <div v-if="page?.img">
                                <img :src="path + '/' + page.img" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(page?.id, 1)"
                                >
                                    <Trash2Icon />
                                    Usuń grafikę 1
                                </Button>
                            </div>
                            <Field class="mb-6">
                                <FieldLabel for="imgFile">Grafika 1</FieldLabel>
                                <Input
                                    id="imgFile"
                                    name="imgFile"
                                    type="file"
                                    @input="handleFileInput"
                                />
                                <FieldError v-if="form.errors.imgFile">
                                    {{ form.errors.imgFile }}
                                </FieldError>
                                <progress
                                    v-if="form.progress"
                                    :value="form.progress.percentage"
                                    max="100"
                                >
                                    {{ form.progress.percentage }}%
                                </progress>
                            </Field>

                            <div v-if="page?.img1">
                                <img :src="path + '/' + page.img1" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(page?.id, 2)"
                                >
                                    <Trash2Icon />
                                    Usuń grafikę 2
                                </Button>
                            </div>
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
                                <FieldError v-if="form.errors.imgFile1">
                                    {{ form.errors.imgFile1 }}
                                </FieldError>
                                <progress
                                    v-if="form.progress"
                                    :value="form.progress.percentage"
                                    max="100"
                                >
                                    {{ form.progress.percentage }}%
                                </progress>
                            </Field>

                            <Field>
                                <div class="flex items-center gap-3">
                                    <Checkbox
                                        id="navbar"
                                        name="navbar"
                                        v-model="form.navbar"
                                    />
                                    <FieldLabel for="navbar">
                                        Umieść w menu głównym
                                    </FieldLabel>
                                </div>
                            </Field>

                            <Field>
                                <div class="flex items-center gap-3">
                                    <Checkbox
                                        id="hide"
                                        name="hide"
                                        v-model="form.hide"
                                    />
                                    <FieldLabel for="hide">
                                        Ukryj podstronę
                                    </FieldLabel>
                                </div>
                            </Field>

                            <Field>
                                <FieldLabel for="ordinal">Kolejność</FieldLabel>
                                <NumberField
                                    id="ordinal"
                                    name="ordinal"
                                    v-model="form.ordinal"
                                    min="1"
                                    max="99"
                                    step="1"
                                >
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput placeholder="1" />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <FieldError v-if="form.errors.ordinal">
                                    {{ form.errors.ordinal }}
                                </FieldError>
                            </Field>
                        </FieldGroup>

                        <ButtonGroup>
                            <Button variant="outline" as-child>
                                <Link :href="show(page?.id).url">
                                    <ArrowLeftIcon />
                                    Powrót
                                </Link>
                            </Button>
                            <Button type="submit" variant="outline">
                                <SendIcon />
                                Wyślij
                            </Button>
                            <Button
                                type="button"
                                variant="destructive"
                                @click="destroy_"
                            >
                                <Trash2Icon />
                                Usuń
                            </Button>
                        </ButtonGroup>
                    </FieldSet>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
