<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { ArrowLeftIcon, SendIcon, Trash2Icon } from 'lucide-vue-next';
import ImgController from '@/actions/App/Http/Controllers/Admin/Project/ImgController';
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
import { Tabs, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { show, update, edit, destroy } from '@/routes/admin/projects';
import type { BreadcrumbItem } from '@/types';

interface Translation {
    id: number | null;
    locale: string;
    slug: string;
    title: string;
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

const props = defineProps<{
    project: Project;
    locales: string[];
    path: string;
}>();

const activeLocale = ref(props.locales[0] ?? 'pl');

const localeLabels: Record<string, string> = {
    pl: '🇵🇱 PL',
    en: '🇬🇧 EN',
    de: '🇩🇪 DE',
};

function findTranslation(locale: string): Translation {
    return (
        props.project.translations?.find((t) => t.locale === locale) ?? {
            id: null,
            locale,
            slug: '',
            title: '',
            intro: '',
            content: '',
            result: '',
            site_description: '',
            site_keyword: '',
        }
    );
}

const initialTranslations = Object.fromEntries(
    props.locales.map((locale) => [locale, findTranslation(locale)]),
) as Record<string, Translation>;

const form = useForm<{
    img: string | null;
    img1: string | null;
    imgFile: File | null;
    imgFile1: File | null;
    approved: boolean;
    hide: boolean;
    translations: Record<string, Translation>;
}>({
    img: props.project?.img,
    img1: props.project?.img1,
    imgFile: null,
    imgFile1: null,
    approved: props.project?.approved,
    hide: props.project?.hide,
    translations: initialTranslations,
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

const destroy_ = () => {
    if (confirm('Na pewno?')) {
        form.delete(destroy(props.project?.id).url);
    }
};

const destroyImg = (projectId: number, imgId: number) => {
    if (confirm('Na pewno?')) {
        router.delete(ImgController(projectId).url, {
            data: { img_id: imgId },
        });
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Edycja projektu', href: edit(props.project?.id).url },
];
</script>

<template>
    <Head title="Edycja projektu" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 p-4 md:min-h-min dark:border-sidebar-border"
            >
                <form @submit.prevent="form.put(update(props.project?.id).url)">
                    <FieldSet>
                        <FieldGroup>
                            <!-- Zakładki języków -->
                            <Tabs
                                :default-value="locales[0]"
                                @update:model-value="
                                    activeLocale = $event as string
                                "
                            >
                                <TabsList>
                                    <TabsTrigger
                                        v-for="locale in props.locales"
                                        :key="locale"
                                        :value="locale"
                                    >
                                        {{
                                            localeLabels[locale] ??
                                            locale.toUpperCase()
                                        }}
                                        <span
                                            :class="[
                                                'ml-1.5 inline-block h-2 w-2 rounded-full',
                                                form.translations[locale].title
                                                    ? 'bg-green-500'
                                                    : 'bg-gray-300',
                                            ]"
                                        />
                                    </TabsTrigger>
                                </TabsList>

                                <div
                                    v-for="locale in props.locales"
                                    :key="locale"
                                    v-show="activeLocale === locale"
                                    class="mt-4 flex flex-col gap-7"
                                >
                                    <Field>
                                        <FieldLabel :for="`title-${locale}`">
                                            Tytuł projektu
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
                                                form.translations[locale].title
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
                                                form.translations[locale].slug
                                            "
                                            placeholder="Zostaw puste — zostanie wygenerowany automatycznie"
                                        />
                                        <FieldError
                                            v-if="
                                                translationError(locale, 'slug')
                                            "
                                        >
                                            {{
                                                translationError(locale, 'slug')
                                            }}
                                        </FieldError>
                                    </Field>

                                    <Field>
                                        <FieldLabel :for="`intro-${locale}`"
                                            >Wstęp do projektu</FieldLabel
                                        >
                                        <Textarea
                                            :id="`intro-${locale}`"
                                            v-model="
                                                form.translations[locale].intro
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
                                        <FieldLabel :for="`content-${locale}`"
                                            >Cel projektu</FieldLabel
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
                                        <FieldLabel :for="`result-${locale}`"
                                            >Rezultat</FieldLabel
                                        >
                                        <Textarea
                                            :id="`result-${locale}`"
                                            v-model="
                                                form.translations[locale].result
                                            "
                                            placeholder="Pole nieobowiązkowe"
                                        />
                                        <FieldError
                                            v-if="
                                                translationError(
                                                    locale,
                                                    'result',
                                                )
                                            "
                                        >
                                            {{
                                                translationError(
                                                    locale,
                                                    'result',
                                                )
                                            }}
                                        </FieldError>
                                    </Field>

                                    <Field>
                                        <FieldLabel
                                            :for="`site_description-${locale}`"
                                            >Opis projektu (SEO)</FieldLabel
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
                                            >Słowa kluczowe (SEO)</FieldLabel
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
                            </Tabs>

                            <!-- Grafiki -->
                            <div v-if="project?.img">
                                <img :src="path + '/' + project.img" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(project?.id, 1)"
                                >
                                    <Trash2Icon />Usuń grafikę 1
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

                            <div v-if="project?.img1">
                                <img :src="path + '/' + project.img1" />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    @click="destroyImg(project?.id, 2)"
                                >
                                    <Trash2Icon />Usuń grafikę 2
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
                                        id="hide"
                                        name="hide"
                                        v-model="form.hide"
                                    />
                                    <FieldLabel for="hide">Ukryj</FieldLabel>
                                </div>
                            </Field>
                        </FieldGroup>

                        <ButtonGroup>
                            <Button variant="outline" as-child>
                                <Link :href="show(project?.id).url"
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
                            <Button
                                type="button"
                                variant="destructive"
                                :disabled="form.processing"
                                @click="destroy_"
                            >
                                <Trash2Icon />Usuń
                            </Button>
                        </ButtonGroup>
                    </FieldSet>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
